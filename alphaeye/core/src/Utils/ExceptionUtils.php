<?php namespace AlphaEyeCore\Utils;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/6/7
 * Time: 下午3:38
 */
class ExceptionUtils
{
    public static $NOT_FOUND_HTTP = 404;
    public static $BAD_REQUEST = 1;
    public static $FORBIDDEN_HTTP = 403;



    public static function renderException($e)
    {
        $className = get_class($e);

    }

    public static function throwNot()
    {

    }
}