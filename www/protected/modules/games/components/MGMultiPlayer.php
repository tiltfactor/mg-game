<?php
/**
 *
 * @package
 */
abstract class MGMultiPlayer extends CComponent
{
    /**
     * @var MGGameModel
     */
    protected $game;
    /**
     * @var string
     */
    protected $apiId;
    /**
     * @var int
     */
    protected $sessionId;

    /**
     * @var GameTurnDTO
     */
    protected $gameTurn;

    /**
     * @var GamePlayer
     */
    protected $gamePlayer;

    /**
     * @var array
     */
    protected $mediaTypes = array("image");

    function __construct($unique_id, $active = true)
    {
        $this->apiId = Yii::app()->fbvStorage->get("api_id", "MG_API");
        $this->sessionId = (int)Yii::app()->session[$this->apiId . '_SESSION_ID'];

        if (!($this->sessionId > 0)) {
            throw new CHttpException(400, Yii::t('app', 'Authentication required.'));
        }

        $this->game = GamesModule::loadGameFromDB($unique_id);
        $this->game->fbvLoad();

        $this->gamePlayer = GamePlayer::model()->with(array('session', 'playedGame'))->find('session_id =:sessionId AND t.game_id=:gameId', array(':sessionId' => $this->sessionId, ':gameId' => $this->game->id));

        if (isset($this->gamePlayer->playedGame)) {
            $playedGameTurn = PlayedGameTurnInfo::model()->find('played_game_id=:playedId ORDER BY turn DESC LIMIT 1', array(':playedId' => $this->gamePlayer->playedGame->id));
            if ($playedGameTurn) {
                $this->gameTurn = unserialize($playedGameTurn->data);
            }
        }
    }

    /**
     * @abstract
     * @param GameTagDTO[] $tags
     */
    abstract public function submit(&$tags);

