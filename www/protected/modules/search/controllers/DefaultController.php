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
                'users'=>array('*'),
            ),
            array('deny'),
        );
    }

    public function actionIndex()
    {

        $this->render('index',
            array(

            )
        );
    }
}
