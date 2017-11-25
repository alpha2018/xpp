<?php namespace Core\Exceptions;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/3/17
 * Time: 上午10:39
 *
 * 服务器遇到了一个未曾预料的状况，导致了它无法完成对请求的处理。
 * 一般来说，这个问题都会在服务器端的源代码出现错误时出现。
 */
class InternalServerErrorException extends \Exception
{
    protected $code = 500;
}