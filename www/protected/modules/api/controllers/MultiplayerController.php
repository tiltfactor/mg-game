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
            'throttle - messages, abort, abortpartnersearch, postmessage',
            'IPBlock',
            //'APIAjaxOnly', // custom filter defined in this class accepts only requests with the header HTTP_X_REQUESTED_WITH === 'XMLHttpRequest'
            'accessControl - messages, abort, abortpartnersearch, gameapi, postmessage',
            //'sharedSecret', // the API is protected by a shared secret this filter ensures that it is regarded
        );
    }

    /**
     * Defines the access rules for this controller
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('register', 'findOpponent', 'pair', 'rejectPair'),
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
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }
        if ($gameEngine->registerGamePlayer()) {
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
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $player = $gameEngine->requestPair($username);
        $this->sendResponse($player);
    }

    public function actionPair($gid, $id)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
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
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
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
     * @param $gid
     * @throws CHttpException
     */
    public function actionSubmit($gid)
    {
        $gameEngine = GamesModule::getMultiplayerEngine($gid);
        if (is_null($gameEngine)) {
            throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
        }

        $tags = array();
        if (isset($_POST["tags"])) {
            $tags = GameTagDTO::createTagsFromJson($_POST["tags"]);
        }

        if (empty($tags)) {
            throw new CHttpException(400, Yii::t('app', 'No tags sent'));
        }

        $gameEngine->submit($tags);

        $this->sendResponse($tags);
    }
}
