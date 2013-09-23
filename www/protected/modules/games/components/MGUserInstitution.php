<?php

class MGUserInstitution extends CComponent
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
     * @return GameUserInstitutionDTO[]
     */
    public function getAll()
    {
        $result = array();
        /**
         * @var Institution[] $institutions
         */
        $institutions = Institution::model()->findAll('status=1');
        if ($institutions) {
            foreach ($institutions as $row) {
                $inst = new GameUserInstitutionDTO();
                $inst->id = $row->id;
                $inst->description = $row->description;
                $inst->logo = $row->logo_url;
                $inst->name = $row->name;
                $inst->isBanned = false;
                array_push($result, $inst);
            }
        }
        /**
         * @var UserGameBannedInstitution[] $bannedInsts
         */
        $bannedInsts = UserGameBannedInstitution::model()->findAll('user_id=:userId and game_id=:gameId', array(':userId' => $this->userId, ':gameId' => $this->game->id));

        if ($bannedInsts) {
            foreach ($bannedInsts as $row) {
                foreach ($result as $i => $row2) {
                    if ($row->id == $row2->id) {
                        $result[$i]->isBanned = true;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param int $institutionId
     * @return GameUserInstitutionDTO[]
     */
    public function getByID($institutionId)
    {
        $result = array();
        /**
         * @var Institution[] $institutions
         */
        $institutions = Institution::model()->findAll('status=1 and id=:institutionId', array(':institutionId' => $institutionId));
        if ($institutions) {
            foreach ($institutions as $row) {
                $inst = new GameUserInstitutionDTO();
                $inst->id = $row->id;
                $inst->description = $row->description;
                $inst->logo = $row->logo_url;
                $inst->name = $row->name;
                $inst->isBanned = false;
                array_push($result, $inst);
            }
        }
        /**
         * @var UserGameBannedInstitution[] $bannedInsts
         */
        $bannedInsts = UserGameBannedInstitution::model()->findAll('user_id=:userId and game_id=:gameId', array(':userId' => $this->userId, ':gameId' => $this->game->id));

        if ($bannedInsts) {
            foreach ($bannedInsts as $row) {
                foreach ($result as $i => $row2) {
                    if ($row->id == $row2->id) {
                        $result[$i]->isBanned = true;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param int $institutionId
     * @throws CHttpException
     */
    public function ban($institutionId)
    {
        $model = new UserGameBannedInstitution();
        $model->user_id = $this->userId;
        $model->game_id = $this->game->id;
        $model->institution_id = $institutionId;
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
     * @param int $institutionId
     * @throws CHttpException
     */
    public function unban($institutionId)
    {
        $model = UserGameBannedInstitution::model()->findAll('user_id=:userId and game_id=:gameId and institution_id=:instId', array(':userId' => $this->userId, ':gameId' => $this->game->id, 'instId' => $institutionId));

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
