<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Libs\Utils\ValidateUtil;
use App\models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            //'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
            //'phone' => '^[1][3578][0-9]{9}$'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            //'phone' => $data['phone'],
        ]);
    }
    
    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }
    
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        return $this->login($request);
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $request->only($this->loginUsername(), 'password');

        if (Auth::attempt($credentials)) {
            // 认证通过...
            //return redirect()->intended($this->redirectPath());
            return redirect()->intended();
        }

        return $this->sendFailedLoginResponse($request);
    }
    
    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
        ->withInput($request->only($this->loginUsername(), 'remember'))
        ->withErrors([
            $this->loginUsername() => $this->getFailedLoginMessage(),
        ]);
    }
    
    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        //return Lang::has('auth.failed')
        //? Lang::get('auth.failed')
        //: '账号或密码错误';
        return '账号或密码错误';
    }
    
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $messages = [
            $this->loginUsername().'.required' => '账号必须',
            'password.required' => '密码必须',
            'captcha.required' => '验证码必须',
            'captcha.captcha' => '验证码错误'
        ];
        
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ], $messages);
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());
    
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
    
        Auth::login($this->create($request->all()));
    
        //return redirect($this->redirectPath());
        return redirect()->intended($this->redirectPath());
    }
    
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        \Session::flush();
        
        Auth::logout();
        
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
    
    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }
    
    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
            );
    }
         
    /**
     * 设置成功登录后跳转的url
     * @param Request $request
     */
    protected function setRedirectPath(Request $request)
    {
        $this->redirectPath = $request->fullUrl();
    }
    
    /**
     * 注册验证邮箱
     * @param Request $request
     */
    public function postValidateEmail(Request $request)
    {
        return response()->json($this->validateEmail($request));
    }
    
    /**
     * 验证邮箱
     * @param Request $request
     */
    protected function validateEmail(Request $request)
    {
        $email = $request->input('email');
        if(!ValidateUtil::isEmail($email)){
            return ['code'=>500, 'msg'=>'邮箱格式不正确'];
        }
        
        $ret = true;        //验证邮箱是否注册
        if(!$ret){
            return ['code'=>500, 'msg'=>'邮箱已经注册'];
        }
        
        return ['code'=>200, 'msg'=>''];
    }
}
