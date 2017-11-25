<?php namespace Core\Exceptions;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/4/12
 * Time: 下午5:28
 */
class ForbiddenHttpException extends \Exception
{
    protected $code = 403;
}