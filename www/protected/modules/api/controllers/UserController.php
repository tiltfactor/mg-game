<?php

class UserController extends ApiController
{

    public function filters()
    {
        return array( // add blocked IP filter here
            'throttle - login, sharedsecret, register',
            'IPBlock',
            'APIAjaxOnly', // custom filter defined in this class accepts only requests with the header HTTP_X_REQUESTED_WITH === 'XMLHttpRequest'
            'accessControl - messages, abort, abortpartnersearch, gameapi, postmessage',
            'sharedSecret', // the API is protected by a shared secret this filter ensures that it is regarded
        );
    }

    /**
     * Defines the access rules for this controller
     */
    public function accessRules()
    {
        return array(
            array('allow',

                'actions' => array('index', 'login', 'register', 'user', 'passwordrecovery', 'sharedsecret', 'sociallogin', 'test'),

                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('profile', 'passwordchange', 'logout'),
                'roles' => array(PLAYER, INSTITUTION, EDITOR, ADMIN),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * This action displays the a default page in case someone tries to consume
     * the page via the browser.
     */
    public function actionIndex()
    {
        parent::actionIndex();
    }

    /**
     * Returns a shared secret for the user that will be saved in the session. Each further request has
     * to be signed with this shared secret. This should happen by setting a custom header
     * HTTP_X_<fbvStorage(api_id)>_SHARED_SECRET
     *
     * It will return the following array
     *
     * JSON: it will return either
     * {shared_secret:'USERS SHARED SECRET'}
     *
     * @return string JSON response
     */
    public function actionSharedSecret()
    {
        $data = array();
        $data['status'] = "ok";
        $data['shared_secret'] = MGHelper::createSharedSecretAndSession(Yii::app()->user->id, Yii::app()->user->name);
        $this->sendResponse($data);
    }

    /**
     * Attempts to login a user. It expects to receive
     *
     * Needs POST request
     * needs fields login and password
     *
     * JSON: it will return either
     * {status:'ok'} or HTTP status 400 and {"errors":{"field":["Error Message"]}}
     *
     * @return string JSON response
     * @throws CHttpException if the request is not a Post request or one of the needed fields is not set
     */
    public function actionLogin()
    {
        if (Yii::app()->getRequest()->getIsPostRequest() && isset($_POST['login']) && isset($_POST['password'])) {
            // collect user input data
            Yii::import("application.modules.user.components.UserIdentity");
            Yii::import("application.modules.user.models.UserLogin");

            $model = new UserLogin;
            $model->username = $_POST['login'];
            $model->password = $_POST['password'];
            $model->rememberMe = false;

            $data = array();
            // validate user input and redirect to previous page if valid
            if ($model->validate()) { // validate mean the user's credentials where correct
                $model->setLastVisit();
                $data = array();
                $data['status'] = "ok";
                $this->sendResponse($data);
            } else {
                $data = array();
                $data['status'] = "error";
                $data['errors'] = $model->getErrors();
                $this->sendResponse($data, 403);
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    /**
     * Attempts to logout the user.
     * It has to be called via a GET request.
     *
     * The currently logged in user will be logged out and the session destroyed
     *
     * JSON: it will return
     * {status:'ok'} or throw an exception
     *
     * @return string JSON response
     * @throws CHttpException if the request is not a GET request
     */
    public function actionLogout()
    {
        if (Yii::app()->getRequest()->getIsGetRequest()) {
            Yii::app()->session->clear(); //remove all of the session variables.
            Yii::app()->user->logout();
            $data = array();
            $data['status'] = "ok";
            $this->sendResponse($data);
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    /**
     * This is the password recovery action action.
     * It has to be called via a POST request.
     *
     * If receives a user name or email address in a field called "login_or_email". If either
     * name or email are found an password reset email will be generated and send to the user.
     *
     * JSON: it will return either
     * {status:'ok'} or HTTP status 400 and {"errors":{"field":["Error Message"]}}
     *
     * @return string JSON response
     * @throws CHttpException if the request is not a POST request
     */
    public function actionPasswordRecovery()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            Yii::import("application.modules.user.components.UFrontendActionHelper");
            Yii::import("application.modules.user.models.UserRecoveryForm");
            $frontendArctions = new UFrontendActionHelper;
            $frontendArctions->passwordRecovery($this);
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionRegister()
    {
        Yii::import("application.modules.user.models.RegistrationForm"); // pkostov include the model
        Yii::import("application.modules.user.UserModule"); // pkostov. Thus Yii::app()->controller->module->activeAfterRegister  <= will be just => activeAfterRegister. The path is C:\xampp\htdocs\mgg\www\protected\modules\user\UserModule.php
        $model = new RegistrationForm;
        $data = array(); // will handle the response
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $email = trim($_POST['email']);

        $sanitized_mail = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($sanitized_mail, FILTER_VALIDATE_EMAIL)) {
            $data['status'] = "error";
            $data['responseText'] = "Please enter a valid email address";
            $this->sendResponse($data);
            Yii::app()->end();
        }
        $check_array = array('username' => array(32, "username"), 'password' => array(32, "password"), 'email' => array(128, "email"));

        foreach ($check_array as $key => $value) {
            if (strlen($$key) > $value[0]) {
                $data['status'] = "error";
                $data['responseText'] = $value[1] . " is too long.";
                $this->sendResponse($data);
                Yii::app()->end();
            }
        }

        if (empty($username) || empty($password) || empty($email)) {
            $data['status'] = "error";
            $data['responseText'] = "Please fill all fields";
            $this->sendResponse($data);
            Yii::app()->end();
        }

        $unique_username_test = User::model()->searchForNames($username);
        $unique_email_test = User::model()->searchForEmail($email);
        if (!empty($unique_username_test[0])) {
            $data['status'] = "error";
            $data['responseText'] = "Already existing user with that username. ";
            $this->sendResponse($data);
            Yii::app()->end();
        }
        if (!empty($unique_email_test[0])) {
            $data['status'] = "error";
            $data['responseText'] = "That email address has already been registered. ";
            $this->sendResponse($data);
            Yii::app()->end();
        }


        $model->username = $username;
        $model->password = $password;
        $model->email = $email;
        $model->verifyPassword = $password;

        $profile = new Profile;

        $profile->regMode = true;


        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->controller->module->profileUrl);
        } else {


            $soucePassword = $model->password;
            $model->activekey = UserModule::encrypting(microtime() . $model->password);
            $model->password = UserModule::encrypting($model->password);
            $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
            $model->created = date('Y-m-d H:i:s');
            $model->modified = date('Y-m-d H:i:s');
            $model->lastvisit = date('Y-m-d H:i:s');
            $model->role = 'player';
            $model->status = User::STATUS_ACTIVE;

            if ($model->save(false)) {

                $profile->user_id = $model->id;
                $profile->save();

                $data['status'] = "ok";
                $data['responseText'] = "Thank you for your registration. Please login";
                $this->sendResponse($data);
                Yii::app()->end();
            }


        }
    }

    public function actionSocialLogin() // pkostov
    {

        $data = array();
        if (isset($_GET['api_key'])) {
            $data = array();
            $data['status'] = "okkkk";
            $data['message'] = 'The api key is set';
            $this->sendResponse($data);
        }

        if (isset($GLOBALS['social'])) unset($GLOBALS['social']);
        $GLOBALS['social'] = 'facebook';
        $provider = $_GET['provider'];

        try {
            Yii::import('application.components.HybridAuthIdentity');
            Yii::import('application.modules.user.components.UserIdentity');
            $haComp = new HybridAuthIdentity();

            if (!$haComp->validateProviderName($provider)) {
                // throw new CHttpException ('500', 'Invalid Action. Please try again.');
                $data['status'] = "error";
                $data['errors'] = 'not supported provider name';
                $this->sendResponse($data, 500);
            }

            $haComp->adapter = $haComp->hybridAuth->authenticate($provider); //  to  protected\extensions\HybridAuth\hybridauth-2.1.2\hybridauth\Auth.php

            $haComp->userProfile = $haComp->adapter->getUserProfile(); // <------------Here to Auth
            $haComp->processLogin($haComp); //<---- Here to hybridAuthIdentity   i.e. protected\components\HybridAuthIdentity.php

            $data['status'] = "ok";
            $data['message'] = "everything is OK!";
            $this->sendResponse($data);

        } catch (Exception $e) {
            $data['status'] = "exeption error";
            $data['message'] = $e->getMessage();
            $this->sendResponse($data);
            // $this->redirect(array('/site'));
            //  return;
        }
    }

    public function actionTest()
    {

        //  header("Location: http://www.example.com/"); // explode here
        //   $provider = $_GET['provider'];
        if (isset($_GET['api_key'])) {
            $data = array();
            $data['status'] = "okkkk";
            $data['message'] = 'The api key is set';
            $this->sendResponse($data);
        }
        $this->redirect(array('/site/login/provider/facebook'));
        $data = array();
        $data['status'] = "ok";
        $data['message'] = 'The provider isaasadadadsad1111aa:';
        $this->sendResponse($data);
    }
}