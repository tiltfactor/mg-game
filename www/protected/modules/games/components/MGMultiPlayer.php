<?php
/**
 *
 * @package
 */
abstract class MGMultiPlayer extends CComponent
{
    const PUSH_CHALLENGE = "challenge";
    const PUSH_REJECT_CHALLENGE = "rejectChallenge";
    const PUSH_REQUEST_PAIR = "requestPair";
    const PUSH_REJECT_PAIR = "rejectPair";
    const PUSH_NEW_TURN = "newTurn";
    const PUSH_GAME_END = "gameEnd";
    const PUSH_PENALTY = "penalty";
    const PUSH_BONUS = "bonus";
    const PUSH_OPPONENT_WAITING = "opponentWaiting";


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
     * @var int
     */
    protected $userId;

    /**
     * @var GameTurnDTO
     */
    protected $gameTurn;

    /**
     * @var UserOnline
     */
    protected $userOnline;

    /**
     * @var PlayedGame
     */
    protected $playedGame;

    /**
     * @var array
     */
    protected $mediaTypes = array("image");

    function __construct($unique_id, $active = true, $playedId = -1)
    {
        $this->apiId = Yii::app()->fbvStorage->get("api_id", "MG_API");
        $this->sessionId = (int)Yii::app()->session[$this->apiId . '_SESSION_ID'];
        $this->game = GamesModule::loadGameFromDB($unique_id);
        $this->game->fbvLoad();

        if ($this->sessionId > 0) {
            if (Yii::app()->user->isGuest) {
                throw new CHttpException(400, Yii::t('app', 'Authentication required.'));
            }

            $this->userId = (int)Yii::app()->user->id;
            $this->userOnline = UserOnline::model()->with(array('session'))->find('session_id =:sessionId AND t.game_id=:gameId', array(':sessionId' => $this->sessionId, ':gameId' => $this->game->id));
        }

        if ($playedId > 0) {
            $this->playedGame = PlayedGame::model()->with('sessionId1', 'sessionId2')->findByPk($playedId);
            if ($this->playedGame->sessionId1->user_id == $this->userId) {
                $this->sessionId = $this->playedGame->session_id_1;
            } else {
                $this->sessionId = $this->playedGame->session_id_2;
            }
        } else if (isset($this->userOnline) && $this->userOnline->played_game_id) {
            $this->playedGame = PlayedGame::model()->with('sessionId1', 'sessionId2')->findByPk($this->userOnline->played_game_id);
        }

        if ($this->playedGame) {
            $playedGameTurn = PlayedGameTurnInfo::model()->find('played_game_id=:playedId ORDER BY turn DESC', array(':playedId' => $this->playedGame->id));
            if ($playedGameTurn) {
                $this->gameTurn = unserialize($playedGameTurn->data);
            }
        }
    }

    /**
     *   //setWeight
     *   //getScore
     *   //update played game score
     *   //set tag type
     *   //save submission
     *
     * @abstract
     * @param GameTagDTO[] $tags
     */
    abstract public function submit(&$tags);

    /**
     * User is no more online so do some cleanups
     *
     * @abstract
     * @param $userId
     */
    abstract public function disconnect($userId);

    abstract public function gameEnd();


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

