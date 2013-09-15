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
                'roles' => array(ADMIN),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        PyramidGame::reset();
        MGHelper::setFrontendTheme();

        $game = GamesModule::loadGame("OneUp");

        if ($game) {
            $cs = Yii::app()->clientScript;
            $cs->registerCoreScript('jquery');
            $cs->registerCssFile(Yii::app()->baseUrl . '/css/jquery.fancybox-1.3.4.css');
            $cs->registerCssFile(Yii::app()->baseUrl . '/css/normalize.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/oneup/css/main.css');
            $cs->registerCssFile(Yii::app()->baseUrl . '/js/jquery.toastmessage/css/jquery.toastmessage-min.css');
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/modernizr.custom.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.deviceTest.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/retina.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tmpl.min.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.game.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.toastmessage/jquery.toastmessage-min.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/oneup/js/mg.game.oneup.main.js', CClientScript::POS_HEAD);
            $throttleInterval = (int)Yii::app()->fbvStorage->get("settings.throttle_interval", 1500);
            $asset_url = Yii::app()->baseUrl;
            $arcade_url = Yii::app()->getRequest()->getHostInfo() . Yii::app()->createUrl('/');

            $js = "";
            Yii::app()->clientScript->registerScript(__CLASS__ . '#game', $js, CClientScript::POS_READY);

            $this->layout = '//layouts/column1';

            $this->render('index', array(
                'game' => $game,
                'asset_url' => GamesModule::getAssetsUrl()."/oneup",
                'game_url' => $game->game_base_url
            ));
        } else {
            throw new CHttpException(403, Yii::t('app', 'The game is not active.'));
        }
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
