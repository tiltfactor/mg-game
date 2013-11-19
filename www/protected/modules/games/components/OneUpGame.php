<?php
/**
 *
 * @package
 */
class OneUpGame extends MGMultiPlayer
{
    function __construct()
    {
        $playedGameId = -1;
        if (isset($_POST['playedGameId'])) {
            $playedGameId = $_POST['playedGameId'];
        }
        parent::__construct("OneUp", true, $playedGameId);
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
        $submits = GameSubmission::model()->findAll('played_game_id=:playedGameId', array(':playedGameId' => $this->playedGame->id));
        /**
         * @var string[] $submits
         */
        $playerTags = array();
        $playerTagDTOs = array();
        $opponentTagDTOs = array();
        foreach ($submits as $submit) {
            $tagsArr = json_decode($submit->submission, true);
            $tmpTags = GameTagDTO::createFromArray($tagsArr);
            if ($submit->session->user_id == $this->userId) {
                if (!isset($playerTagDTOs[$submit->turn])) {
                    $playerTagDTOs[$submit->turn] = array();
                }
                $playerTagDTOs[$submit->turn] = array_merge($playerTagDTOs[$submit->turn], $tmpTags);
                foreach ($tmpTags as $tt) {
                    array_push($playerTags, $tt->tag);
                }
            } else {
                if (!isset($opponentTagDTOs[$submit->turn])) {
                    $opponentTagDTOs[$submit->turn] = array();
                }
                $opponentTagDTOs[$submit->turn] = array_merge($opponentTagDTOs[$submit->turn], $tmpTags);
            }
        }

        if ($this->playedGame->session_id_1 == $this->sessionId) {
            $opponentId = $this->playedGame->sessionId2->user_id;
        } else {
            $opponentId = $this->playedGame->sessionId1->user_id;
        }
        $opponentOnline = UserOnline::model()->find('user_id =:userId', array(':userId' => $opponentId));
        if (isset($playerTagDTOs[$this->gameTurn->turn])) {
            $submissions = count($playerTagDTOs[$this->gameTurn->turn]);
        } else {
            $submissions = 0;
        }
        if ($submissions < $this->game->submissions) {
            foreach ($tags as &$tag) {
                $tag->type = "new";
                $tag->weight = 1;
                foreach ($opponentTagDTOs as $turn => $oTags) {
                    $found = false;
                    foreach ($oTags as $oTag) {
                        if (strtolower($oTag->tag) == strtolower($tag->tag)) {
                            if ($turn == $this->gameTurn->turn)
                                $tag->weight += 1;
                            else
                                $tag->weight += 2;
                            $found = true;
                            break;
                        }
                    }
                    if ($found) {
                        break;
                    }
                }
                if (in_array($tag->tag, $playerTags)) {
                    throw new CHttpException(400, Yii::t('app', 'You already submitted this word!'));
                }
                $prvTurn = $this->gameTurn->turn - 1;
                $penalty = false;
                if ($prvTurn > 0) {
                    for ($i = 1; $i <= $prvTurn; $i++) {
                        foreach ($opponentTagDTOs[$i] as $row) {
                            if (strtolower($row->tag) == strtolower($tag->tag)) {
                                $tag->score = -1;
                                $payload = array();
                                $payload['tag'] = $tag;
                                $payload['playedGameId'] = $this->playedGame->id;

                                $this->pushMessage($this->userOnline->user_id, MGMultiPlayer::PUSH_PENALTY, json_encode($payload));
                                $this->updateSubmitToBonus($submits, $row);
                                if ($opponentOnline) {
                                    $payload = array();
                                    $payload['tag'] = $tag;
                                    $payload['tag']->score = 1;
                                    $payload['playedGameId'] = $this->playedGame->id;
                                    $payload['opponentName'] = $this->userOnline->session->username;
                                    $this->pushMessage($opponentId, MGMultiPlayer::PUSH_BONUS, json_encode($payload));
                                }
                                $tag->score = -1;

                                //Player notified of penalty
                                //Opponent receives OneUp bonus and notification
                                if ($this->playedGame->session_id_1 == $this->sessionId) {
                                    $this->playedGame->score_2 += 1;
                                } else {
                                    $this->playedGame->score_1 += 1;
                                }
                                if (!$this->playedGame->update()) {
                                    $message = "";
                                    $errors = $this->playedGame->getErrors();
                                    if (is_array($errors)) {
                                        foreach ($errors as $field => $error) {
                                            $message .= $error[0] . ";";
                                        }
                                    }
                                    throw new CHttpException(400, Yii::t('app', $message));
                                }
                                $penalty = true;
                                $tag->type = "penalty";

                                $i = $prvTurn + 1;
                                break;
                            }
                        }
                    }
                }

                if (!$penalty) {
                    if (MGTags::isExisting($tag->mediaId, $tag->tag,$this->playedGame->created)) {
                        $bonusGiven = false;
                        if (is_array($playerTagDTOs[$this->gameTurn->turn])) {
                            foreach ($playerTagDTOs[$this->gameTurn->turn] as $tt) {
                                if ($tt->score > 2) {
                                    $bonusGiven = true;
                                    break;
                                }
                            }
                        }

                        $tag->score = 1;

                        if (!$bonusGiven) {
                            $tagN = MGTags::countTag($tag->mediaId, $tag->tag);
                            $tagC = (100 / sqrt($tagN)) + 30;
                            if ($tagC > 100) $tagC = 100;
                            else if ($tagC < 30) $tagC = 30;

                            if (mt_rand(0, 100) < $tagC) {
                                if ($this->gameTurn->turn == 1) {
                                    $tag->type = "bonus";
                                    $tag->score = 3;
                                } elseif ($this->gameTurn->turn == 2) {
                                    $tag->type = "bonus";
                                    $tag->score = 5;
                                } else if ($this->gameTurn->turn == 3) {
                                    $tag->type = "bonus";
                                    $tag->score = 7;
                                }
                            }
                        }
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
        if ($this->playedGame->session_id_1 == $this->sessionId) {
            $this->playedGame->score_1 += $scores;
        } else {
            $this->playedGame->score_2 += $scores;
        }
        if (!$this->playedGame->update()) {
            $message = "";
            $errors = $this->playedGame->getErrors();
            foreach ($errors as $field => $error) {
                $message .= $error[0] . ";";
            }
            throw new CHttpException(400, Yii::t('app', $message));
        }

        $tags = $this->setWeights($tags);

        $this->saveSubmission($tags);

        $userGame = UserGame::model()->find('played_game_id=:playedGameId', array(':playedGameId' => $this->playedGame->id));

        $submissions += 1;
        if ($submissions == $this->game->submissions) {
            $opponentSubmissions = count($opponentTagDTOs[$this->gameTurn->turn]);
            if ($opponentSubmissions == $this->game->submissions) {
                $this->createGameTurn($this->gameTurn->media[0]);
                if ($userGame) {
                    $userGame->turn_user_id = 0;
                    $userGame->save();
                }
            } else {
                if ($userGame) {
                    $userGame->turn_user_id = $opponentId;
                    $userGame->save();
                }
                if ($opponentOnline) {
                    $pUser = new GameUserDTO();
                    $pUser->id = $this->userId;
                    $pUser->username = $this->userOnline->session->username;
                    $pUser->playedGameId = $this->playedGame->id;
                    $this->pushMessage($opponentId, MGMultiPlayer::PUSH_OPPONENT_WAITING, json_encode($pUser));
                }
            }
        }
    }


    /**
     * User is no more online so do some cleanups
     *
     * @param int $userId
     * @throws CHttpException
     */
    public function disconnect($userId)
    {
        $userOnline = UserOnline::model()->find('user_id =:userId AND t.game_id=:gameId', array(':userId' => $userId, ':gameId' => $this->game->id));
        if ($userOnline) {
            if (!$userOnline->delete()) {
                $message = "";
                $errors = $userOnline->getErrors();
                foreach ($errors as $field => $error) {
                    $message .= $error[0] . ";";
                }
                throw new CHttpException(500, $message);
            }
        }
    }

    /**
     * @throws CHttpException
     */
    public function gameEnd()
    {
        $this->playedGame->finished = date('Y-m-d H:i:s');
        if (!$this->playedGame->save()) {
            $message = "";
            $errors = $this->playedGame->getErrors();
            foreach ($errors as $field => $error) {
                $message .= $error[0] . ";";
            }
            throw new CHttpException(500, $message);
        }

        if ($this->sessionId == $this->playedGame->session_id_1) {
            $score = $this->playedGame->score_1;
            $opponentScore = $this->playedGame->score_2;
            $opponentId = $this->playedGame->sessionId2->user_id;
            $opponentName = $this->playedGame->sessionId2->username;
        } else {
            $score = $this->playedGame->score_2;
            $opponentScore = $this->playedGame->score_1;
            $opponentId = $this->playedGame->sessionId1->user_id;
            $opponentName = $this->playedGame->sessionId1->username;
        }
        $this->saveUserToGame($score);

        $userToGame = UserToGame::model()->findByPk(array(
            "user_id" => $opponentId,
            "game_id" => $this->game->id,
        ));
        if ($userToGame) {
            $userToGame->saveCounters(array('number_played' => 1, 'score' => $opponentScore));
        }

        if (isset($this->userOnline) && $this->userOnline->session_id == $this->sessionId) {
            $this->userOnline->played_game_id = null;
            $this->userOnline->status = UserOnline::STATUS_WAIT;
            $this->userOnline->save();
        }

        if (isset($this->userOnline)) {
            $oUser = new GameUserDTO();
            $oUser->id = $opponentId;
            $oUser->username = $opponentName;
            $oUser->playedGameId = $this->playedGame->id;
            $this->pushMessage($this->userOnline->user_id, MGMultiPlayer::PUSH_GAME_END, json_encode($oUser));
        }

        $opponentOnline = UserOnline::model()->find('user_id =:userId', array(':userId' => $opponentId));
        if ($opponentOnline) {
            $pUser = new GameUserDTO();
            $pUser->id = $this->userId;
            $pUser->username = $this->userOnline->session->username;
            $pUser->playedGameId = $this->playedGame->id;

            $this->pushMessage($opponentId, MGMultiPlayer::PUSH_GAME_END, json_encode($pUser));
        } else {
            $msg = new UserMessage();
            $msg->from_user_id = $this->userId;
            $msg->to_user_id = $opponentId;
            $msg->game_id = $this->game->id;
            $msg->played_game_id = $this->playedGame->id;
            $msg->type = UserMessage::TYPE_END_GAME;

            $gameDTO = new GameOfflineDTO();
            $gameDTO->opponentId = $this->userId;
            $gameDTO->playedGameId = $this->playedGame->id;
            if (isset($this->userOnline)) {
                $gameDTO->opponentName = $this->userOnline->session->username;
            }
            $gameDTO->turnUserId = 0;
            $msg->message = serialize($gameDTO);

            if (!$msg->save()) {
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
     * @throws CHttpException
     * @return array
     */
    public function getEndedGames()
    {
        $result = array();
        $endedGames = UserMessage::model()->findAll('to_user_id =:userId AND game_id=:gameId AND type=:msgType', array(':userId' => $this->userId, ':gameId' => $this->game->id, ':msgType' => UserMessage::TYPE_END_GAME));
        if ($endedGames) {
            foreach ($endedGames as $game) {
                $gameDTO = unserialize($game->message);
                array_push($result, $gameDTO);
                if (!$game->delete()) {
                    $message = "";
                    $errors = $game->getErrors();
                    foreach ($errors as $field => $error) {
                        $message .= $error[0] . ";";
                    }
                    throw new CHttpException(500, $message);
                }
            }
        }
        return $result;
    }

    /**
     * @param GameSubmission[] $submits
     * @param GameTagDTO $tag
     */
    private function updateSubmitToBonus($submits, $tag)
    {
        foreach ($submits as $submit) {
            $tagsArr = json_decode($submit->submission, true);
            $tmpTags = GameTagDTO::createFromArray($tagsArr);
            foreach ($tmpTags as &$tt) {
                if (strtolower($tt->tag) == strtolower($tag->tag)) {
                    $tt->type = "bonus";
                    $tt->score += 1;

                    $tagsArr = GameTagDTO::convertToArray($tmpTags);
                    $submit->submission = json_encode($tagsArr);

                    $submit->update();
                    return;
                }
            }
        }
    }
}
