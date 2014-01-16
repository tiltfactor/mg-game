<?php

/**
 *
 *
 * @package
 */
class PyramidController extends GxController
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

    /**
     * As most of the game play is handled via JavaScript and API callbacks the controller
     * renders only the initial needed HTML while making sure all needed assets CSS
     * and JavaScript are loaded
     */
    public function actionIndex()
    {
        PyramidGame::reset();
        MGHelper::setFrontendTheme();

        $game = GamesModule::loadGame("Pyramid");
        if ($game) {
            $cs = Yii::app()->clientScript;
            $cs->registerCoreScript('jquery');
            $cs->registerCoreScript('jquery.ui');
            $cs->registerCssFile(Yii::app()->baseUrl . '/css/jquery.fancybox-1.3.4.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/pyramid/css/normalize.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/pyramid/css/main.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/pyramid/css/style.css');
            $cs->registerCssFile(Yii::app()->baseUrl . '/js/jquery.countdown/jquery.countdown.css');
            $cs->registerCssFile(Yii::app()->baseUrl . '/js/jquery.toastmessage/css/jquery.toastmessage-min.css');
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/pyramid/js/modernizr.custom.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.deviceTest.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/retina.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mmenu.js', CClientScript::POS_HEAD);
            $cs->registerCssFile(Yii::app()->baseUrl . '/css/mmenu.css');
            //$cs->registerCssFile(Yii::app()->baseUrl . '/css/mmenu-positioning.css');
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.fancybox-1.3.4.pack.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.hammer.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tmpl.min.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.game.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.toastmessage/jquery.toastmessage-min.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/pyramid/js/mg.game.pyramid.main.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/pyramid/js/mg.game.pyramid_splash.js', CClientScript::POS_END);
            $throttleInterval = (int)Yii::app()->fbvStorage->get("settings.throttle_interval", 1500);
            $asset_url = Yii::app()->baseUrl;
            $arcade_url = Yii::app()->getRequest()->getHostInfo() . Yii::app()->createUrl('/');
           if (Yii::app()->user->isGuest) {
                $isLogged = 'false';
            } else {
                $isLogged = 'true';
            };
            $currentUser = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
            if($currentUser != null)
            {
                $currentUserUsername = $currentUser->username;
                $currentUserEmail = $currentUser->email;
            }
            else
            {
                $currentUserUsername = "";
                $currentUserEmail = "";
            };

            $js = <<<EOD
MG_PYRAMID = {};
MG_PYRAMID.api_url = '{$game->api_base_url}';
MG_PYRAMID.nlp_api_url = '{$game->nlp_api_base_url}';
MG_PYRAMID.isLogged = '{$isLogged}';
MG_PYRAMID.gid = 'Pyramid';
MG_PYRAMID.game_base_url = '{$game->game_base_url}';
MG_PYRAMID.arcade_url = '$arcade_url';
MG_PYRAMID.username = '{$currentUserUsername}';
MG_PYRAMID.email = '{$currentUserEmail}';

EOD;
            Yii::app()->clientScript->registerScript(__CLASS__ . '#game', $js, CClientScript::POS_HEAD);

            $this->layout = '//layouts/mobile';

            $this->render('index', array(
                'game' => $game,
                'asset_url' => GamesModule::getAssetsUrl()."/pyramid",
                'game_url' => $game->game_base_url
            ));
        } else {
            throw new CHttpException(403, Yii::t('app', 'The game is not active.'));
        }
    }

    public function actionPlay()
    {
        PyramidGame::reset();
        MGHelper::setFrontendTheme();

        $game = GamesModule::loadGame("Pyramid");
        if ($game) {
            $cs = Yii::app()->clientScript;
            $cs->registerCoreScript('jquery');
            $cs->registerCoreScript('jquery.ui');
            $cs->registerCssFile(Yii::app()->baseUrl . '/css/jquery.fancybox-1.3.4.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/pyramid/css/normalize.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/pyramid/css/main.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/pyramid/css/style.css');
            $cs->registerCssFile(Yii::app()->baseUrl . '/js/jquery.countdown/jquery.countdown.css');
            $cs->registerCssFile(Yii::app()->baseUrl . '/js/jquery.toastmessage/css/jquery.toastmessage-min.css');
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.sounds.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/pyramid/js/modernizr.custom.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.deviceTest.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/retina.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.fancybox-1.3.4.pack.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tmpl.min.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mmenu.js', CClientScript::POS_HEAD);
            $cs->registerCssFile(Yii::app()->baseUrl . '/css/mmenu.css');
            $cs->registerCssFile(Yii::app()->baseUrl . '/css/mmenu-positioning.css');
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.game.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.hammer.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.countdown/jquery.countdown.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.toastmessage/jquery.toastmessage-min.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/pyramid/js/mg.game.pyramid.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/pyramid/js/mg.game.pyramid.main.js', CClientScript::POS_HEAD);
            $throttleInterval = (int)Yii::app()->fbvStorage->get("settings.throttle_interval", 1500);
            $asset_url = Yii::app()->baseUrl;
            $arcade_url = Yii::app()->getRequest()->getHostInfo() . Yii::app()->createUrl('/');
            if (Yii::app()->user->isGuest) {
                $isLogged = 'false';
            } else {
                $isLogged = 'true';
            };
            $currentUser = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
            if($currentUser != null)
            {
                $currentUserUsername = $currentUser->username;
                $currentUserEmail = $currentUser->email;
            }
            else
            {
                $currentUserUsername = "";
                $currentUserEmail = "";
            };


            $js = <<<EOD
    MG_GAME_PYRAMID.init({
        gid : 'Pyramid',
        app_id : 'MG_API',
        asset_url : '$asset_url',
        api_url : '{$game->api_base_url}',
        arcade_url : '$arcade_url',
        game_base_url : '{$game->game_base_url}',
        play_once_and_move_on : {$game->play_once_and_move_on},
        play_once_and_move_on_url : '{$game->play_once_and_move_on_url}',
        throttleInterval : $throttleInterval
      });
EOD;
            $jsInit = <<<EOD
MG_PYRAMID = {};
MG_PYRAMID.api_url = '{$game->api_base_url}';
MG_PYRAMID.nlp_api_url = '{$game->nlp_api_base_url}';
MG_PYRAMID.isLogged = '{$isLogged}';
MG_PYRAMID.gid = 'Pyramid';
MG_PYRAMID.game_base_url = '{$game->game_base_url}';
MG_PYRAMID.arcade_url = '$arcade_url';
MG_PYRAMID.username = '{$currentUserUsername}';
MG_PYRAMID.email = '{$currentUserEmail}';

EOD;
            Yii::app()->clientScript->registerScript(__CLASS__ . '#game', $jsInit, CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScript(__CLASS__ . '#game', $js, CClientScript::POS_READY);

            /*            if ($game->play_once_and_move_on == 1) {
                            $this->layout = '//layouts/main_no_menu';
                        } else {
                            $this->layout = '//layouts/column1';
                        }*/

            $this->layout = '//layouts/mobile';

            $this->render('play', array(
                'game' => $game,
                'asset_url' => GamesModule::getAssetsUrl()."/pyramid",
                'game_url' => $game->api_base_url
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
        $app = Yii::app();
        $model = $this->loadModel(array("unique_id" => "Pyramid"), 'Pyramid');
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
        $model = $this->loadModel(array("unique_id" => "Pyramid"), 'Pyramid');
        $model->fbvLoad();

        $this->performAjaxValidation($model, 'pyramid-form');
        if (isset($_POST['Pyramid'])) {
            $model->setAttributes($_POST['Pyramid']);

            $relatedData = array(
                'collections' => $_POST['Pyramid']['collections'] === '' ? null : $_POST['Pyramid']['collections'],
                'plugins' => $_POST['Pyramid']['plugins'] === '' ? null : $_POST['Pyramid']['plugins'],
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
