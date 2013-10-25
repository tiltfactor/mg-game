<?php

class UserController extends ApiController
{

    public function filters()
    {
        return array( // add blocked IP filter here
            'throttle - login, sharedsecret, register , update, logout, recoverypassword',
            'IPBlock',
            'APIAjaxOnly', // custom filter defined in this class accepts only requests with the header HTTP_X_REQUESTED_WITH === 'XMLHttpRequest'
            'accessControl - messages, abort, abortpartnersearch, gameApi, postmessage, ',
            'sharedSecret - sharedSecret, login ', // the API is protected by a shared secret this filter ensures that it is regarded
        );
    }

    /**
     * Defines the access rules for this controller
     */
    public function accessRules()
    {
        return array(
            array('allow',

                'actions' => array('index', 'login', 'register', 'user', 'passwordrecovery', 'sharedsecret', 'sociallogin', 'recoverypassword'),

                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('profile', 'passwordchange', 'logout', 'update'),
                'roles' => array(PLAYER, EDITOR, ADMIN, INSTITUTION),
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
            $rememberMe = false;
            if ($_POST['rememberMe']) {
                if (mb_strtoupper(trim($_POST['rememberMe'])) === "TRUE" || $_POST['rememberMe'] == 1) {
                    $rememberMe = true;
                }
            }
            $model->rememberMe = $rememberMe;
            $data = array();
            // validate user input and redirect to previous page if valid
            if ($model->validate()) { // validate mean the user's credentials where correct
                $model->setLastVisit();
                // $data = array();
                $data['status'] = "ok";
                $this->sendResponse($data);
            } else {
                //  $data = array();
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
     *
     * The currently logged in user will be logged out and the session destroyed
     *
     * JSON: it will return
     * {status:'ok'} or {status:'error'}
     *
     * @return string JSON response
     *
     */
    public function actionLogout()
    {
        $data = array();
        try {
            Yii::app()->session->destroy(); //remove all of the session variables.
            Yii::app()->user->logout();
            $data['status'] = "ok";
            $data['responseText'] = "You have been successfully logged out.";
            $this->sendResponse($data);
        } catch (Exception $e) {
            $data['status'] = "error";
            $data['responseText'] = $e->getMessage();
            $this->sendResponse($data);
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
        $verifyPassword = trim($_POST['verifyPassword']);

        if ($password != $verifyPassword) {
            $data['status'] = "error";
            $data['responseText'] = "Verify Password must be the same as Password! Please retype again.";
            $this->sendResponse($data);
            Yii::app()->end();
        }


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
        $model->verifyPassword = $verifyPassword;

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

    public function actionSocialLogin()
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
        }
    }

    /**
     * Update username, password or email.
     *
     * JSON: it will return
     * {status:'ok'} or {status:'error'}
     *
     */
    public function actionUpdate()
    {
        $data = array();

        $newUsername = $_POST['username'];
        $newPassword = $_POST['password'];
        $newEmail = $_POST['email'];

        if (empty($newPassword)) {
            $data['status'] = "error";
            $data['responseText'] = "Password can not be empty.";
            $this->sendResponse($data);
            Yii::app()->end();
        }

        $currentUserId = Yii::app()->user->id;

        $model = User::model()->notsafe()->findByPk($currentUserId);

        $model->username = $newUsername;
        $model->password = UserModule::encrypting($newPassword);

        $model->email = $newEmail;


        if ($model->validate()) {
            try {
                $model->save();
                $data['status'] = "ok";
                $data['responseText'] = "New data have been saved.";
                $this->sendResponse($data);
            } catch (Exception $e) {
                $data['status'] = "error";
                $data['responseText'] = $e->getMessage();
                $this->sendResponse($data);
            }
        } else {
            $data['status'] = "error";
            $data['responseText'] = "Validation did not pass. Existing username and/or email";
            $this->sendResponse($data);
        }
    }

    /**
     * Send a recovery link to the user`s mail in order to change his password.
     *
     * JSON: it will return
     * {status:'ok'} or {status:'error'}
     *
     */
    public function actionRecoveryPassword()
    {
        $data = array();
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['status'] = "error";
            $data['responseText'] = "Not a valid email address.";
            $this->sendResponse($data);
            Yii::app()->end();
        }
        $user = User::model()->notsafe()->findByAttributes(array('email' => $email));
        $activeKey = $user->activekey;
        $activationURL = 'http://' . $_SERVER['HTTP_HOST'] . Yii::app()->getBaseUrl() . '/index.php/user/login/restore-password/activekey/' . $activeKey . '/email/' . urlencode($email);
        if (empty($user)) {
            $data['status'] = "error";
            $data['responseText'] = "There is no user with this email.";
            $this->sendResponse($data);
            Yii::app()->end();
        }

        try {
            $message = new YiiMailMessage;
            $message->view = 'userPasswordRestore';
            $message->setSubject(UserModule::t("You have requested a password reset for {site_name}", array(
                '{site_name}' => Yii::app()->fbvStorage->get("settings.app_name"),)));

            //userModel is passed to the view
            $message->setBody(array(
                'user' => $user,
                'site_name' => Yii::app()->fbvStorage->get("settings.app_name"),
                'activation_url' => $activationURL
            ), 'text/html');

            $message->addTo($user->email);
            $message->from = Yii::app()->fbvStorage->get("settings.app_email");
            Yii::app()->mail->send($message);

            $data['status'] = "ok";
            $data['responseText'] = "Activation link has been sent. Please check your email.";
            $this->sendResponse($data);
        } catch (Exception $e) {
            $data['status'] = "error";
            $data['responseText'] = $e->getMessage();
            $this->sendResponse($data);
        }
    }
}