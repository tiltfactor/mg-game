<?php
/**
 *
 * @package
 */
class OneUpController extends GxController
{
    /**
     * @return array
     */
    public function filters()
    {
        return array(
            'IPBlock',
            'accessControl - index',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('play'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('view', 'update'),
                'roles' => array('dbmanager', 'admin'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
       //to do
    }

    /**
     * show the game's settings
     */
    public function actionView()
    {
        $model = $this->loadModel(array("unique_id" => "OneUp"), 'OneUp');
        $model->fbvLoad();

        $this->render('view', array(
            'model' => $model,
            'statistics' => GamesModule::getStatistics($model->id)
        ));
    }

    /**
     * edit the game's settings
     */
    public function actionUpdate()
    {
        $model = $this->loadModel(array("unique_id" => "OneUp"), 'OneUp');
        $model->fbvLoad();

        $this->performAjaxValidation($model, 'oneup-form');
        if (isset($_POST['OneUp'])) {
            $model->setAttributes($_POST['OneUp']);

            $relatedData = array(
                'collections' => $_POST['OneUp']['collections'] === '' ? null : $_POST['OneUp']['collections'],
                'plugins' => $_POST['OneUp']['plugins'] === '' ? null : $_POST['OneUp']['plugins'],
            );

            // save the games data in the database
            if ($model->saveWithRelated($relatedData)) {
                $model->fbvSave(); // but also save it in the settings file as each game uses FBVstorage

                MGHelper::log('update', 'Game ' . $model->name . ' updated');
                Flash::add('success', $model->name . ' ' . Yii::t('app', "Updated"));
                $this->redirect(array('view'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
}
