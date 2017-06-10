<?php
namespace Libs\Utils;

/**
 * 
 * @author qin
 *
 */
class ArrayUtils
{
    

    /**
     * 判断参数是否为数组
     * @param mixed $param
     * @return array [$param]
     */
    public static function isArray($param)
    {
        return is_array($param) ? $param : [ $param ];
    }

    /**
     * 对象转数组
     * @param object $obj
     * 
     * @return array []
     */
    public static function obj2Arr($obj)
    {
        return empty($obj) ? [] : $obj->toArray();
    }
}