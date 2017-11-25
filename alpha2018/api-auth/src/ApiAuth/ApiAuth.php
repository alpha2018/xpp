<?php namespace AlphaEye\ApiAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/5/20
 * Time: 下午4:40
 */
class ApiAuth
{
    protected $user;
    protected $jwtAuth;

    public function __construct(JWTAuth $JWTAuth)
    {
        $this->jwtAuth = $JWTAuth;
    }

    public function login()
    {

    }

    protected function getToken()
    {
        return $this->jwtAuth->getToken();
    }

    public function user()
    {
        $token = $this->getToken();
        $this->jwtAuth->toUser();
    }

    public function check()
    {

    }
}