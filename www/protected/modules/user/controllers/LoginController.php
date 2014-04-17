<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
  
  public function filters() {
    return array( // add blocked IP filter here
        'IPBlock',
    );
  }
  
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		MGHelper::setFrontendTheme();  
    
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;

            // if called without specific returnUrl, set it to the previous page
            if (!isset($_POST['UserLogin']) && Yii::app()->user->returnUrl === Yii::app()->request->scriptUrl)
            {
                if (isset($_SERVER['HTTP_REFERER']))
                {
                    Yii::app()->user->setReturnUrl($_SERVER['HTTP_REFERER']);
                }
            }

            // collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
                    $model->setLastVisit();
                    //find the url that have /games in it, only return if come from a game page
					if (strpos(Yii::app()->user->returnUrl,'/index.php/games')!==false)
						$this->redirect(Yii::app()->user->returnUrl);
					else
						$this->redirect(Yii::app()->controller->module->returnUrl);
//                    if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
//                        $this->redirect(Yii::app()->controller->module->returnUrl);
//                    else
//                        $this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}

}