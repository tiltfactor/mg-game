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
                'actions' => array('update'),
                'roles' => array(ADMIN),
            ),
            array('allow',
                'actions' => array('view'),
                'roles' => array(EDITOR),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $game = GamesModule::loadGame("OneUp");
        if ($game) {
            $cs = Yii::app()->clientScript;
            $cs->registerCoreScript('jquery');
            $cs->registerCoreScript('jquery.ui');
            $cs->registerCssFile(Yii::app()->baseUrl . '/js/jquery.toastmessage/css/jquery.toastmessage-min.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/oneup/css/main.css');
            //$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/modernizr.custom.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.deviceTest.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/retina.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.sounds.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.hammer.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tmpl.min.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.game.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mmenu.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.toastmessage/jquery.toastmessage-min.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/oneup/js/mg.game.oneup.main.js', CClientScript::POS_END);
            $throttleInterval = (int)Yii::app()->fbvStorage->get("settings.throttle_interval", 1500);
            $asset_url = Yii::app()->baseUrl;
            $arcade_url = Yii::app()->getRequest()->getHostInfo() . Yii::app()->createUrl('/');
            $nodeJSUrl = Yii::app()->fbvStorage->get("nodeJSUrl");
            $pushUrl = Yii::app()->fbvStorage->get("pushUrl");
            $developmentMode = Yii::app()->fbvStorage->get("developmentMode");
            $weineDebugUrl = Yii::app()->fbvStorage->get("weinreUrl") . "/target/target-script-min.js#anonymous";

            $js = <<<EOD
            MG_INIT = {};
            MG_INIT.nodeJSUrl = '$nodeJSUrl';
            MG_INIT.pushUrl = '{$pushUrl}';
            MG_INIT.developmentMode = '$developmentMode';

Modernizr.addTest('development_mode', function() {
    if ( typeof MG_INIT !== 'undefined' && MG_INIT.developmentMode === 'true') {
        return true;
    } else {
        return false;
    }
});

yepnope({
  test : Modernizr.development_mode,
  yep  : ["http://jsconsole.com/remote.js?7DA9E1A3-4EE0-4DC0-9AFF-81427DECD9F5", "{$weineDebugUrl}"]
});

    MG_GAME_ONEUP.init({
        gid : 'OneUp',
        app_id : 'MG_API',
        asset_url : '$asset_url',
        api_url : '{$game->api_base_url}',
        arcade_url : '$arcade_url',
        game_base_url : '{$game->game_base_url}',
        throttleInterval : $throttleInterval
    });
EOD;
            Yii::app()->clientScript->registerScript(__CLASS__ . '#game', $js, CClientScript::POS_READY);

            $this->layout = '//layouts/mobile';

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
