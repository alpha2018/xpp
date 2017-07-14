<?php namespace App\Http\Controllers\Auth;
use AlphaEyeCore\Utils\AuthUtils;
use AlphaEyeRsa\Rsa\Rsa;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/6/11
 * Time: 18:39
 */
class LoginController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function postLogin(Request $request)
    {
        return $this->login($request);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = (string)$request->input('password');

        $password = app(Rsa::class)->decodePublicKeyEncode($password);

//        $newUser = new User();
//        $newUser->name = 'admin';
//        $newUser->password = Hash::make('admin');
//        $newUser->email = 'davinciandalien@aliyun.com';
//        $newUser->save();

        $user = $this->user->where('name', '=', $username)->first();
        if(empty($user)){
            return response()->json(['success'=>false, 'result'=>null, 'msg'=>'账号或密码错误']);
        }
        if(!Hash::check($password, $user->password)){
            return response()->json(['success'=>false, 'result'=>null, 'msg'=>'账号或密码错误']);
        }

        $token = app(AuthUtils::class)->setToken($user, $request);

        session()->put('token', $token);

//        dd(session()->get('token'));

        $result = ['user'=>[
            'avatar' => $user->avatar,
            'nickname' => $user->nickname,

        ], 'token'=>$token];

        return response()->json(['success'=>true, 'result'=>$result, 'msg'=>'登陆成功']);
    }

    public function postCheckToken(Request $request)
    {
        $token = $request->cookie('jwt-token') ?  : $request->input('token');

        $result = app(AuthUtils::class)->check($token);

        if(!$result){
            return response()->json(['success'=>false]);
        }
        return response()->json(['success'=>true]);
    }
}