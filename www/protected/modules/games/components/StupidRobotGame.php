<?php

class StupidRobotGame extends NexTagGame
{
    private static $TIME_TO_PLAY = 120;
    private static $LETTERS_STEP = 3;

    public function parseTags(&$game, &$game_model)
    {
        $rnd = rand(0, 100);
//        exit();
//        if($rnd > 50)
//            exit();
//        sleep(3);
        $data = array();
        $mediaId = 0;
        $currentTag = "";
        $pass = false;
        // loop through all submissions for this turn and set ONLY THE FIRST TAG
        foreach ($game->request->submissions as $submission) {
            $pass_value = $submission["pass"];
            $reboot_value = $submission["reboot"];
            if ($pass_value == "true" || $reboot_value) {
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

                // 20141025 - SP
                // Use for testing on local build, otherwise will prevent
                // entering tags because server does not have permissions
                // to open stream.
                //
                /*
                                    if($found){
                                    $file = fopen("test.txt","a");
                                    fwrite($file, "found it!");
                                    fclose($file);
                                } */
                // break;
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
            $level->nlpTest = $this->isValidWord($currentTag);
            if ($level->nlpTest != 0) {
                $found = false;
                // currently they retrieve the tags with length regarding
                // to current level. but now we want to switch to arbitrary level,
                // currently I just hack it by not checking the level and
                // return tags with all the level, which is a quick fix
                // a better way is change the whole query
                /*             $file = fopen("media_id.txt","a");
                            fwrite($file, $mediaId."\n");
                            fclose($file); */
                $mediaTags = $this->getMediaTags($level, $mediaId, $reboot_value);

                foreach ($mediaTags as $val) {
                    /*             	$file = fopen("media_id.txt","a");
                                    fwrite($file, $currentTag ." vs(".$mediaId.") ". strtolower($val['tag']."\n"));
                                    fclose($file); */
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

                // Junjie Guan: I modified the following condition here, so that palyers can submit arbitrary length of words
                // and I leave the length screening to frontend, for example you cannot submit 2 four-letter words
                // This is a quick fix, but have potential minor security issue, I leave that to future work.
                // so in the future we need to implement screening on server side
                // os, I also leave the pass functionality here, just in case we need to use it again
                //if ($pass || ($found && ($level->level + StupidRobotGame::$LETTERS_STEP) == strlen($currentTag))) {
                if ($pass || $found) {
                    //the answer is marked as correct and the player moves on to the next length tag
                    $level->isAccepted = true;
                    $level->wordlength = strlen($currentTag);
                } else if (($level->level + StupidRobotGame::$LETTERS_STEP) == strlen($currentTag)) {
                    //run the “freebie” algorithm to determine whether or not we lie to the players
                    $chance = pow($level->levelTurn, 2) / (10 * ($level->countTags + 1));
                    if ($chance > 0.5) $chance = 0.5;
                    $rand = mt_rand() / mt_getrandmax();
                    if ($rand < $chance) {
                        $level->isAccepted = true;
                    }
                }
            }
            $this->saveLevel($level);
        }

        return $data;
    }

    function isValidWord($currentTag)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, Yii::app()->fbvStorage->get("nlpApiUrl") . "/possible_wordcheck?input=" . $currentTag);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);

            if (FALSE === $server_output)
                throw new Exception(curl_error($ch), curl_errno($ch));
            curl_close($ch);

