<?php namespace App\Http\Controllers\Wx;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/7/12
 * Time: 下午7:25
 */
class WechatController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->options = config('wechat');
    }

    public function wx()
    {
        $app = new Application($this->options);

        $response = $app->server->serve();
        return $response;
    }
}