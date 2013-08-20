<?php
/**
 *
 * @package
 * @author     Nikolay Kondikov<nikolay.kondikov@sirma.bg>
 */
class RegisterResult
{
    /**
     * @var string
     * @soap
     */
    public $token="";
    /**
     * @var Status
     * @soap
     */
    public  $status=null;

    /**
     * @static
     * @param StatusCode $code
     * @param string $message
     * @return RegisterResult
     */
    public static function error($code, $message) {
        $res = new RegisterResult();
        $res->status = Status::getStatus($code,$message);
        return res;
    }
}
