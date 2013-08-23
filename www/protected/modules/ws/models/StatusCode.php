<?php
/**
 *
 * @package
 * @author     Nikolay Kondikov<nikolay.kondikov@sirma.bg>
 */
class StatusCode
{
    /**
     * @var string
     * @soap
     */
    public $_SUCCESS = "SUCCESS";
    /**
     * @var string
     * @soap
     */
    public $_LOGON_ERROR = "LOGON_ERROR";
    /**
     * @var string
     * @soap
     */
    public $_FATAL_ERROR = "FATAL_ERROR";
    /**
     * @var string
     * @soap
     */
    public $_NOT_FOUND = "NOT_FOUND";
    /**
     * @var string
     * @soap
     */
    public $_SUCCESS_WITH_WARNINGS = "SUCCESS_WITH_WARNINGS";
    /**
     * @var string
     * @soap
     */
    public $_DUPLICATE_RECORD = "DUPLICATE_RECORD";
    /**
     * @var string
     * @soap
     */
    public $_CANNOT_DELETE = "CANNOT_DELETE";
    /**
     * @var string
     * @soap
     */
    public $_NO_PERMISSIONS = "NO_PERMISSIONS";
    /**
     * @var string
     * @soap
     */
    public $_ILLEGAL_STATE = "ILLEGAL_STATE";
    /**
     * @var string
     * @soap
     */
    public $_ILLEGAL_ARGUMENT = "ILLEGAL_ARGUMENT";

    /**
     * @var string
     * @soap
     */
    public $name;
    /**
     * @var int
     * @soap
     */
    public $code;

    /**
     * @param string $name
     * @param int $code
     */
    public function __construct($name, $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @static
     * @return StatusCode
     * @soap
     */
    public static function SUCCESS()
    {
        return new StatusCode("SUCCESS", 1);
    }

    /**
     * @static
     * @return StatusCode
     * @soap
     */
    public static function LOGON_ERROR()
    {
        return new StatusCode("LOGON_ERROR", 2);
    }

    /**
     * @static
     * @return StatusCode
     */
    final public static function FATAL_ERROR()
    {
        return new StatusCode("FATAL_ERROR", 3);
    }

    /**
     * @static
     * @return StatusCode
     */
    public static function SUCCESS_WITH_WARNINGS()
    {
        return new StatusCode("SUCCESS_WITH_WARNINGS", 4);
    }

    /**
     * @static
     * @return StatusCode
     */
    public static function DUPLICATE_RECORD()
    {
        return new StatusCode("DUPLICATE_RECORD", 5);
    }

    /**
     * @static
     * @return StatusCode
     */
    public static function CANNOT_DELETE()
    {
        return new StatusCode("CANNOT_DELETE", 6);
    }

    /**
     * @static
     * @return StatusCode
     */
    public static function NO_PERMISSIONS()
    {
        return new StatusCode("NO_PERMISSIONS", 7);
    }

    /**
     * @static
     * @return StatusCode
     */
    public static function ILLEGAL_STATE()
    {
        return new StatusCode("ILLEGAL_STATE", 8);
    }

    /**
     * @static
     * @return StatusCode
     */
    public static function ILLEGAL_ARGUMENT()
    {
        return new StatusCode("ILLEGAL_ARGUMENT", 9);
    }
}
