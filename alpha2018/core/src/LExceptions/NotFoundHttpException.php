<?php namespace Core\Exceptions;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/4/12
 * Time: 下午7:58
 */
class NotFoundHttpException extends \Exception
{
    protected $code = 404;
}