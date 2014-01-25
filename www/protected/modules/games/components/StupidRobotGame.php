<?php
class StupidRobotGame extends NexTagGame
{
    private static $TIME_TO_PLAY = 120;
    private static $LETTERS_STEP = 3;

    public function parseTags(&$game, &$game_model)
    {
        $data = array();
        $mediaId = 0;
        $currentTag = "";
        $pass = false;
        // loop through all submissions for this turn and set ONLY THE FIRST TAG
        foreach ($game->request->submissions as $submission) {
            $pass_value = $submission["pass"];
            if ($pass_value == "true") {
                $mediaId = $submission["media_id"];
                $pass = true;
                break;
            }
            $mediaId = $submission["media_id"];
            $mediaTags = array();
            // Attempt to extract these
            foreach (MGTags::parseTags($submission["tags"]) as $tag) {
                $mediaTags[strtolower($tag)] = array(
                    'tag' => $tag,
                    'weight' => 1,
                    'type' => 'new',
                    'tag_id' => 0
                );
                $currentTag = $tag;
                $file = fopen("test.txt","w");
                fwrite($file, $tag);
                fclose($file);
                break;
            }
            // add the extracted tags to the media info
            $data[$mediaId] = $mediaTags;
            break;
        }

        $level = $this->getLevel();
        if (is_null($level)) {
            $level = new StupidRobotDTO();
            $level->level = 1;
            if ($pass) {
                $level->isAccepted = true;
            } else {
                $level->isAccepted = false;
            }
        } else if ($level->isAccepted) {
            //Move to next level
            $level->level++;
            $level->levelTurn = 0;
            $level->isAccepted = false;
            $level->countTags = 0;
            $level->tag = "";
        } else if ($pass) {
            //Move to next level
            $level->level++;
            $level->levelTurn = 0;
            $level->isAccepted = false;
            $level->countTags = 0;
            $level->tag = "";
        }
        if ($mediaId > 0) {
            $found = false;
            $mediaTags = $this->getMediaTags($level, $mediaId);
            foreach ($mediaTags as $val) {
                if ($currentTag == strtolower($val['tag'])) {
                    $data[$mediaId][$currentTag]['type'] = 'match';
                    $data[$mediaId][$currentTag]['tag_id'] = $val['tag_id'];
                    $found = true;
                    break;
                }
            }

            if ($level->countTags == 0) {
                $level->countTags = count($mediaTags);
            }

            //the answer is incorrect. Player can submit another word
            $level->levelTurn++;
            $level->isAccepted = false;
            $level->tag = $currentTag;

            if ($pass || ($found && ($level->level + StupidRobotGame::$LETTERS_STEP) == strlen($currentTag))) {
                //the answer is marked as correct and the player moves on to the next length tag
                $level->isAccepted = true;
            } else if (($level->level + StupidRobotGame::$LETTERS_STEP) == strlen($currentTag)) {
                //run the “freebie” algorithm to determine whether or not we lie to the players
                $chance = pow($level->levelTurn, 2) / (10 * ($level->countTags + 1));
                if ($chance > 0.5) $chance = 0.5;
                $rand = mt_rand() / mt_getrandmax();
                if ($rand < $chance) {
                    $level->isAccepted = true;
                }
            }
            $this->saveLevel($level);
        }

        return $data;
    }

    /**
     *
     * @param object $game The game object
     * @param object $game_model The game model
     * @param array the tags submitted by the player for each media
     * @throws CHttpException
     * @return array the turn information that will be sent to the players client
     */
    public function getTurn(&$game, &$game_model, $tags = array())
    {
        $data = array();

        $startTime = $this->getStartTime();
        $now = time();

        // check if the game is not actually over
        if (($now - $startTime) < StupidRobotGame::$TIME_TO_PLAY) {

            $media = $this->getMedia();
            if (empty($media)) {
                $collections = $this->getCollections($game, $game_model);
                $data["medias"] = array();
                $medias = $this->getMedias($collections, $game, $game_model);
                if ($medias && count($medias) > 0) {
                    $i = array_rand($medias, 1); // select one random item out of the medias
                    $media = $medias[$i];
                    $this->setMedia($media);
                } else
                    throw new CHttpException(600, $game->name . Yii::t('app', ': Not enough medias available'));
            }

            $lastLevel = $this->getLevel();
            if (is_null($lastLevel)) {
                $lastLevel = new StupidRobotDTO();
                $lastLevel->level = 1;
                $lastLevel->levelTurn = 1;
                $lastLevel->isAccepted = false;
            }

            $path = $media["institutionUrl"];
            $path = rtrim($path, "/");
            $path .= UPLOAD_PATH;

            $data["medias"][] = array(
                "media_id" => $media["id"],
                "full_size" => $path . "/images/" . $media["name"],
                "thumbnail" => $path . "/thumbs/" . $media["name"],
                "final_screen" => MGHelper::getScaledMediaUrl($media["name"], 212, 171, $media["institutionToken"], $media["institutionUrl"]),
                "scaled" => MGHelper::getScaledMediaUrl($media["name"], $game->image_width, $game->image_height, $media["institutionToken"], $media["institutionUrl"]),
                "licences" => $media["licences"],
                "level" => $lastLevel->level,
                "tag_accepted" => $lastLevel->isAccepted
            );

            // extract needed licence info
            $data["licences"] = $this->getLicenceInfo($media["licences"]);

            // prepare further data
            $data["tags"] = array();
            // in the first turn this field is empty in further turns it contains the
            // previous turns weightened tags
            $data["tags"]["user"] = $tags;

            // the following lines call the wordsToAvoid methods of the activated dictionary
            // plugin this generates a words to avoid list
            $used_medias = array();
            array_push($used_medias, $media['id']);
            $data["wordstoavoid"] = array();
            $plugins = PluginsModule::getActiveGamePlugins($game->game_id, "dictionary");
            if (count($plugins) > 0) {
                foreach ($plugins as $plugin) {
                    if (method_exists($plugin->component, "wordsToAvoid")) {
                        // this method gets all elements by reference. $data["wordstoavoid"] might be changed
                        $plugin->component->wordsToAvoid($data["wordstoavoid"], $used_medias, $game, $game_model, $tags);
                    }
                }
            }
        } else {
            // the game is over thus the needed info is sparse
            $data["tags"] = array();
            $data["tags"]["user"] = $tags;
            $data["licences"] = array(); // no need to show licences on the last screen as the previous turns are cached by javascript and therefore all licence info is available
            $this->reset();
        }
        return $data;
    }

