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
        $cs->registerScriptFile(SearchModule::getAssetsUrl() . '/js/search.js', CClientScript::POS_END);

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
                'institutions' =>  $institutions
            )
        );
    }
}
