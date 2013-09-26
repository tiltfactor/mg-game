<?php
/**
 *
 * @package
 */
class MultiplayerController extends ApiController
{

    public function filters()
    {
        return array( // add blocked IP filter here
            'throttle - bookmark, submit, validateSecret,disconnect, getEndedGames, endGame, register,getBookmarks, getInterests, getInstitutions, challenge, getChallenges, rejectChallenge, acceptChallenge, getOfflineGames, getOfflineGameState, addInterest, removeInterest, banInstitution, unbanInstitution, getInstitution',
            'IPBlock',
            'APIAjaxOnly - validateSecret,disconnect', // custom filter defined in this class accepts only requests with the header HTTP_X_REQUESTED_WITH === 'XMLHttpRequest'
            'accessControl - validateSecret,disconnect',
            'sharedSecret - validateSecret,disconnect', // the API is protected by a shared secret this filter ensures that it is regarded
        );
    }

    /**
     * Defines the access rules for this controller
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('register',
                    'findOpponent',
                    'pair',
                    'rejectPair',
                    'submit',
                    'validateSecret',
                    'disconnect',
                    'challenge',
                    'endGame',
                    'getEndedGames',
                    'acceptChallenge',
                    'rejectChallenge',
                    'getChallenges',
                    'getOfflineGames',
                    'getOfflineGameState',
                    'getBookmarks',
                    'bookmark',
                    'getInterests',
                    'addInterest',
                    'removeInterest',
                    'getInstitutions',
                    'getInstitution',
                    'banInstitution',
                    'unbanInstitution'
                ),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * Register a player to the game
     * string JSON response with game and user info message on success will be send
     *
     * @param $gid
     * @throws CHttpException
     */
    public function actionRegister($gid)
    {
        $data = array();
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }
        if ($gameEngine->registerUserOnline()) {
            $data['game'] = $gameEngine->getGameInfo();
            $data['user'] = $gameEngine->getUserInfo();
            $this->sendResponse($data);
        } else {
            throw new CHttpException(400, Yii::t('app', 'Invalid request.'));
        }
    }

    /**
     * Find opponenet by username or if username is not set find random waiting opponent
     * string JSON response will be send of GameUserDTO object or null
     *
     * @param string $gid
     * @param string $username
     * @throws CHttpException
     */
    public function actionFindOpponent($gid, $username)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $player = $gameEngine->requestPair($username);
        $this->sendResponse($player);
    }

    /**
     * @param $gid
     * @param $id
     */
    public function actionPair($gid, $id)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $gameEngine->pair($id);
    }

    /**
     * Opponent reject pair request
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param int $id
     * @throws CHttpException
     */
    public function actionRejectPair($gid, $id)
    {
        $data = array();
        $data['status'] = "ok";
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        try {
            $gameEngine->rejectPair($id);
            $this->sendResponse($data);
        } catch (CException $e) {
            throw new CHttpException(400, $e->getMessage());
        }
    }

    /**
     * submit game tags
     * Tags should be send as POST parameter tags
     * Sent tags should be json encode of GameTagDTO[]
     * Response sent is json encode of GameTagDTO[]
     *
     * @param string $gid
     * @param int $playedGameId
     * @throws CHttpException
     */
    public function actionSubmit($gid, $playedGameId)
    {
        if ($playedGameId > 0) {
            $_POST['playedGameId'] = $playedGameId;
        }
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $tags = array();
        //$_POST["tags"] = '[{"tag":"Test","original":null,"score":null,"weight":null,"mediaId":"6","type":null,"tag_id":null}]';
        if (isset($_POST["tags"])) {
            $tags = GameTagDTO::createTagsFromJson($_POST["tags"]);
        }

        if (empty($tags)) {
            throw new CHttpException(400, Yii::t('app', 'No tags sent'));
        }

        $gameEngine->submit($tags);

        $this->sendResponse($tags);
    }

    /**
     * @param $secret
     */
    public function actionValidateSecret($secret)
    {
        $session = Session::model()->find('user_id IS NOT NULL AND shared_secret=:ss', array(':ss' => $secret));
        if ($session) {
            $data = array();
            $data['uid'] = $session->user_id;
            $this->sendResponse($data);
        } else {
            $this->sendResponse($secret . " not found", 404);
        }
    }

    /**
     * @param $uid
     * @param $gid
     */
    public function actionDisconnect($uid, $gid)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $gameEngine->disconnect($uid);
    }

    /**
     * challenge game player by username or select one random
     * Response sent is json encode of GameUserDTO
     *
     * @param string $gid
     * @param string $username
     * @throws CHttpException
     */
    public function actionChallenge($gid, $username)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $result = $gameEngine->challenge($username);
        $this->sendResponse($result);
    }

    /**
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param int $opponentId
     */
    public function actionAcceptChallenge($gid, $opponentId)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $playedGameId = $gameEngine->acceptChallenge($opponentId);
        $data = array();
        $data['status'] = "ok";
        $data['playedGameID'] = $playedGameId;
        $this->sendResponse($data);
    }

    /**
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param int $fromUserId is the user id who sent the challenge
     * @param int $toUserId is the user id who has been challenged
     */
    public function actionRejectChallenge($gid, $fromUserId, $toUserId)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $gameEngine->rejectChallenge($fromUserId, $toUserId);
        $data['status'] = "ok";
        $this->sendResponse($data);
    }

    /**
     * get my requested challenges
     * Response sent is json encode of GameChallengesDTO
     *
     * @param string $gid
     */
    public function actionGetChallenges($gid)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $result = $gameEngine->getChallenges();
        $this->sendResponse($result);
    }

    /**
     * get all not finished offline games
     * Response sent is json encode of GameOfflineDTO[]
     *
     * @param string $gid
     */
    public function actionGetOfflineGames($gid)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $result = $gameEngine->getOfflineGames();
        $this->sendResponse($result);
    }

    /**
     * Get current game state
     * Response sent is json encode of GameStateDTO
     *
     * @param string $gid
     * @param int $playedGameId
     */
    public function actionGetOfflineGameState($gid, $playedGameId)
    {
        $_POST['playedGameId'] = $playedGameId;
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }
        $result = $gameEngine->getOfflineGameState($playedGameId);
        $this->sendResponse($result);
    }


    /**
     * Get bookmarked media files of the user
     * Response sent is json encode of GameMediaDTO[]
     *
     * @param string $gid
     */
    public function actionGetBookmarks($gid)
    {
        Yii::import("games.components.*");
        $bookmark = new MGBookmark($gid);
        if (is_null($bookmark)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $medias = $bookmark->getAll();
        $this->sendResponse($medias);
    }

    /**
     * Bookmark media file
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param int $mediaId
     * @param int $playedId
     */
    public function actionBookmark($gid, $mediaId, $playedId)
    {
        Yii::import("games.components.*");

        $bookmark = new MGBookmark($gid);

        if (is_null($bookmark)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $bookmark->add($mediaId, $playedId);
        $data = array();
        $data['status'] = "ok";
        $this->sendResponse($data);
    }

    /**
     * Get user's interests
     * Response sent is json encode of GameInterestDTO[]
     *
     * @param string $gid
     */
    public function actionGetInterests($gid)
    {
        Yii::import("games.components.*");
        $component = new MGInterest($gid);
        if (is_null($component)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $result = $component->getAll();
        $this->sendResponse($result);
    }

    /**
     * Add user interests
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param string $interest
     */
    public function actionAddInterest($gid, $interest)
    {
        Yii::import("games.components.*");
        $component = new MGInterest($gid);
        if (is_null($component)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $component->add($interest);
        $data = array();
        $data['status'] = "ok";
        $this->sendResponse($data);
    }

    /**
     * Remove user interests
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param int $id
     */
    public function actionRemoveInterest($gid, $id)
    {
        Yii::import("games.components.*");
        $component = new MGInterest($gid);
        if (is_null($component)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $component->remove($id);
        $data = array();
        $data['status'] = "ok";
        $this->sendResponse($data);
    }

    /**
     * Get all active institutions
     * Response sent is json encode of GameUserInstitutionDTO[]
     *
     * @param string $gid
     * @param int $id
     */
    public function actionGetInstitution($gid, $id)
    {
        Yii::import("games.components.*");
        $component = new MGUserInstitution($gid);
        if (is_null($component)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $this->sendResponse($component->getByID($id));
    }

    /**
     * Get all active institutions
     * Response sent is json encode of GameUserInstitutionDTO[]
     *
     * @param string $gid
     */
    public function actionGetInstitutions($gid)
    {
        Yii::import("games.components.*");
        $component = new MGUserInstitution($gid);
        if (is_null($component)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $this->sendResponse($component->getAll());
    }

    /**
     * User ban an institution
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param int $id
     */
    public function actionBanInstitution($gid, $id)
    {
        Yii::import("games.components.*");
        $component = new MGUserInstitution($gid);
        if (is_null($component)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $component->ban($id);
        $data = array();
        $data['status'] = "ok";
        $this->sendResponse($data);
    }

    /**
     * User unban institution
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param int $id
     */
    public function actionUnbanInstitution($gid, $id)
    {
        Yii::import("games.components.*");
        $component = new MGUserInstitution($gid);
        if (is_null($component)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $component->unban($id);
        $data = array();
        $data['status'] = "ok";
        $this->sendResponse($data);
    }

    /**
     * User end game
     * string JSON response with status message on success will be send
     *
     * @param string $gid
     * @param int $playedGameId
     */
    public function actionEndGame($gid, $playedGameId)
    {
        $_POST['playedGameId'] = $playedGameId;
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $gameEngine->gameEnd();

        $data = array();
        $data['status'] = "ok";
        $this->sendResponse($data);
    }

    /**
     * Get ended games for which user is not notified
     * Response sent is json encode of GameOfflineDTO[]
     *
     * @param string $gid
     */
    public function actionGetEndedGames($gid)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            $this->sendResponse(Yii::t('app', 'Internal Server Error.'), 500);
        }

        $this->sendResponse($gameEngine->getEndedGames());
    }
}
