<?php
/**
 * Created by JetBrains PhpStorm.
 * User: delchina
 * Date: 8/19/13
 * Time: 11:45 PM
 * To change this template use File | Settings | File Templates.
 */

class HybridAuthIdentity extends CUserIdentity
{
    const VERSION = '2.1.2';

    /**
     *
     * @var Hybrid_Auth
     */
    public $hybridAuth;

    /**
     *
     * @var Hybrid_Provider_Adapter
     */
    public $adapter;

    /**
     *
     * @var Hybrid_User_Profile
     */
    public $userProfile;

    public $allowedProviders = array('google', 'facebook', 'linkedin', 'yahoo', 'live',);

    protected $config;

    function __construct()
    {
        $path = Yii::getPathOfAlias('ext.HybridAuth');
        require_once $path . '/hybridauth-' . self::VERSION . '/hybridauth/Auth.php';  //path to the Auth php file within HybridAuth folder

        $this->config = array(

            "base_url" => Yii::app()->basePath. "/site/socialLogin", // make it more generic



            "providers" => array(
                "Google" => array(
                    "enabled" => false,
                    "keys" => array(
                        "id" => "google client id",
                        "secret" => "google secret",
                    ),
                    "scope" => "https://www.googleapis.com/auth/userinfo.profile " . "https://www.googleapis.com/auth/userinfo.email",
                    "access_type" => "online",
                ),
                "Facebook" => array (
                    "enabled" => true,
                    "display" => "popup",
                    "keys" => array (
                        "id" => "672156142814370",
                        "secret" => "3fb442fe62ff22f00c7a60b81c00f305",
                    ),
                    "scope" => "email"
                ),
                "Live" => array (
                    "enabled" => false,
                    "keys" => array (
                        "id" => "windows client id",
                        "secret" => "Windows Live secret",
                    ),
                    "scope" => "email"
                ),
                "Yahoo" => array(
                    "enabled" => false,
                    "keys" => array (
                        "id" => "your yahoo application id",    //the additional parameter
                        "key" => "yahoo client id",
                        "secret" => "yahoo secret",
                    ),
                ),
                "LinkedIn" => array(
                    "enabled" => false,
                    "keys" => array (
                        "key" => "linkedin client id",
                        "secret" => "linkedin secret",
                    ),
                ),
            ),

            "debug_mode" => false,

            // to enable logging, set 'debug_mode' to true, then provide here a path of a writable file
            "debug_file" => "",
        );

        $this->hybridAuth = new Hybrid_Auth($this->config);
    }

    /**
     *
     * @param string $provider
     * @return bool
     */
    public function validateProviderName($provider)
    {
        if (!is_string($provider))
            return false;
        if (!in_array($provider, $this->allowedProviders))
            return false;

        return true;
    }

    public function processLogin($haComp)
    {

        $accessToken = $haComp->adapter->getAccessToken();
        $userProfile = (array)$haComp->userProfile;
        $email = $userProfile['email'];

     //   $user = new User;
        $facebook_user = new FacebookUser;

        $facebook_user->username = $email;
        $facebook_user->password = Yii::app()->getModule('user')->encrypting("dummy_value");

        $facebook_user->email = $email;
        $facebook_user->activekey = "dummy_value";
        $facebook_user->status = 1;
        $facebook_user->open_id = $accessToken['access_token'];
        $res = $facebook_user->save();

        if($facebook_user->errors == null) $user_id = $facebook_user->id;
        else
        {
            // in case we`ve already written the user in the users table
            $sql = "SELECT id FROM user WHERE username = \"{$email}\" LIMIT 1" ;
            $command=Yii::app()->db->createCommand($sql);
            // [TODO] update the token
            $results=$command->queryAll();
            $user_id = $results[0]['id'];
        }


//        MGHelper::createSharedSecretAndSession($user_id, $email, true);

        $identity=new UserIdentity($facebook_user->username,"dummy_value");
        //      $identity=new UserIdentity("admin","admin");

        $identity->authenticate();

        $duration=60;  // 60 sec

       Yii::app()->user->login($identity,$duration);  // will create the session*/


    }

}