    /**
     * This method return start time of the game
     *
     * @return int
     */
    protected function getStartTime()
    {
        $time = time();
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (!isset(Yii::app()->session[$api_id . '_PYRAMID_START_TIME'])) {
            Yii::app()->session[$api_id . '_PYRAMID_START_TIME'] = $time;
        } else {
            $time = Yii::app()->session[$api_id . '_PYRAMID_START_TIME'];
        }
        return $time;
    }

    /**
     * Retrieve the IDs of all medias that have been seen/used by the current user
     * on a per game and per session basis.
     *
     * @return ArrayObject of the current media
     */
    protected function getMedia()
    {
        $media = array();
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (isset(Yii::app()->session[$api_id . '_PYRAMID_IMAGE'])) {
            $media = Yii::app()->session[$api_id . '_PYRAMID_IMAGE'];
        }
        return $media;
    }

    /**
     * Add media stored in the current session for the currently
     * played game
     *
     * @param ArrayObject $media the media that have been shown to the user
     */
    protected function setMedia($media)
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        Media::model()->setLastAccess(array($media['id']));
        Yii::app()->session[$api_id . '_PYRAMID_IMAGE'] = $media;
    }

    public static function reset()
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        unset(Yii::app()->session[$api_id . '_PYRAMID_IMAGE']);
        unset(Yii::app()->session[$api_id . '_PYRAMID_LEVELS']);
        unset(Yii::app()->session[$api_id . '_PYRAMID_START_TIME']);
        unset(Yii::app()->session[$api_id . '_PYRAMID_IMAGE_TAGS']);
    }

    /**
     * Get last played level of stupidRobot game
     *
     * @return StupidRobotDTO|null
     */
    private function getLevel()
    {
        $level = null;
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (isset(Yii::app()->session[$api_id . '_PYRAMID_LEVELS'])) {
            $levels = Yii::app()->session[$api_id . '_PYRAMID_LEVELS'];
            $level = unserialize(end($levels));
        }
        return $level;
    }

    /**
     * Save current level which will be played of stupidRobot game
     *
     * @param StupidRobotDTO $level
     */
    private function saveLevel(StupidRobotDTO $level)
    {
        $levels = array();
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (isset(Yii::app()->session[$api_id . '_PYRAMID_LEVELS'])) {
            $levels = Yii::app()->session[$api_id . '_PYRAMID_LEVELS'];
        }
        array_push($levels, serialize($level));
        Yii::app()->session[$api_id . '_PYRAMID_LEVELS'] = $levels;
    }

    /**
     * @param StupidRobotDTO $level
     * @param int $mediaId
     * @return array
     */
    private function getMediaTags(StupidRobotDTO $level, $mediaId)
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        $mediaTags = Yii::app()->session[$api_id . '_PYRAMID_IMAGE_TAGS'];

        if (!is_null($mediaTags) && ($level->level + StupidRobotGame::$LETTERS_STEP) == strlen($mediaTags[0]["tag"])) {
            return $mediaTags;
        } else {
            $mediaTags = MGTags::getTagsByLength($mediaId, ($level->level + StupidRobotGame::$LETTERS_STEP));
            if (empty($mediaTags)) {
                $tag = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $level->level + StupidRobotGame::$LETTERS_STEP);
                $mediaTags[0]["tag"] = $tag;
                $mediaTags[0]["tag_id"] = -1;
            }
            Yii::app()->session[$api_id . '_PYRAMID_IMAGE_TAGS'] = $mediaTags;
            return $mediaTags;
        }
    }
}

class StupidRobotDTO
{
    /**
     * @var int
     */
    public $level = 0;
    /**
     * @var int
     */
    public $levelTurn = 0;
    /**
     * @var int
     */
    public $countTags = 0;
    /**
     * @var string
     */
    public $tag = "";
    /**
     * @var bool
     */
    public $isAccepted = false;
}

?>
