<?php
/**
 *
 * @package
 */
class OneUpGame extends MGGame implements MGGameInterface
{
    /**
     * @var boolean $two_player_game is set to TRUE!!! to activate two player mode
     */
    public $two_player_game = true;

    /**
     * As the JSON submitted/posted by the JavaScript implementation of the game
     * can vary each game has to implement a parsing function to make it available
     * for the further methods. This is also the right place to sanity check the
     * submission received by the server
     *
     * @param object $game The game object
     * @param object $game_model The game model
     * @return boolean TRUE if the submission has been successfully parsed
     */
    public function parseSubmission(&$game, &$game_model)
    {
        $game->request->submissions = array();

        $success = true;

        // check the POST request if the expected submission field is presend and correctly set
        if (isset($_POST["submissions"]) && is_array($_POST["submissions"]) && count($_POST["submissions"]) > 0) {
            // loop through all submissions and validate them
            foreach ($_POST["submissions"] as $submission) {
                if ($submission["media_id"] && (int)$submission["media_id"] != 0
                    && $submission["tags"] && (string)$submission["tags"] != ""
                ) {
                    // add the submission the the array
                    $game->request->submissions[] = $submission;
                }
            }
        }

        // if a submission has been posted everything might be ok
        $success = (count($game->request->submissions) > 0);

        // the following lines call plugins to manipulate & validate the submission further.

        // call all dictionary plugins' parseSubmission method
        $plugins = PluginsModule::getActiveGamePlugins($game->game_id, "dictionary");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "parseSubmission")) {
                    // parse the submission and allow it to influence the success
                    $success = $success && $plugin->component->parseSubmission($game, $game_model);
                }
            }
        }

        // call all weighting plugins' parseSubmission method
        $plugins = PluginsModule::getActiveGamePlugins($game->game_id, "weighting");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "parseSubmission")) {
                    // parse the submission and allow it to influence the success
                    $success = $success && $plugin->component->parseSubmission($game, $game_model);
                }
            }
        }

        return $success;
    }

    /**
     * Take the information from the submission and extract the tags for each media
     * involved in the current turn.
     *
     * @param object $game The game object
     * @param object $game_model The game model
     * @return Array the tags for each media
     */
    public function parseTags(&$game, &$game_model)
    {
        $data = array();
        $mediaId = 0;
        $currentTag = "";

        // go through all submissions
        foreach ($game->request->submissions as $submission) {
            // extract the media id
            $mediaId = $submission["media_id"];
            $mediaTags = array();
            // Attempt to extract these
            foreach (MGTags::parseTags($submission["tags"]) as $tag) {
                $mediaTags[strtolower($tag)] = array(
                    'tag' => $tag,
                    'weight' => 1,
                    'score' => 0
                );
                $currentTag = $tag;
                break;
            }

            $round = $this->getRound();

            if($round->round>1){

            }



            // add the extracted tags to the media info
            $data[$mediaId] = $mediaTags;
        }

        return $data;
    }

    /**
     * Allows to implement weighting of the submitted tags. Here you should usually
     * provide hooks to the setWeight methods of the dictionary and weighting plugins.
     *
     * @param object $game The game object
     * @param object $game_model The game model
     * @param Array the tags submitted by the player for each media
     * @return Array the tags (with additional weight information)
     */
    public function setWeights(&$game, &$game_model, $tags)
    {
        // call the set setWeights method of all activated dictionary plugins
        $plugins = PluginsModule::getActiveGamePlugins($game->game_id, "dictionary");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "setWeights")) {
                    // influence the weight of the tags
                    $tags = $plugin->component->setWeights($game, $game_model, $tags);
                }
            }
        }

        // call the set setWeights method of all activated weighting plugins
        $plugins = PluginsModule::getActiveGamePlugins($game->game_id, "weighting");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "setWeights")) {
                    // influence the weight of the tags
                    $tags = $plugin->component->setWeights($game, $game_model, $tags);
                }
            }
        }
        return $tags;
    }

    /**
     * @param object $game The game object
     * @param object $game_model The game model
     * @param Array the tags submitted by the player for each media
     * @return Array the turn information that will be sent to the players client
     */
    public function getTurn(&$game, &$game_model, $tags = array())
    {
        $turn = $this->loadTwoPlayerTurnFromDb($game->played_game_id, 1);

        if (is_null($turn)) {
            $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");

            // thus we have to create one.
            $turn = $this->_createTurn($game, $game_model, $tags);

            if (!$this->saveTwoPlayerTurnToDb($game->played_game_id, $game->turn + 1, (int)Yii::app()->session[$api_id . '_SESSION_ID'], $turn)) {
                // try to load again as the first user seems to have been faster to write the turn into the database
                $turn = $this->loadTwoPlayerTurnFromDb($game->played_game_id, $game->turn + 1);
            }
        }

        if (is_null($turn)) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $round = $this->getRound();
        if (is_null($round)) {
            $round = new OneupRoundDTO();
            $round->round = 1;
            $round->roundTurn = 0;
            $this->setRound($round);
        }

        if($round->round > $game->rounds){
            $turn = array();
            $turn["tags"] = array();
            $turn["tags"]["user"] = $tags;
            $turn["licences"] = array();
        }else{
            $turn["round"] = $round->round;
            $turn["roundTurn"] = $round->roundTurn;
        }

        return $turn;
    }

    /**
     * This method should hold the implementation that allows the scoring
     * of the turn's submitted tags. It is the place to call the weighting
     * plugin's 'scoring' methods.
     *
     * @param object $game The game object
     * @param object $game_model The game model
     * @param Array the tags submitted by the player for each media
     * @return int the score for this turn
     */
    public function getScore(&$game, &$game_model, &$tags)
    {
        $score = 0;

        // call the set score method of all activated weighting plugins
        $plugins = PluginsModule::getActiveGamePlugins($game->game_id, "weighting");
        if (count($plugins) > 0) {
            foreach ($plugins as $plugin) {
                if (method_exists($plugin->component, "score")) {

                    // let each scoring plugin add to the score based on the $tags or even
                    // further submission information extracted from $game->request->submissions
                    $score = $plugin->component->score($game, $game_model, $tags, $score);
                }
            }
        }
        return $score;
    }

    /**
     * This method is the actual implementation of the getTurn method
     *
     * @param object $game The game object
     * @param object $game_model The game model
     * @param Array the tags submitted by the player for each media
     * @return Array the turn information that will be sent to the players client
     */
    private function _createTurn(&$game, &$game_model, $tags = array())
    {
        $data = array();

        //retrieve the media sets that are active for this game
        $collections = $this->getCollections($game, $game_model);
        $data["medias"] = array();
        // get a one medias that is active for the game
        $medias = $this->getMedias($collections, $game, $game_model);
        if ($medias && count($medias) > 0) {
            $i = array_rand($medias, 1);

            $path = Yii::app()->getBaseUrl(true) . Yii::app()->fbvStorage->get('settings.app_upload_url');
            $data["medias"][] = array(
                "media_id" => $medias[$i]["id"],
                "full_size" => $path . "/images/" . $medias[$i]["name"],
                "thumbnail" => $path . "/thumbs/" . $medias[$i]["name"],
                "final_screen" => $path . "/scaled/" . MGHelper::createScaledMedia($medias[$i]["name"], "", "scaled", 212, 171, 80, 10),
                "scaled" => $path . "/scaled/" . MGHelper::createScaledMedia($medias[$i]["name"], "", "scaled", $game->image_width, $game->image_height, 80, 10),
                "licences" => $medias[$i]["licences"],
            );
            // extract needed licence info
            $data["licences"] = $this->getLicenceInfo($medias[$i]["licences"]);
            // prepare further data
            $data["tags"] = array();

            // in the first turn this field is empty in further turns it contains the
            // previous turns weightened tags
            $data["tags"]["user"] = $tags;
            $data["wordstoavoid"] = array();

            $used_medias = array();
            array_push($used_medias, $medias[$i]['id']);
            // the following lines call the wordsToAvoid methods of the activated dictionary
            // plugin this generates a words to avoid list
            $plugins = PluginsModule::getActiveGamePlugins($game->game_id, "dictionary");
            if (count($plugins) > 0) {
                foreach ($plugins as $plugin) {
                    if (method_exists($plugin->component, "wordsToAvoid")) {
                        // this method gets all elements by reference. $data["wordstoavoid"] might be changed
                        $plugin->component->wordsToAvoid($data["wordstoavoid"], $used_medias, $game, $game_model, $tags);
                    }
                }
            }

        } else
            throw new CHttpException(600, $game->name . Yii::t('app', ': Not enough medias available'));
        return $data;
    }

    /**
     * Get last played round of oneup game
     *
     * @return OneupRoundDTO|null
     */
    private function getRound()
    {
        $round = null;
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (isset(Yii::app()->session[$api_id . '_ONEUP_ROUND'])) {
            $round = unserialize(Yii::app()->session[$api_id . '_ONEUP_ROUND']);
        }
        return $round;
    }

    /**
     * Save current round which will be played of oneup game
     *
     * @param PyramidDTO $level
     */
    private function setRound(OneupRoundDTO $round)
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        Yii::app()->session[$api_id . '_ONEUP_ROUND'] = serialize($round);
    }

    public static function reset()
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        unset(Yii::app()->session[$api_id . '_ONEUP_ROUND']);
    }
}


class OneupRoundDTO
{
    /**
     * @var int
     */
    public $round = 0;
    /**
     * @var int
     */
    public $roundTurn = 0;
}
