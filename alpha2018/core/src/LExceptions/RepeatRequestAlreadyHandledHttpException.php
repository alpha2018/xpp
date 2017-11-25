<?php namespace Core\Exceptions;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/3/17
 * Time: 上午10:39
 *
 */
class RepeatRequestAlreadyHandledHttpException extends \Exception
{
    protected $code = 455;
}