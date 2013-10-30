<?php
/**
 * This class holds serveral static helper methods facilitating tasks throughout MG
 *
 * @author Vincent Van Uffelen <novazembla@gmail.com>
 * @link http://tiltfactor.org
 * @license AGPL 3.0
 * @package MG
 */


class MGHelper
{

    /**
     * This methods stores and returns lists of strings in
     * associates arrays used in drop down/select boxes and/or radio lists.
     *
     * @param string $type The name of the list to retrieve
     * @param string $code One value of the list identified by $type
     * @return mixed list of values in associative array or single value
     */
    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'active' => array(
                0 => Yii::t('app', 'Not active'),
                1 => Yii::t('app', 'Active'),
            ),
            'locked' => array(
                0 => Yii::t('app', 'Item not locked'),
                1 => Yii::t('app', 'Item locked'),
            ),
            'yes-no' => array(
                0 => Yii::t('app', 'No'),
                1 => Yii::t('app', 'Yes'),
            ),
            'or-and' => array(
                'OR' => Yii::t('app', 'OR'),
                'AND' => Yii::t('app', 'AND'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : array();
        else
            return isset($_items[$type]) ? $_items[$type] : array();
    }

    /**
     * This method attempts to read the front end theme setting from fbvSettings and
     * sets this as current theme. It is mainly used in controller showing arcade pages
     */
    public static function setFrontendTheme()
    {
        $theme = Yii::app()->fbvStorage->get("frontend_theme", "");
        if ($theme != "")
            Yii::app()->setTheme($theme);

    }

    public static function getScaledMediaUrl($name, $width, $height, $institutionToken, $institutionUrl)
    {
        $token = md5($institutionToken . "_" . $width . "_" . $height . "_" . $name);
        return rtrim($institutionUrl, "/") . "/index.php/image/scale/token/" . $token . "/name/" . urlencode($name) . "/width/" . $width . "/height/" . $height . "/";
    }

    public static function getMediaThumb($url, $mimeType, $mediaName)
    {
        $mediaType = substr($mimeType, 0, 5);
        $path = $path = rtrim($url, "/") . UPLOAD_PATH;
        $thumb = "";
        if ($mediaType === "image") {
            $thumb = $path . "/thumbs/" . $mediaName;
        } else if ($mediaType === "video") {
            $thumb = $path . "/videos/" . urlencode(substr($mediaName, 0, -4) . "jpeg");
        } else if ($mediaType === "audio") {
            $thumb = Yii::app()->getBaseUrl(true) . "/images/audio_ico.png";
        }
        return $thumb;
    }

    /**
     * This is the shortcut to Yii::app()->request->baseUrl
     * If the parameter is given, it will be returned and prefixed with the app baseUrl.
     *
     * @param $url if set the url to append
     * @return string The url
     */
    public static function bu($url = null)
    {
        static $baseUrl;
        if ($baseUrl === null)
            $baseUrl = Yii::app()->getRequest()->getBaseUrl();
        return $url === null ? $baseUrl : $baseUrl . '/' . ltrim($url, '/');
    }

    /**
     * Parses all HTTP_X_... request header values and stores it in an static array.
     * If an header is specified it's value or null will be returned
     *
     * @param mixed $header The header which value should be retrieved. Omit the leading HTTP_X_
     * @return mixed array (all HTTP_X_ headers) or null
     */
    public static function HTTPXHeader($header = "")
    {
        static $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 7) <> 'HTTP_X_') {
                continue;
            }
            $h = str_replace(' ', '-', substr($key, 7));
            $headers[$h] = $value;
        }
        $header = str_replace("HTTP_X_", "", $header);

        if (array_key_exists($header, $headers)) {
            return $headers[$header];
        } else {
            return null;
        }
        return $headers;
    }


    /**
     * Creates a shared secret used in the MG_API and a new entry in the session table.
     *
     * @param int $user_id The id of the user in the user table
     * @param sting $user_name The name of the user
     * @param boolean $refresh If true a the system makes sure that a new session will be created for the user. Defaults to false.
     */
    public static function createSharedSecretAndSession($user_id, $user_name, $refresh = false)
    {
        $api_id = Yii::app()->fbvStorage->get("api_id", "MG_API");
        if (!isset(Yii::app()->session[$api_id . '_SHARED_SECRET'])) {
            Yii::app()->session[$api_id . '_SHARED_SECRET'] = uniqid($api_id) . substr(Yii::app()->session->sessionID, 0, 5);
        } else {
            $session = Session::model()->find('shared_secret=:sharedSecret', array(':sharedSecret' => Yii::app()->session[$api_id . '_SHARED_SECRET']));
            if ($session) {
                $session->username = $user_name;
                $session->user_id = $user_id;

                if ($session->validate()) {
                    $session->update();
                } else {
                    throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
                }
                $refresh = false;
            }
        }

        if(isset(Yii::app()->session[$api_id . '_SESSION_ID'])){
            $sess = Session::model()->findByPk((int)Yii::app()->session[$api_id . '_SESSION_ID']);
            if($sess == null) $refresh=true;
        }

        if (!isset(Yii::app()->session[$api_id . '_SESSION_ID']) || $refresh) {
            $session = new Session;
            $session->username = $user_name;
            $session->ip_address = ip2long(self::getUserHostAddress());

            // Some local dev machines aren't returning a proper IP address
            // here (e.g. Sukie running mg under MAMP), so as a quick
            // workaround we'll just provide a placeholder to allow
            // development.
            //
            // TODO: Determine if there is a better fix.
            // TODO: Check if the new function self::getUserHostAddress() provides enough information and remove the next lines
            if (empty($session->ip_address)) {
                // The code expects the IP address to be stored as a 'long'
                // (not a set of dotted octets) in the session array (see
                // above).
                $session->ip_address = "123123123123";
            }

            $session->php_sid = Yii::app()->session->sessionID;
            $session->shared_secret = Yii::app()->session[$api_id . '_SHARED_SECRET'];
            if ($user_id) {
                $session->user_id = $user_id;
            }
            $session->created = date('Y-m-d H:i:s');
            $session->modified = date('Y-m-d H:i:s');

            if ($session->validate()) {
                $session->save();
            } else {
                throw new CHttpException(500, Yii::t('app', 'Internal Server Error.'));
            }

            Yii::app()->session[$api_id . '_SESSION_ID'] = $session->id;
        }
        return Yii::app()->session[$api_id . '_SHARED_SECRET'];
    }

    /**
     * Creates an entry in the log table
     *
     * @param string $category The category of the action to be logged (create, update, delte, batch_*)
     * @param string $message The information to be logged
     * @param int $user_id The id of the user. If $user_id is null this method will try to set the current user's id
     */
    public static function log($category, $message, $user_id = null)
    {
        if (is_null($user_id))
            $user_id = Yii::app()->user->id;

        $sql = " INSERT INTO {{log}}
           (category, message, user_id, created) VALUES
           (:category, :message, :userID, :created)";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':category', $category);
        $command->bindValue(':message', $message);
        $command->bindValue(':created', date('Y-m-d H:i:s'));
        $command->bindValue(':userID', $user_id);
        $command->execute();
    }

    /**
     * Get the users IP address.
     *
     * Thanks: Gustavo @ http://www.yiiframework.com/forum/index.php?/topic/13331-improved-request-getuserhost-getuserhostaddress/
     *
     * @return string the IP addess of the user
     */
    public static function getUserHostAddress()
    {
        switch (true) {
            case isset($_SERVER["HTTP_X_FORWARDED_FOR"]):
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                break;
            case isset($_SERVER["HTTP_CLIENT_IP"]):
                $ip = $_SERVER["HTTP_CLIENT_IP"];
                break;
            default:
                $ip = $_SERVER["REMOTE_ADDR"] ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1';
        }
        if (strpos($ip, ', ') > 0) {
            $ips = explode(', ', $ip);
            $ip = $ips[0];
        }
        return $ip;
    }

    /**
     * removes a folder and its content recurseivly
     *
     * thanks holger1 at NOSPAMzentralplan dot de http://www.php.net/manual/en/function.rmdir.php#98622
     *
     * @param string $dir the folder that should be removed
     */
    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            foreach (scandir($dir) as $object) {
                if ($object != "." && $object != "..") {
                    $filePath = $dir . "/" . $object;
                    if (filetype($filePath) == "dir") {
                        self::rrmdir($filePath);
                    } else {
                        unlink($filePath);
                    }
                }
            }
            try {
                @rmdir(str_replace('\\', '/', $dir));
            } catch (Exception $e) {
            }
        }
    }

    public static function SocialLogin($provider, $backUrl)
    {
        if (empty($provider)) {

            $lastVisitedUrl = Yii::app()->request->urlReferrer; // last visited url
            header("Location: $lastVisitedUrl");
            return;
        }
        try {
            Yii::import('application.components.HybridAuthIdentity');
            Yii::import('application.modules.user.components.UserIdentity');
            $haComp = new HybridAuthIdentity();

            if (!$haComp->validateProviderName($provider)) {
                throw new CHttpException ('500', 'Invalid Action. Please try again.');
            }


            $haComp->adapter = $haComp->hybridAuth->authenticate($provider);


            $haComp->userProfile = $haComp->adapter->getUserProfile();


            $haComp->processLogin($haComp);

            header("Location: {$backUrl}");
            return;

            // [$haComp->processLogin] further action based on successful login or re-direct user to the required url [won`t redirect in this method]
        } catch (Exception $e) {
            $lastVisitedUrl = Yii::app()->request->urlReferrer; // last visited url
            header("Location: $lastVisitedUrl");
            return;
        }
    }

    /**
     * @param integer $mediaId
     * @return bool
     * @throws CHttpException
     */
    public static function canUseMediaFromIP($mediaId)
    {
        /**
         * @var Media $media
         */
        $media = Media::model()->with('collections', 'institution')->findByPk($mediaId);
        $canUse = true;
        $user_ip = MGHelper::getUserHostAddress();
        if ($user_ip) {
            /**
             * @var Collection[] $collections
             */
            $collections = $media->collections;
            if ($collections) {
                foreach ($collections as $col) {
                    if ($col->ip_restrict == 1) {
                        $canUse = false;
                        /**
                         * @var Institution $institution
                         */
                        $institution = $media->institution;
                        $ips = explode(',', preg_replace('/\s+/', '', $institution->ip));
                        if ($ips) {
                            $c = count($ips);
                            for ($i = 0; $i < $c; $i++) {
                                $regularExp = '/^' . str_replace("*", ".*", str_replace(".", "\\.", $ips[$i])) . '$/';
                                if (preg_match($regularExp, $user_ip)) {
                                    $canUse = true;
                                    break;
                                }
                            }
                        }
                        break;
                    }
                }
            }
        }
        return $canUse;
    }
}
