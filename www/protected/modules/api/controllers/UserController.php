<?php

class UserController extends ApiController {

    public function filters() {
        return array( // add blocked IP filter here
            'throttle - login, sharedsecret, register',
            'IPBlock',
            'APIAjaxOnly', // custom filter defined in this class accepts only requests with the header HTTP_X_REQUESTED_WITH === 'XMLHttpRequest'
            'accessControl - messages, abort, abortpartnersearch, gameapi, postmessage',
            //'sharedSecret', // the API is protected by a shared secret this filter ensures that it is regarded
        );
    }

    /**
     * Defines the access rules for this controller
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'login', 'user', 'passwordrecovery', 'sharedsecret'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('profile', 'passwordchange', 'logout'),
                'roles' => array(PLAYER, EDITOR, ADMIN),
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
    public function actionIndex() {
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
    public function actionSharedSecret() {
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
    public function actionLogin() {
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
    public function actionLogout() {
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
    public function actionPasswordRecovery() {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            Yii::import("application.modules.user.components.UFrontendActionHelper");
            Yii::import("application.modules.user.models.UserRecoveryForm");
            $frontendArctions = new UFrontendActionHelper;
            $frontendArctions->passwordRecovery($this);
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionRegister() {
        $model = new RegistrationForm;
        $profile = new Profile;
        $profile->regMode = true;
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->controller->module->profileUrl);
        } else {
            if (isset($_POST['RegistrationForm'])) {
                $model->attributes = $_POST['RegistrationForm'];
                $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
                if ($model->validate() && $profile->validate()) {
                    $soucePassword = $model->password;
                    $model->activekey = UserModule::encrypting(microtime() . $model->password);
                    $model->password = UserModule::encrypting($model->password);
                    $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                    $model->created = date('Y-m-d H:i:s');
                    $model->modified = date('Y-m-d H:i:s');
                    $model->lastvisit = ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) && Yii::app()->controller->module->autoLogin) ? date('Y-m-d H:i:s') : NULL;
                    $model->role = 'player';
                    $model->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
                    if ($model->save()) {
                        $profile->user_id = $model->id;
                        $profile->save();
                        if (Yii::app()->controller->module->sendActivationMail) {
                            $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activekey" => $model->activekey, "email" => $model->email));
                            $message = new YiiMailMessage;
                            $message->view = 'userRegistrationConfirmation';
                            $message->setSubject(UserModule::t("You registered from {site_name}", array('{site_name}' => Yii::app()->fbvStorage->get("settings.app_name"))));
                            //userModel is passed to the view
                            $message->setBody(array(
                                'site_name' => Yii::app()->fbvStorage->get("settings.app_name"),
                                'user' => $model,
                                'activation_url' => $activation_url
                            ), 'text/html');
                            $message->addTo($model->email);
                            $message->from = Yii::app()->fbvStorage->get("settings.app_email");
                            Yii::app()->mail->send($message);
                        }
                        if ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) && Yii::app()->controller->module->autoLogin) {
                            $data = array();
                            $data['status'] = "error";
                            $data['errors'] = 'account error';
                            $this->sendResponse($data, 403);
                        } else {
                            if (!Yii::app()->controller->module->activeAfterRegister && !Yii::app()->controller->module->sendActivationMail) {
                                $message = UserModule::t("Thank you for your registration. Contact Admin to activate your account.");
                            } elseif (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false) {
                                $message = UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}' => CHtml::link(UserModule::t('Login'), Yii::app()->controller->module->loginUrl)));
                            } elseif (Yii::app()->controller->module->loginNotActiv) {
                                $message = UserModule::t("Thank you for your registration. Please check your email or login.");
                            } else {
                                $message = UserModule::t("Thank you for your registration. Please check your email.");
                            }
                            $data = array();
                            $data['status'] = "ok";
                            $data['message'] = $message;
                            $this->sendResponse($data);
                            Yii::app()->end();
                        }
                    }
                } else
                    $profile->validate();
            }
            $data = array();
            $data['status'] = "error";
            $data['errors'] = $model->getErrors();
            $this->sendResponse($data, 403);
        }
    }
}