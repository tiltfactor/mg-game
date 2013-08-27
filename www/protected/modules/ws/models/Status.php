<?php
/**
 *
 * @package
 */
class Status
{
    /**
     * @var string
     * @soap
     */
    public $status = "";
    /**
     * @var StatusCode
     * @soap
     */
    public $statusCode = null;

    /**
     * @static
     * @param StatusCode $code
     * @param String $message
     * @return Status
     */
    public static function getStatus($code, $message)
    {
        $status = new Status();
        $status->status = $message;
        $status->statusCode = $code;
        return $status;
    }
}
