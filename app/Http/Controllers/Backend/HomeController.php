<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Libs\Management\HelperManagement;

class HomeController extends Controller
{ 
    
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function getIndex()
    {
        $cookie = [
            'name'=>'auth',
            'value'=>"23123:123123",
            'minutes'=>60,
            'path'=>'',
            'domain'=>'',
            'secure'=>'',
            'httpOnly'=>''
        ];
        return response()->view('backend.home.index')->withCookie($cookie['name'], $cookie['value'], $cookie['minutes'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httpOnly']);
         
    }
    
    
}