            // ...process $content now
            $server_output = json_decode($server_output);
            if ($server_output->response) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            trigger_error(sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
            curl_close($ch);
            return -1;
        }
    }

    /**
     *
     * @param object $game The game object
     * @param object $game_model The game model
     * @param array the tags submitted by the player for each media
     * @throws CHttpException
     * @return array the turn information that will be sent to the players client
     */
    public
    function getTurn(&$game, &$game_model, $tags = array())
    {
        $data = array();

        $startTime = $this->getStartTime();
        $now = time();

        /*         $file = fopen("getturn.txt","a");
                fwrite($file, "getTurn\n");
                fclose($file); */

        // check for reboot request
        // (this functionality is added by Junje Guan)
        $reboot_value = $game->request->submissions[0]["reboot"];

        // check if the game is not actually over
        if (($now - $startTime) < StupidRobotGame::$TIME_TO_PLAY) {

            /*         	$file = fopen("getturn.txt","a");
                        fwrite($file, "< StupidRobotGame::\$TIME_TO_PLAY\n");
                        fclose($file); */

            $media = $this->getMedia();

            if (empty($media) || $reboot_value) {
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

            /*             $file = fopen("reboot_value.txt","a");
                        fwrite($file, $reboot_value);
                        fwrite($file, "\n");
                        fclose($file); */

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
                "tag_accepted" => $lastLevel->isAccepted,
                "nlp_test" => $lastLevel->nlpTest,
                "wordlength" => $lastLevel->wordlength
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
            /*             $file = fopen("getturn.txt","a");
                        fwrite($file, "game over\n");
                        fclose($file); */
        }


        return $data;
    }

    /**
     * This method return start time of the game
     *
     * @return int
     */
    protected
    function getStartTime()
    {
        $time = time();
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (!isset(Yii::app()->session[$api_id . '_STUPIDRORBOT_START_TIME'])) {
            Yii::app()->session[$api_id . '_STUPIDRORBOT_START_TIME'] = $time;
        } else {
            $time = Yii::app()->session[$api_id . '_STUPIDRORBOT_START_TIME'];
        }
        return $time;
    }

    /**
     * Retrieve the IDs of all medias that have been seen/used by the current user
     * on a per game and per session basis.
     *
     * @return ArrayObject of the current media
     */
    protected
    function getMedia()
    {
        $media = array();
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (isset(Yii::app()->session[$api_id . '_STUPIDRORBOT_IMAGE'])) {
            $media = Yii::app()->session[$api_id . '_STUPIDRORBOT_IMAGE'];
        }
        return $media;
    }

    /**
     * Add media stored in the current session for the currently
     * played game
     *
     * @param ArrayObject $media the media that have been shown to the user
     */
    protected
    function setMedia($media)
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        Media::model()->setLastAccess(array($media['id']));
        Yii::app()->session[$api_id . '_STUPIDRORBOT_IMAGE'] = $media;
    }

    public
    static function reset()
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        unset(Yii::app()->session[$api_id . '_STUPIDRORBOT_IMAGE']);
        unset(Yii::app()->session[$api_id . '_STUPIDRORBOT_LEVELS']);
        unset(Yii::app()->session[$api_id . '_STUPIDRORBOT_START_TIME']);
        unset(Yii::app()->session[$api_id . '_STUPIDRORBOT_IMAGE_TAGS']);
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
        if (isset(Yii::app()->session[$api_id . '_STUPIDRORBOT_LEVELS'])) {
            $levels = Yii::app()->session[$api_id . '_STUPIDRORBOT_LEVELS'];
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
        if (isset(Yii::app()->session[$api_id . '_STUPIDRORBOT_LEVELS'])) {
            $levels = Yii::app()->session[$api_id . '_STUPIDRORBOT_LEVELS'];
        }
        array_push($levels, serialize($level));
        Yii::app()->session[$api_id . '_STUPIDRORBOT_LEVELS'] = $levels;
    }

    /**
     * @param StupidRobotDTO $level
     * @param int $mediaId
     * @return array
     */
    private function getMediaTags(StupidRobotDTO $level, $mediaId)
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        $mediaTags = Yii::app()->session[$api_id . '_STUPIDROBOT_IMAGE_TAGS'];

        //if (!is_null($mediaTags) && ($level->level + StupidRobotGame::$LETTERS_STEP) == strlen($mediaTags[0]["tag"])) {
        if (!is_null($mediaTags) && $mediaId == Yii::app()->session[$api_id . '_STUPIDROBOT_MEDIAID']) {
            return $mediaTags;
        } else {

            $mediaTags = MGTags::getTagsMediaId($mediaId);
            if (empty($mediaTags)) {
                $tag = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $level->level + StupidRobotGame::$LETTERS_STEP);
                $mediaTags[0]["tag"] = $tag;
                $mediaTags[0]["tag_id"] = -1;
            }
            /*             foreach ($mediaTags as $val) {
                            $file = fopen("getMediaTags.txt","a");
                            fwrite($file, $mediaId.": ".$val['tag']."\n");
                            fclose($file);
                        }
                        $file = fopen("getMediaTags.txt","a");
                        fwrite($file, "\n");
                        fclose($file); */
            Yii::app()->session[$api_id . '_STUPIDROBOT_IMAGE_TAGS'] = $mediaTags;
            Yii::app()->session[$api_id . '_STUPIDROBOT_MEDIAID'] = $mediaId;
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

    public $nlpTest = 1;

    public $wordlength = 0;
}

?>