        $plugins = PluginsModule::getActiveGamePlugins($this->game->id, "weighting");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "setWeights")) {
                    // influence the weight of the tags
                    $result = $plugin->component->setWeights($this->game, GameTagDTO::convertToArray($tags));
                    $tags = GameTagDTO::createFromArray($result);
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
    protected function getScore(&$tags)
    {
        $score = 0;

        // call the set score method of all activated weighting plugins
        $plugins = PluginsModule::getActiveGamePlugins($this->game->id, "weighting");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "score")) {
                    $score = $plugin->component->score($$this->game, GameTagDTO::convertToArray($tags), $score);
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
        $userDTO->id = $this->userId;
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
    public function registerUserOnline()
    {
        $online = new UserOnline();
        $online->user_id = $this->userId;
        $online->session_id = $this->sessionId;
        $online->game_id = $this->game->id;
        $online->created = date('Y-m-d H:i:s');
        $online->status = UserOnline::STATUS_WAIT;

        if ($online->save()) {
            $this->saveUserToGame(null);
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
            $criteria->params = array(":gameID" => $this->game->id, ":sessionID" => $this->sessionId, ":username" => $username, ":status" => UserOnline::STATUS_WAIT);
        } else {
            $criteria->condition = 'gp.game_id = :gameID AND gp.session_id <> :sessionID AND gp.status=:status';
            $criteria->params = array(":gameID" => $this->game->id, ":sessionID" => $this->sessionId, ":status" => UserOnline::STATUS_WAIT);
            $criteria->order = 'RAND()';
            $criteria->limit = 1;
        }
        $player = UserOnline::model()->with('session')->find($criteria);
        if ($player) {
            $player->status = UserOnline::STATUS_PAIR;
            if ($player->update()) {

                $userDTO = new GameUserDTO();
                $userDTO->id = $this->userId;
                $userDTO->username = $this->userOnline->session->username;
                ;
                $this->pushMessage($player->user_id, MGMultiPlayer::PUSH_REQUEST_PAIR, json_encode($userDTO));

                $currentPlayer = UserOnline::model()->find('session_id =:sessionId', array(':sessionId' => $this->sessionId));
                $currentPlayer->status = UserOnline::STATUS_PAIR;
                if ($currentPlayer->save()) {
                    $opponent = new GameUserDTO();
                    $opponent->id = $player->user_id;
                    $opponent->username = $player->session->username;
                }
            }
        }
        Yii::app()->db->createCommand("UNLOCK TABLES")->execute();
        return $opponent;
    }

    /**
     * @param $sessionId
     * @throws CHttpException
     */
    public function pair($sessionId)
    {
        $playedGameId = $this->createPlayedGame($this->sessionId, $sessionId, $this->game->id);
        $this->game->saveCounters(array('number_played' => 1));

        $oponent = UserOnline::model()->find('session_id =:sessionId', array(':sessionId' => $sessionId));
        $player = UserOnline::model()->find('session_id =:sessionId', array(':sessionId' => $this->sessionId));

        $oponent->status = UserOnline::STATUS_PLAY;
        $oponent->played_game_id = $playedGameId;
        if (!$oponent->save()) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $player->status = UserOnline::STATUS_PLAY;
        $player->played_game_id = $playedGameId;
        if (!$player->save()) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $this->createGameTurn();
    }

    /**
     * @param int $sessionId
     * @throws CHttpException
     */
    public function rejectPair($sessionId)
    {
        $oponent = UserOnline::model()->find('session_id =:sessionId', array(':sessionId' => $sessionId));

        $oponent->status = UserOnline::STATUS_WAIT;
        if (!$oponent->save()) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $this->userOnline->status = UserOnline::STATUS_WAIT;
        if (!$this->userOnline->save()) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $userDTO = new GameUserDTO();
        $userDTO->id = $this->userOnline->userId;
        $userDTO->username = $this->userOnline->session->username;
        $this->pushMessage($oponent->user_id, MGMultiPlayer::PUSH_REJECT_PAIR, json_encode($userDTO));
    }

    /**
     * @param GameTagDTO[] $tags
     * @return bool
     * @throws CHttpException
     */
    protected function saveSubmission($tags)
    {
        if (isset($tags) && is_array($tags) && count($tags) > 0 && isset($this->playedGame)) {
            $tagsArr = GameTagDTO::convertToArray($tags);
            $submit = new GameSubmission;
            $submit->submission = json_encode($tagsArr);
            $submit->turn = $this->gameTurn->turn;
            $submit->session_id = $this->sessionId;
            $submit->played_game_id = $this->playedGame->id;
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
     * Get new media file and create game turn
     * Send push notification to online users
     *
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
            $turnToDb->played_game_id = $this->playedGame->id;
            $turnToDb->turn = $turn->turn;
            $turnToDb->data = serialize($turn);
            $turnToDb->created_by_session_id = $this->sessionId;

            if ($turnToDb->save()) {
                $this->gameTurn = $turn;

                $this->pushMessage($this->playedGame->sessionId1->user_id, MGMultiPlayer::PUSH_NEW_TURN, json_encode($turn));
                $this->pushMessage($this->playedGame->sessionId2->user_id, MGMultiPlayer::PUSH_NEW_TURN, json_encode($turn));
            } else {
                $message = "";
                $errors = $turnToDb->getErrors();
                foreach ($errors as $field => $error) {
                    $message .= $error[0] . ";";
                }
                throw new CHttpException(500, $message);
            }
        } else {
            $this->gameEnd();
        }
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
            $result = Yii::app()->db->createCommand()
                ->selectDistinct('i.id, i.name, i.mime_type, is.licence_id, (i.last_access IS NULL OR i.last_access <= now()-is.last_access_interval) as last_access_ok,inst.url,inst.token')
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
            $result = Yii::app()->db->createCommand()
                ->selectDistinct('i.id, i.name, i.mime_type, is.licence_id, MAX(usm.interest) as max_interest, (i.last_access IS NULL OR i.last_access <= now()-is.last_access_interval) as last_access_ok,inst.url,inst.token')
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

        if ($result) {
            $media = $result[0];
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
     * Save user scores to game and number of played games
     * If scores is null create new record in database
     *
     * @param null $score
     * @throws CHttpException
     */
    protected function saveUserToGame($score = null)
    {
        if (!Yii::app()->user->isGuest) {
            $userToGame = UserToGame::model()->findByPk(array(
                "user_id" => $this->userId,
                "game_id" => $this->game->id,
            ));
            if ($userToGame) {
                if ($score != null) {
                    $userToGame->saveCounters(array('number_played' => 1, 'score' => $score));
                }
            } else {
                $userToGame = new UserToGame;
                $userToGame->user_id = Yii::app()->user->id;
                if ($score != null) {
                    $userToGame->score = $score;
                    $userToGame->number_played = 1;
                } else {
                    $userToGame->score = 0;
                    $userToGame->number_played = 0;
                }
                $userToGame->game_id = $this->game->id;
                if ($userToGame->validate()) { // final turn
                    $userToGame->save();
                } else {
                    throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
                }
            }
        }
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
            $played_game->save(false);
        } else {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $this->playedGame = PlayedGame::model()->with('sessionId1', 'sessionId2')->findByPk($played_game->id);
        return $played_game->id;
    }


    /* ************************************************************
   * Offline game flow public methods
   * challenge
   * acceptChallenge
   * rejectChallenge
   * getChallenges
   * getOfflineGames
   * getOfflineGameState
   *
   * */

    /**
     * @param $username
     * @return null|GameUserDTO
     * @throws CHttpException
     */
    public function challenge($username)
    {
        $opponent = null;

        $player = null;
        $criteria = new CDbCriteria;
        $criteria->alias = 'u';
        if ($username && !empty($username)) {
            $criteria->join = "  LEFT JOIN {{user_to_game}} utg ON utg.user_id=u.id";
            $criteria->condition = 'utg.game_id = :gameID AND u.username=:username  AND u.id <> :userID';
            $criteria->params = array(":gameID" => $this->game->id, ":username" => $username, ":userID" => $this->userId);
        } else {
            $criteria->join = "  LEFT JOIN {{user_to_game}} utg ON utg.user_id=u.id";
            $criteria->condition = 'utg.game_id = :gameID AND u.id <> :userID';
            $criteria->params = array(":gameID" => $this->game->id, ":userID" => $this->userId);
            $criteria->order = 'RAND()';
            $criteria->limit = 1;
        }
        $player = User::model()->find($criteria);
        if ($player) {
            $query = 'from_user_id =:fromUserId AND to_user_id=:toUserId AND game_id=:gameId AND type=:type';
            $msg = UserMessage::model()->find($query, array(':fromUserId' => $this->userId,
                ':toUserId' => $player->id,
                ':gameId' => $this->game->id,
                ':type' => UserMessage::TYPE_CHALLENGE));
            if ($msg) {
                return $opponent;
            }
            $msg = new UserMessage();
            $msg->from_user_id = $this->userId;
            $msg->to_user_id = $player->id;
            $msg->game_id = $this->game->id;
            $msg->type = UserMessage::TYPE_CHALLENGE;
            $opponent = new GameUserDTO();
            $opponent->id = $player->id;
            $opponent->username = $player->username;

            $challenger = new GameUserDTO();
            $challenger->id = $this->userId;
            $challenger->username = $this->userOnline->session->username;

            $msg->message = serialize($challenger);

            if ($msg->save()) {
                $userOnline = UserOnline::model()->find('user_id =:userId', array(':userId' => $player->id));
                if ($userOnline) {
                    $this->pushMessage($player->id, MGMultiPlayer::PUSH_CHALLENGE, json_encode($challenger));
                }

                return $opponent;
            } else {
                $message = "";
                $errors = $msg->getErrors();
                foreach ($errors as $field => $error) {
                    $message .= $error[0] . ";";
                }
                throw new CHttpException(500, $message);
            }
        }

        return $opponent;
    }

    /**
     * @param $opponentId
     * @throws CHttpException
     */
    public function acceptChallenge($opponentId)
    {
        $query = 'from_user_id =:fromUserId AND to_user_id=:toUserId AND game_id=:gameId AND type=:type';
        $msg = UserMessage::model()->find($query, array(':fromUserId' => $opponentId,
            ':toUserId' => $this->userId,
            ':gameId' => $this->game->id,
            ':type' => UserMessage::TYPE_CHALLENGE));
        if ($msg) {
            $opponentOnline = UserOnline::model()->find('user_id =:userId', array(':userId' => $opponentId));
            $opponenSessId = 0;
            if ($opponentOnline) {
                $opponenSessId = $opponentOnline->session_id;
            } else {
                $opponentSess = Session::model()->find('user_id =:userId ORDER BY id DESC LIMIT 1', array(':userId' => $opponentId));
                $opponenSessId = $opponentSess->id;
            }

            $playedGameId = $this->createPlayedGame($this->sessionId, $opponenSessId, $this->game->id);
            $this->game->saveCounters(array('number_played' => 1));

            $this->createUserGame($playedGameId, $opponentId);

            $this->createGameTurn();

            if (!$msg->delete()) {
                $message = "";
                $errors = $msg->getErrors();
                foreach ($errors as $field => $error) {
                    $message .= $error[0] . ";";
                }
                throw new CHttpException(500, $message);
            }
        }
    }

    /**
     * @param int $fromUserId
     * @param int $toUserId
     * @throws CHttpException
     */
    public function rejectChallenge($fromUserId, $toUserId)
    {
        $query = 'from_user_id =:fromUserId AND to_user_id=:toUserId AND game_id=:gameId AND type=:type';
        $msg = UserMessage::model()->find($query, array(':fromUserId' => $fromUserId,
            ':toUserId' => $toUserId,
            ':gameId' => $this->game->id,
            ':type' => UserMessage::TYPE_CHALLENGE));
        if ($msg) {
            $opponentId = 0;
            if ($fromUserId == $this->userId) {
                $opponentId = $toUserId;
            } else {
                $opponentId = $fromUserId;
            }

            $opponentOnline = UserOnline::model()->find('user_id =:userId', array(':userId' => $opponentId));
            if ($opponentOnline) {
                $userDTO = new GameUserDTO();
                $userDTO->id = $this->userOnline->userId;
                $userDTO->username = $this->userOnline->session->username;
                $this->pushMessage($opponentId, MGMultiPlayer::PUSH_REJECT_CHALLENGE, json_encode($userDTO));
            }

            if (!$msg->delete()) {
                $message = "";
                $errors = $msg->getErrors();
                foreach ($errors as $field => $error) {
                    $message .= $error[0] . ";";
                }
                throw new CHttpException(500, $message);
            }
        }
    }

    /**
     * @return GameChallengesDTO
     */
    public function getChallenges()
    {
        $result = new GameChallengesDTO();
        $result->sent = array();
        $result->received = array();

        $query = 'to_user_id=:toUserId AND game_id=:gameId AND type=:type';
        $challenges = UserMessage::model()->findAll($query, array(':toUserId' => $this->userId,
            ':gameId' => $this->game->id,
            ':type' => UserMessage::TYPE_CHALLENGE));

        if ($challenges) {
            foreach ($challenges as $challenge) {
                $userDto = unserialize($challenge->message);
                $userDto->playedGameId = $challenge->played_game_id;
                array_push($result->received, $userDto);
            }
        }

        $query = 'from_user_id =:fromUserId AND game_id=:gameId AND type=:type';
        $challenges = UserMessage::model()->with('toUser')->findAll($query, array(':fromUserId' => $this->userId,
            ':gameId' => $this->game->id,
            ':type' => UserMessage::TYPE_CHALLENGE));

        if ($challenges) {
            foreach ($challenges as $challenge) {
                $userDto = new GameUserDTO();
                $userDto->id = $challenge->toUser->id;
                $userDto->username = $challenge->toUser->username;
                $userDto->playedGameId = $challenge->played_game_id;
                array_push($result->sent, $userDto);
            }
        }
        return $result;
    }

    /**
     * @return GameOfflineDTO[]
     */
    public function getOfflineGames()
    {
        $games = array();
        $userGames = UserGame::model()->with(array('playedGame','userId1', 'userId2'))->findAll('(user_id_1 =:userId1 OR user_id_2=:userId2) AND game_id=:gameId', array(':userId1' => $this->userId, ':userId2' => $this->userId, ':gameId' => $this->game->id));
        if ($userGames) {
            foreach ($userGames as $game) {
                if($game->playedGame && $game->playedGame->finished==null){
                    $opponent = null;
                    if ($game->userId1->id == $this->userId) {
                        $opponent = $game->userId2;
                    } else {
                        $opponent = $game->userId1;
                    }
                    $gameDTO = new GameOfflineDTO();
                    $gameDTO->opponentId = $opponent->id;
                    $gameDTO->playedGameId = $game->played_game_id;
                    $gameDTO->opponentName = $opponent->username;
                    $gameDTO->turnUserId = $game->turn_user_id;
                    array_push($games, $gameDTO);
                }
            }
        }
        return $games;
    }

    /**
     * @param $playedGameId
     * @return GameTurnDTO|mixed
     */
    public function getOfflineGameState($playedGameId)
    {

        $gameTurn = $this->gameTurn;
        if ($this->playedGame->session_id_1 == $this->sessionId) {
            $gameTurn->score = $this->playedGame->score_1;
            $gameTurn->opponentScore = $this->playedGame->score_2;
        } else {
            $gameTurn->score = $this->playedGame->score_2;
            $gameTurn->opponentScore = $this->playedGame->score_1;
        }

        $gameTurn->tags = array();

        /**
         * @var GameSubmission[] $submits
         */
        $submits = GameSubmission::model()->findAll('played_game_id=:playedGameId AND turn=:turn', array(':playedGameId' => $this->playedGame->id, ':turn' => $this->gameTurn->turn));

        foreach ($submits as $submit) {
            if ($submit->session_id == $this->sessionId) {
                $tagsArr = json_decode($submit->submission);
                $tmpTags = GameTagDTO::createFromArray($tagsArr);
                $gameTurn->tags = array_merge($gameTurn->tags, $tmpTags);
            }
        }

        return $gameTurn;
    }

    /**
     * @param int $playedGameId
     * @param int $userId
     * @throws CHttpException
     */
    private function createUserGame($playedGameId, $userId)
    {
        $userGame = new UserGame();
        $userGame->game_id = $this->game->id;
        $userGame->played_game_id = $playedGameId;
        $userGame->user_id_1 = $this->userId;
        $userGame->user_id_2 = $userId;

        if (!$userGame->save()) {
            $message = "";
            $errors = $userGame->getErrors();
            foreach ($errors as $field => $error) {
                $message .= $error[0] . ";";
            }
            throw new CHttpException(500, $message);
        }
    }

    protected function pushMessage($userId, $action, $payload)
    {
        $url = Yii::app()->fbvStorage->get("pushUrl");
        $url .= $action . "/" . $this->game->unique_id . "/" . $userId . "/";
        $fields = array(
            'payload' => urlencode($payload),
        );
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        curl_exec($ch);
        if (!curl_errno($ch)) {
            Yii::log("Push send, action=" . $action . "userId=" . $userId);
        } else {
            Yii::log("Push send error: " . curl_error($ch), "Error");
        }
        curl_close($ch);
    }
}
