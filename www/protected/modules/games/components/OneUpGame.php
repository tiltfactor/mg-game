<?php
/**
 *
 * @package
 */
class OneUpGame extends MGMultiPlayer
{
    function __construct()
    {
        parent::__construct("OneUp", true);
    }


    /**
     * @param GameTagDTO[] $tags
     * @throws CHttpException
     */
    public function submit(&$tags)
    {
        /**
         * @var GameSubmission[] $submits
         */
        $submits = GameSubmission::model()->findAll('played_game_id=:playedGameId', array(':playedGameId' => $this->gamePlayer->played_game_id));
        /**
         * @var string[] $submits
         */
        $playerTags = array();
        $playerTagDTOs = array();
        $opponentTagDTOs = array();
        foreach ($submits as $submit) {
            $tagsArr = json_decode($submit->submission);
            $tmpTags = GameTagDTO::createFromArray($tagsArr);
            if ($submit->session_id == $this->sessionId) {
                if (!isset($playerTagDTOs[$submit->turn])) {
                    $playerTagDTOs[$submit->turn] = array();
                }
                $playerTagDTOs[$submit->turn] = array_merge($playerTagDTOs[$submit->turn], $tmpTags);
                foreach ($tmpTags as $row) {
                    array_push($playerTagDTOs, $row->tag);
                }
            } else {
                if (!isset($opponentTagDTOs[$submit->turn])) {
                    $opponentTagDTOs[$submit->turn] = array();
                }
                $opponentTagDTOs[$submit->turn] = array_merge($opponentTagDTOs[$submit->turn], $tmpTags);
            }
        }

        $submissions = count($playerTagDTOs[$this->gameTurn->turn]);
        if ($submissions < $this->game->submissions) {
            foreach ($tags as $tag) {
                $tag->type = "new";
                if (in_array($tag->tag, $playerTags)) {
                    throw new CHttpException(400, Yii::t('app', 'You already submitted this word!'));
                }
                $prvTurn = $this->gameTurn->turn - 1;
                $penalty = false;
                if ($prvTurn > 0) {
                    foreach ($opponentTagDTOs[$prvTurn] as $row) {
                        if ($row->tag == $tag->tag) {
                            $tag->score = -1;
                            //todo: Push notifacation
                            //Player notified of penalty
                            //Opponent receives OneUp bonus and notification
                            if ($this->gamePlayer->playedGame->session_id_1 == $this->sessionId) {
                                $this->gamePlayer->playedGame->score_2 += 1;
                            } else {
                                $this->gamePlayer->playedGame->score_1 += 1;
                            }
                            if (!$this->gamePlayer->playedGame->update()) {
                                $message = "";
                                $errors = $this->gamePlayer->playedGame->getErrors();
                                foreach ($errors as $field => $error) {
                                    $message .= $error[0] . ";";
                                }
                                throw new CHttpException(400, Yii::t('app', $message));
                            }
                            $penalty = true;
                            $tag->type = "penalty";
                            break;
                        }
                    }
                }

                if (!$penalty) {
                    if (MGTags::isExisting($tag->mediaId, $tag->tag)) {
                        //Roll to add accuracy bonus
                        $chance = 100;
                        $points = 4;
                        if ($this->gameTurn->turn == 1) {
                            $chance = 25;
                            $points = 3;
                        }
                        if ($this->gameTurn->turn == 2) {
                            $chance = 50;
                            $points = 2;
                        }
                        if (mt_rand(0, 100) <= $chance) {
                            $tag->type = "bonus";
                            $tag->score = $points;
                        } else
                            $tag->score = 1;
                    } else {
                        $tag->score = 1;
                    }
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Round submissions exceeded!'));
        }

        $scores = parent::getScore($tags);
        foreach ($tags as $tag) {
            $scores = $scores + $tag->score;
        }

        //update played game score
        if ($this->gamePlayer->playedGame->session_id_1 == $this->sessionId) {
            $this->gamePlayer->playedGame->score_1 += $scores;
        } else {
            $this->gamePlayer->playedGame->score_2 += $scores;
        }
        if (!$this->gamePlayer->playedGame->update()) {
            $message = "";
            $errors = $this->gamePlayer->playedGame->getErrors();
            foreach ($errors as $field => $error) {
                $message .= $error[0] . ";";
            }
            throw new CHttpException(400, Yii::t('app', $message));
        }

        $tags = $this->setWeights($tags);
        $this->saveSubmission($tags);

        $submissions += 1;
        if ($submissions == $this->game->submissions) {
            $opponentSubmissions = count($playerTagDTOs[$this->gameTurn->turn]);
            if ($opponentSubmissions == $this->game->submissions) {
                $this->createGameTurn();
            } else {
                //todo: send push notification
            }
        }
    }
}