    /**
     * Allows to implement weighting of the submitted tags. Here you should usually
     * provide hooks to the setWeight methods of the dictionary and weighting plugins.
     *
     * @param GameTagDTO[] tags submitted by the player for each media
     * @return GameTagDTO[] the tags (with additional weight information)
     */
    protected function setWeights($tags)
    {
        // call the set setWeights method of all activated dictionary plugins
        $plugins = PluginsModule::getActiveGamePlugins($this->game->id, "dictionary");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "setWeights")) {
                    // influence the weight of the tags
                    $result = $plugin->component->setWeights($this->game, GameTagDTO::convertToArray($tags));
                    $tags = GameTagDTO::createFromArray($result);
                }
            }
        }

        $plugins = PluginsModule::getActiveGamePlugins($this->game->game_id, "weighting");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "setWeights")) {
                    // influence the weight of the tags
                    $tags = $plugin->component->setWeights($this->game, GameTagDTO::convertToArray($tags));
                }
            }
        }
        return $tags;
    }

    /**
     * This method should hold the implementation that allows the scoring
     * of the turn's submitted tags.
     *
     * @param GameTagDTO[] $tags
     * @return int the score for this turn
     */
    protected function getScore($tags)
    {
        $score = 0;

        // call the set score method of all activated weighting plugins
        $plugins = PluginsModule::getActiveGamePlugins($this->game->game_id, "weighting");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "score")) {
                    $score = $plugin->component->score($$this->game,GameTagDTO::convertToArray($tags),$score);
                }
            }
        }
        return $score;
    }

    /**
     * @return GameDTO
     */
    public function getGameInfo()
    {
        $gameDTO = new GameDTO();
        $gameDTO->baseUrl = Yii::app()->getRequest()->getHostInfo();
        $gameDTO->gameBaseUrl = Yii::app()->createUrl('games/' . $this->game->unique_id);
        $gameDTO->apiBaseUrl = Yii::app()->getRequest()->getHostInfo() . Yii::app()->createUrl('/api');
        $gameDTO->gameImageUrl = GamesModule::getAssetsUrl() . '/' . strtolower($this->game->unique_id) . '/images/' . (isset($this->game->arcade_image) ? $this->game->arcade_image : '');
        $gameDTO->name = $this->game->name;
        $gameDTO->turns = $this->game->turns;
        $gameDTO->description = $this->game->description;
        $gameDTO->uniqueId = $this->game->unique_id;
        return $gameDTO;
    }

    /**
     * @return GameUserDTO
     */
    public function getUserInfo()
    {
        $userDTO = new GameUserDTO();
        $userDTO->username = Yii::app()->user->name;
        $userDTO->scores = 0;
        $userDTO->numberPlayed = 0;
        if (!Yii::app()->user->isGuest && (isset($this->game->id))) {
            $game_info = GamesModule::loadUserToGameInfo(Yii::app()->user->id, $this->game->id);
            if ($game_info) {
                $userDTO->scores = $game_info->score;
                $userDTO->numberPlayed = $game_info->number_played;
            }
        }
        return $userDTO;
    }

    /**
     * @return boolean
     */
    public function registerGamePlayer()
    {
        $gamePlayer = new GamePlayer();
        $gamePlayer->session_id = $this->sessionId;
        $gamePlayer->game_id = $this->game->id;
        $gamePlayer->created = date('Y-m-d H:i:s');
        $gamePlayer->status = GamePlayer::STATUS_WAIT;

        if ($gamePlayer->save()) {
            return true;
        }
        return false;
    }

    /**
     * Attempts to pair the waiting player with a second one.
     *
     * @param string $username
     * @return GameUserDTO
     */
    public function requestPair($username)
    {
        $opponent = null;

        Yii::app()->db->createCommand("LOCK TABLES {{game_player}} WRITE,{{game_player}} gp WRITE")->execute();

        $player = null;
        $criteria = new CDbCriteria;
        $criteria->alias = 'gp';
        if ($username && !empty($username)) {
            $criteria->join = "  LEFT JOIN {{session}} s ON s.id=gp.session_id";
            $criteria->condition = 'gp.game_id = :gameID AND gp.session_id <> :sessionID AND s.username=:username AND gp.status=:status';
            $criteria->params = array(":gameID" => $this->game->id, ":sessionID" => $this->sessionId, ":username" => $username, ":status" => GamePlayer::STATUS_WAIT);
        } else {
            $criteria->condition = 'gp.game_id = :gameID AND gp.session_id <> :sessionID AND gp.status=:status';
            $criteria->params = array(":gameID" => $this->game->id, ":sessionID" => $this->sessionId, ":username" => $username, ":status" => GamePlayer::STATUS_WAIT);
        }
        $player = GamePlayer::model()->with('session')->find($criteria);
        if ($player) {
            $player->status = GamePlayer::STATUS_PAIR;
            if ($player->update()) {
                //todo: send push notification
                $currentPlayer = GamePlayer::model()->find('session_id =:sessionId', array(':sessionId' => $this->sessionId));
                $currentPlayer->status = GamePlayer::STATUS_PAIR;
                if ($currentPlayer->save()) {
                    $opponent = new GameUserDTO();
                    $opponent->id = $player->session_id;
                    $opponent->username = $player->session->username;
                }
            }
        }
        Yii::app()->db->createCommand("UNLOCK TABLES")->execute();
        return $opponent;
    }

    public function pair($sessionId)
    {
        $playedGameId = $this->createPlayedGame($this->sessionId, $sessionId, $this->game->id);
        $this->game->saveCounters(array('number_played' => 1));

        $oponent = GamePlayer::model()->find('session_id =:sessionId', array(':sessionId' => $sessionId));
        $player = GamePlayer::model()->find('session_id =:sessionId', array(':sessionId' => $this->sessionId));

        $oponent->status = GamePlayer::STATUS_PLAY;
        $oponent->played_game_id = $playedGameId;
        if (!$oponent->save()) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $player->status = GamePlayer::STATUS_PLAY;
        $player->played_game_id = $playedGameId;
        if (!$player->save()) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $this->createGameTurn();


        // todo: send push notification
    }

    /**
     * @param int $sessionId
     * @throws CHttpException
     */
    public function rejectPair($sessionId)
    {
        $oponent = GamePlayer::model()->find('session_id =:sessionId', array(':sessionId' => $sessionId));

        $player = GamePlayer::model()->find('session_id =:sessionId', array(':sessionId' => $this->sessionId));

        $oponent->status = GamePlayer::STATUS_WAIT;
        if (!$oponent->save()) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $player->status = GamePlayer::STATUS_WAIT;
        if (!$player->save()) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }


        // todo: send push notification
    }

    /**
     * @param GameTagDTO[] $tags
     * @return bool
     * @throws CHttpException
     */
    protected function saveSubmission($tags)
    {
        if (isset($tags) && is_array($tags) && count($tags) > 0) {
            $tagsArr = GameTagDTO::convertToArray($tags);
            $submit = new GameSubmission;
            $submit->submission = json_encode($tagsArr);
            $submit->turn = $this->gameTurn->turn;
            $submit->session_id = $this->sessionId;
            $submit->played_game_id = $this->gamePlayer->played_game_id;
            $submit->created = date('Y-m-d H:i:s');

            if ($submit->validate()) {
                $submit->save();
                MGTags::saveTags($tagsArr, $submit->id);
                return true;
            } else {
                throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
            }
        }
        return false;
    }

    /**
     * @return bool
     * @throws CHttpException
     */
    protected function createGameTurn()
    {
        $turn = new GameTurnDTO();
        $turn->turn = 1;
        $turn->score = 0;
        $turn->tags = array();
        $turn->media = array();
        $turn->wordsToAvoid = array();

        if ($this->gameTurn) {
            $turn->turn = $this->gameTurn->turn + 1;
        }

        if ($turn->turn <= $this->game->turns) {
            $media = $this->getMedia();
            if ($media == null) {
                throw new CHttpException(500, Yii::t('app', 'Not enough medias available!'));
            }
            array_push($turn->media, $media);
            $this->setUsedMedias(array($media->id));

            $this->game->loadWordsToAvoid($this->getUsedMedias());
            $turn->wordsToAvoid = $this->game->wordsToAvoid;

            $turnToDb = new PlayedGameTurnInfo();
            $turnToDb->played_game_id = $this->gamePlayer->played_game_id;
            $turnToDb->turn = $turn->turn;
            $turnToDb->data = serialize($turn);
            $turnToDb->created_by_session_id = $this->sessionId;

            if ($turnToDb->save()) {
                $this->gameTurn = $turn;
                return true;
            }
        }
        return false;
    }

    /**
     * This method get one random media that are available for the user.
     *
     * @return null|GameMediaDTO
     */
    protected function getMedia()
    {
        $usedMedias = $this->getUsedMedias();

        if (Yii::app()->user->isGuest) {
            $where = array('and', 'i.locked=1', '(inst.status=1 or i.institution_id is null)', array('not in', 'i.id', $usedMedias));
            if (is_array($this->mediaTypes) && count($this->mediaTypes) > 0) {
                $where_add = '(';
                $num_types = count($this->mediaTypes);
                $i = 0;
                foreach ($this->mediaTypes as $mime_type) {
                    if ($i < $num_types && $i > 0) {
                        $where_add .= " or ";
                    }
                    $where_add .= "LEFT( i.mime_type, 5) = '$mime_type'";
                    $i++;
                }
                $where_add .= ')';
                $where[] = $where_add;
            }
            $media = Yii::app()->db->createCommand()
                ->selectDistinct('i.id, i.name, i.mime_type, is.licence_id, (i.last_access IS NULL OR i.last_access <= now()-is.last_access_interval) as last_access_ok,inst.url')
                ->from('{{collection_to_media}} is2i')
                ->join('{{media}} i', 'i.id=is2i.media_id')
                ->join('{{collection}} is', 'is.id=is2i.collection_id')
                ->leftJoin('{{institution}} inst', 'inst.id=i.institution_id')
                ->where($where)
                ->order('RAND()')
                ->limit(1)
                ->queryAll();
        } else {
            // if a player is logged in the medias should be weight by interest
            $where = array('and', '(usm.user_id IS NULL OR usm.user_id=:userID)', 'i.locked=1', '(inst.status=1 or i.institution_id is null)', array('not in', 'i.id', $usedMedias));

            if (is_array($this->mediaTypes) && count($this->mediaTypes) > 0) {
                $where_add = '(';
                $num_types = count($this->mediaTypes);
                $i = 0;
                foreach ($this->mediaTypes as $mime_type) {
                    if ($i < $num_types && $i > 0) {
                        $where_add .= " or ";
                    }
                    $where_add .= "LEFT( i.mime_type, 5) = '$mime_type'";
                    $i++;
                }
                $where_add .= ')';
                $where[] = $where_add;
            }
            $media = Yii::app()->db->createCommand()
                ->selectDistinct('i.id, i.name, i.mime_type, is.licence_id, MAX(usm.interest) as max_interest, (i.last_access IS NULL OR i.last_access <= now()-is.last_access_interval) as last_access_ok,inst.url')
                ->from('{{collection_to_media}} is2i')
                ->join('{{media}} i', 'i.id=is2i.media_id')
                ->join('{{collection}} is', 'is.id=is2i.collection_id')
                ->leftJoin('{{collection_to_subject_matter}} is2sm', 'is2sm.collection_id=is2i.collection_id')
                ->leftJoin('{{user_to_subject_matter}} usm', 'usm.subject_matter_id=is2sm.subject_matter_id')
                ->leftJoin('{{institution}} inst', 'inst.id=i.institution_id')
                ->where($where, array(':userID' => Yii::app()->user->id))
                ->group('i.id, i.name, is.licence_id')
                ->order('RAND()')
                ->limit(1)
                ->queryAll();
        }

        if ($media) {
            $mediaDTO = new GameMediaDTO();
            if ($media['url']) {
                $path = $media['url'] . Yii::app()->fbvStorage->get('settings.app_upload_url');
            } else {
                $path = Yii::app()->getBaseUrl(true) . Yii::app()->fbvStorage->get('settings.app_upload_url');
            }

            list($mediaType, $type_2) = explode("/", $media["mime_type"]);

            $mediaDTO->id = $media["id"];
            $mediaDTO->mimeType = $media["mime_type"];
            $mediaDTO->licence = $this->getLicenceInfo($media['licence_id']);

            if ($mediaType === "image") {
                $mediaDTO->thumbnail = $path . "/thumbs/" . $media["name"];
                $mediaDTO->imageFullSize = $path . "/images/" . $media["name"];
                //$scaled = $final_screen = $path . "/images/". urlencode($medias[$i]["name"]);
            } else if ($mediaType === "video") {
                $mediaDTO->thumbnail = $path . "/videos/" . urlencode(substr($media["name"], 0, -4) . "jpeg");
                $mediaDTO->videoWebm = $path . "/videos/" . urlencode($media["name"]);
                $mediaDTO->videoMp4 = $path . "/videos/" . urlencode(substr($media["name"], 0, -4) . "mp4");
            } else if ($mediaType === "audio") {
                $mediaDTO->thumbnail = Yii::app()->getBaseUrl(true) . "/images/audio.png";
                $mediaDTO->audioMp3 = $path . "/audios/" . urlencode($media["name"]);
                $mediaDTO->audioOgg = $path . "/audios/" . urlencode(substr($media["name"], 0, -3) . "ogg");
            }

            return $mediaDTO;
        } else {
            return null;
        }
    }

    /**
     * Returns the full distinct info about licences used on this turn.
     *
     * @param integer $id
     * @return GameLicenceDTO
     */
    protected function getLicenceInfo($id)
    {
        $data = Yii::app()->db->createCommand()
            ->selectDistinct('l.id, l.name, l.description')
            ->from('{{licence}} l')
            ->where('l.id=:id', array(':id' => $id))
            ->queryAll();
        $licence = new GameLicenceDTO();
        $licence->id = $data['id'];
        $licence->name = $data['name'];
        $licence->description = $data['description'];
        return $licence;
    }

    /**
     * Retrieve the IDs of all medias that have been seen/used by the current user
     * on a per game and per session basis.
     *
     * @return integer[] the ids of the medias that have been already seen by the current user in this session
     */
    protected function getUsedMedias()
    {
        $used_medias = array();
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (!isset(Yii::app()->session[$api_id . '_GAMES_USED_IMAGES'])) {
            Yii::app()->session[$api_id . '_GAMES_USED_IMAGES'] = array();
        } else {
            $arr_img = Yii::app()->session[$api_id . '_GAMES_USED_IMAGES'];
        }
        return $used_medias;
    }

    /**
     * Add medias to the used medias list stored in the current session for the currently
     * played game
     *
     * @param integer[] $usedMedias the medias that have been shown to the user
     */
    protected function setUsedMedias($usedMedias)
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");

        $arr_img = array();
        if (!isset(Yii::app()->session[$api_id . '_GAMES_USED_IMAGES'])) {
            Yii::app()->session[$api_id . '_GAMES_USED_IMAGES'] = $arr_img;
        } else {
            $arr_img = Yii::app()->session[$api_id . '_GAMES_USED_IMAGES'];
        }
        $arr_img = array_unique(array_merge($arr_img, $usedMedias));

        Media::model()->setLastAccess($usedMedias);

        Yii::app()->session[$api_id . '_GAMES_USED_IMAGES'] = $arr_img;
    }

    /**
     * @param int $session_id_1
     * @param int $session_id_2
     * @param int $game_id
     * @return int
     * @throws CHttpException
     */
    private function createPlayedGame($session_id_1, $session_id_2, $game_id)
    {
        $played_game = new PlayedGame;
        $played_game->session_id_1 = (int)$session_id_1;
        $played_game->session_id_2 = (int)$session_id_2;
        $played_game->game_id = $game_id;
        $played_game->created = date('Y-m-d H:i:s');
        $played_game->modified = date('Y-m-d H:i:s');

        if ($played_game->validate()) {
            $played_game->save();
        } else {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }
        return $played_game->id;
    }
}
