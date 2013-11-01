<?php

class DefaultController extends Controller
{
    public function filters()
    {
        return array(
            'Installed',
            'IPBlock',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('*'),
            ),
            array('deny'),
        );
    }

    public function actionIndex()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile(SearchModule::getAssetsUrl() . '/css/main.css');
        $cs->registerCssFile(Yii::app()->baseUrl . '/css/normalize.css');
        $cs->registerScriptFile(Yii::app()->baseUrl . '/js/modernizr.custom.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(SearchModule::getAssetsUrl() . '/js/search.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tmpl.min.js', CClientScript::POS_HEAD);

        $institutions = Institution::model()->with('collections')->findAll('status=1');

        $model = new Media('search');
        $model->unsetAttributes();

        if (isset($_GET['Media']))
            $model->setAttributes($_GET['Media']);

        $user = User::loadUser(Yii::app()->user->id);
        if ($user && $user->role == INSTITUTION) {
            $institutions = Institution::model()->find('user_id=' . Yii::app()->user->Id);
            $model->setAttribute('institution_id', $institutions->id);
        }

        $this->render('index',
            array(
                'model' => $model,
                'setTypeOrder' => isset( $_GET['Custom']['type_sort'])  ? $_GET['Custom']['type_sort'] : 'relevance',
                'setItemsPerPage' => isset( $_GET['Custom']['items_per_page']) ? $_GET['Custom']['items_per_page'] : 25,
                'institutions' =>  $institutions,
                'assets_url' => SearchModule::getAssetsUrl(),
                'userRole'=> $user->role,
            )
        );
    }
}
