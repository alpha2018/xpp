<?php namespace Core\Exceptions;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 17/2/25
 * Time: 下午8:10
 */
class BadRequestHttpException extends \Exception
{
    protected $code = 400;
}