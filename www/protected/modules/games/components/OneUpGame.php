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
        if(isset($_POST['playedGameId'])){
            $playedGameId = $_POST['playedGameId'];
        }
        parent::__construct("OneUp", true,$playedGameId);
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

        if($this->playedGame->session_id_1 == $this->sessionId){
            $opponentId = $this->playedGame->sessionId2->user_id;
        }else{
            $opponentId = $this->playedGame->sessionId1->user_id;
        }
        $opponentOnline = UserOnline::model()->find('user_id =:userId', array(':userId' => $opponentId));

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

                            $this->pushMessage($this->userOnline->user_id,MGMultiPlayer::PUSH_PENALTY,json_encode(-1));
                            if ($opponentOnline) {
                                $this->pushMessage($opponentId,MGMultiPlayer::PUSH_BONUS,json_encode(1));
                            }

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

        $submissions += 1;
        if ($submissions == $this->game->submissions) {
            $opponentSubmissions = count($playerTagDTOs[$this->gameTurn->turn]);
            if ($opponentSubmissions == $this->game->submissions) {
                $this->createGameTurn();
            } else {
                if ($opponentOnline) {
                    $this->pushMessage($opponentId,MGMultiPlayer::PUSH_OPPONENT_WAITING,json_encode($this->playedGame->id));
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
        if($userOnline){
            if(!$userOnline->delete()){
                $message = "";
                $errors = $userOnline->getErrors();
                foreach ($errors as $field => $error) {
                    $message .= $error[0] . ";";
                }
                throw new CHttpException(500, $message);
            }
        }
    }

    public function gameEnd()
    {
        $this->playedGame->finished = date('Y-m-d H:i:s');
        if( !$this->playedGame->save()){
            $message = "";
            $errors = $this->playedGame->getErrors();
            foreach ($errors as $field => $error) {
                $message .= $error[0] . ";";
            }
            throw new CHttpException(500, $message);
        }

        if($this->sessionId == $this->playedGame->session_id_1){
            $score =  $this->playedGame->score_1;
            $opponentScore = $this->playedGame->score_2;
            $opponentId = $this->playedGame->sessionId2->user_id;
        }else{
            $score =  $this->playedGame->score_2;
            $opponentScore = $this->playedGame->score_1;
            $opponentId = $this->playedGame->sessionId1->user_id;
        }
        $this->saveUserToGame($score);

        $userToGame = UserToGame::model()->findByPk(array(
            "user_id" => $opponentId,
            "game_id" => $this->game->id,
        ));
        if ($userToGame) {
            $userToGame->saveCounters(array('number_played' => 1, 'score' => $opponentScore));
        }

        if(isset($this->userOnline) && $this->userOnline->session_id == $this->sessionId){
            $this->userOnline->played_game_id = null;
            $this->userOnline->status = UserOnline::STATUS_WAIT;
            $this->userOnline->save();
        }

        if(isset($this->userOnline)){
            $this->pushMessage($this->userOnline->user_id,MGMultiPlayer::PUSH_GAME_END,json_encode($this->playedGame->id));
        }

        $opponentOnline = UserOnline::model()->find('user_id =:userId', array(':userId' => $opponentId));
        if ($opponentOnline) {
            $this->pushMessage($opponentId,MGMultiPlayer::PUSH_GAME_END,json_encode($this->playedGame->id));
        }
    }
}
