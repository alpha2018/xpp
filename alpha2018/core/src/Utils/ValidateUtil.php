<?php namespace Core\Plugins\Utils;
/**
 * 验证类
 * @author qin
 * @data 2016.06.23
 */
class ValidateUtil
{
    /**
     * 是否为空值
     * @param string $str
     * @return boolean
     */
    public static function isEmpty($str)
    {
        $email = trim($str);
        return empty( $email ) ? false : $email;
    }

    /**
     * 邮箱验证
     * @param $email
     * @return bool
     */
    public static function isEmail($email) 
    {
        $email = self::isEmpty($email);
        
        if(!$email){
            return false;
        }
        
        $reg = '/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i';
        
        return preg_match( $reg, $email ) ? true : false;
    }
    
    /**
     * 手机号验证
     * @param  $phone
     * @return boolean
     */
    public static function isPhone($phone)
    {
        $reg = '^[1][3578][0-9]{9}$';
        
        return preg_match( $reg, $phone ) ? true : false;
    }
}