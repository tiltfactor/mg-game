<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
    private $_id;
    CONST ERROR_EMAIL_INVALID = 3;
    CONST ERROR_STATUS_NOTACTIVE = 4;
    CONST ERROR_STATUS_BAN = 5;
    CONST ERROR_STATUS_BLOCKED = 6;
    CONST ERROR_FACEBOOK = 7;
    public $open_id;
    public $facebookProfile;
    function __construct($username, $password, $openId = null, $facebookProfile = null) {
        $this->open_id = $openId;
        $this->facebookProfile = $facebookProfile;
        parent::__construct($username, $password);
    }

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        if (strpos($this->username, "@")) {
            $user = User::model()->notsafe()->findByAttributes(array('email' => $this->username));
        } else {
            $user = User::model()->notsafe()->findByAttributes(array('username' => $this->username));
        }
        if ($user === null) {
            if (strpos($this->username, "@")) {
                if ($this->password == 'dummy_value' && $this->open_id && $this->facebookProfile) {
                    $user = new User();
                    $user->email = $this->username;
                    $user->open_id = $this->facebookProfile['identifier'];
                    $user->password = $this->password;
                    $user->role = PLAYER;
                    $username = $this->facebookProfile['profileURL'];
                    $user->username = substr($username, strrpos($username, '/') + 1);
                    $user->status = 1;
                    $user->insert();
                    $this->setLogged($user);
                    $this->errorCode = self::ERROR_NONE;
                } else {
                    $this->errorCode = self::ERROR_EMAIL_INVALID;
                }
            } else {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
        } else if ($this->password == 'dummy_value' && $this->open_id) {
            if ($user->open_id == $this->facebookProfile['identifier'] && $user->email == $this->username) {
                YiiBase::log('mail and openid are matching');
                $this->setLogged($user);
                $this->errorCode = self::ERROR_NONE;
            } else {
                $this->errorCode = self::ERROR_EMAIL_INVALID;
            }

        }
        else if (Yii::app()->getModule('user')->encrypting($this->password) !== $user->password && $this->password != 'dummy_value')
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else if ($user->status == 0 && Yii::app()->getModule('user')->loginNotActiv == false)
            $this->errorCode = self::ERROR_STATUS_NOTACTIVE;
        else if ($user->status == -1)
            $this->errorCode = self::ERROR_STATUS_BAN;
        else {
            $this->setLogged($user);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    private function  setLogged($user) {
        $this->_id = $user->id;
        $this->username = $user->username;
        // assign roles
        $auth = Yii::app()->authManager;
        if (!$auth->isAssigned($user->role, $this->_id)) {
            if ($auth->assign($user->role, $this->_id)) {
                Yii::app()->authManager->save();
            }
        }
        MGHelper::createSharedSecretAndSession($this->_id, $user->username, true);
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }
}