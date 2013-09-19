<?php

class MGInterest extends CComponent
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
     * @var int
     */
    protected $userId;


    /**
     * @param string $unique_id
     * @throws CHttpException
     */
    function __construct($unique_id)
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
        }
    }


    /**
     * @return GameInterestDTO[]
     */
    public function getAll()
    {
        $query = 'user_id =:userId AND game_id=:gameId';

        /**
         * @var UserGameInterest[] $interests
         */
        $interests = UserGameInterest::model()->findAll($query, array(':userId' => $this->userId, ':gameId' => $this->game->id));
        $result = array();
        if ($interests) {
            foreach ($interests as $interest) {
                $dto = new GameInterestDTO();
                $dto->id = $interest->id;
                $dto->interest = $interest->interest;
                $dto->created = $interest->created;
                array_push($result, $dto);
            }
        }

        return $result;
    }

    /**
     * @param string $interest
     * @throws CHttpException
     */
    public function add($interest)
    {
        $model = new UserGameInterest();
        $model->user_id = $this->userId;
        $model->game_id = $this->game->id;
        $model->interest = $interest;
        $model->created = date('Y-m-d H:i:s');

        if (!$model->save()) {
            $message = "";
            $errors = $model->getErrors();
            foreach ($errors as $field => $error) {
                $message .= $error[0] . ";";
            }
            throw new CHttpException(500, $message);
        }
    }

    /**
     * @param int $id
     * @throws CHttpException
     */
    public function remove($id)
    {
        $model = UserGameInterest::model()->findByPk($id);
        if ($model) {
            if (!$model->delete()) {
                $message = "";
                $errors = $model->getErrors();
                foreach ($errors as $field => $error) {
                    $message .= $error[0] . ";";
                }
                throw new CHttpException(500, $message);
            }
        }
    }
}
