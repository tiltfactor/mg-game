<?php

/**
 *
 *
 * @package
 */
class StupidRobotController extends GxController
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
        StupidRobotGame::reset();
        MGHelper::setFrontendTheme();

        $game = GamesModule::loadGame("StupidRobot");
        if ($game) {
            $cs = Yii::app()->clientScript;
            $cs->registerCoreScript('jquery');
            $cs->registerCoreScript('jquery.ui');
            $cs->registerCssFile(Yii::app()->baseUrl . '/css/jquery.fancybox-1.3.4.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/stupidRobot/css/normalize.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/stupidRobot/css/main_new.css');
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.sounds.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile('http://code.createjs.com/preloadjs-0.3.0.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile('http://code.createjs.com/easeljs-0.6.0.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile('http://code.createjs.com/tweenjs-0.4.0.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile('http://code.createjs.com/movieclip-0.6.0.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.game.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/animation_intro.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/mg.game.stupidrobot.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/animation_gameplay.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/loopAudio.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/animation_score.js', CClientScript::POS_END);
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
    MG_GAME_STUPIDROBOT.idx_init({
        gid : 'StupidRobot',
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
MG_STUPIDROBOT = {};
MG_STUPIDROBOT.api_url = '{$game->api_base_url}';
MG_STUPIDROBOT.isLogged = '{$isLogged}';
MG_STUPIDROBOT.gid = 'StupidRobot';
MG_STUPIDROBOT.game_base_url = '{$game->game_base_url}';
MG_STUPIDROBOT.arcade_url = '$arcade_url';
MG_STUPIDROBOT.username = '{$currentUserUsername}';
MG_STUPIDROBOT.email = '{$currentUserEmail}';

EOD;
            Yii::app()->clientScript->registerScript(__CLASS__ . '#game', $jsInit, CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScript(__CLASS__ . '#game', $js, CClientScript::POS_READY);

            $this->layout = '//layouts/mobile';

            $this->render('index', array(
                'game' => $game,
                'asset_url' => GamesModule::getAssetsUrl()."/stupidRobot",
                'game_url' => $game->game_base_url
            ));
        } else {
            throw new CHttpException(403, Yii::t('app', 'The game is not active.'));
        }
    }

    public function actionPlay()
    {
        StupidRobotGame::reset();
        MGHelper::setFrontendTheme();

        $game = GamesModule::loadGame("StupidRobot");
        if ($game) {
            $cs = Yii::app()->clientScript;
            $cs->registerCoreScript('jquery');
            $cs->registerCoreScript('jquery.ui');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/stupidRobot/css/normalize.css');
            $cs->registerCssFile(GamesModule::getAssetsUrl() . '/stupidRobot/css/main_new.css');
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.sounds.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile('http://code.createjs.com/easeljs-0.6.0.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile('http://code.createjs.com/tweenjs-0.4.0.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile('http://code.createjs.com/movieclip-0.6.0.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/mg.game.api.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/intro.js', CClientScript::POS_BEGIN);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/animation_intro.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/mg.game.stupidrobot.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/animation_gameplay.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/loopAudio.js', CClientScript::POS_END);
            $cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/animation_score.js', CClientScript::POS_END);
            //$cs->registerScriptFile(GamesModule::getAssetsUrl() . '/stupidRobot/js/dommonster.js', CClientScript::POS_END);
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
    MG_GAME_STUPIDROBOT.init({
        gid : 'StupidRobot',
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
MG_STUPIDROBOT = {};
MG_STUPIDROBOT.api_url = '{$game->api_base_url}';
MG_STUPIDROBOT.isLogged = '{$isLogged}';
MG_STUPIDROBOT.gid = 'StupidRobot';
MG_STUPIDROBOT.game_base_url = '{$game->game_base_url}';
MG_STUPIDROBOT.arcade_url = '$arcade_url';
MG_STUPIDROBOT.username = '{$currentUserUsername}';
MG_STUPIDROBOT.email = '{$currentUserEmail}';

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
                'asset_url' => GamesModule::getAssetsUrl()."/stupidRobot",
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
        $model = $this->loadModel(array("unique_id" => "StupidRobot"), 'StupidRobot');
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
        $model = $this->loadModel(array("unique_id" => "StupidRobot"), 'StupidRobot');
        $model->fbvLoad();

        $this->performAjaxValidation($model, 'STUPIDROBOT-form');
        if (isset($_POST['StupidRobot'])) {
            $model->setAttributes($_POST['StupidRobot']);

            $relatedData = array(
                'collections' => $_POST['StupidRobot']['collections'] === '' ? null : $_POST['StupidRobot']['collections'],
                'plugins' => $_POST['StupidRobot']['plugins'] === '' ? null : $_POST['StupidRobot']['plugins'],
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
