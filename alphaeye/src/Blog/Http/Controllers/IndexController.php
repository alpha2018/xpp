<?php
namespace Modules\Blog\Controllers;
use App\Http\Controllers\Controller;
use Libs\Management\HelperManagement;
use Modules\Blog\Models\Navbar;
use Libs\Utils\ArrayUtil;
use Modules\Blog\Models\Post;
use DB;

class IndexController extends Controller
{ 
    public function __construct()
    {
        
    }
    
    public function Index()
    {
        request()->session()->flash('cNavbar', '');
        $posts = Post::orderBy('created_at', 'desc')->paginate(1);
        return HelperManagement::_view('blog.blog.lists', compact('posts'));
    }
    
    public function Navbar($nav = null)
    {
        //request()->session()->put('cNavbar', $nav);
        request()->session()->flash('cNavbar', $nav);
        //request()->session()->get('cNavbar');
        try {
            $navbar = DB::select('SELECT id FROM blog_navbars WHERE navbar = :nav ',[ 'nav'=>$nav ]);
            $navbar_post_ids = DB::select('SELECT post_id FROM blog_post_navbar_pivot WHERE navbar_id = :navbar_id',['navbar_id'=>$navbar[0]->id]);       
            $posts_ids = [];
            foreach($navbar_post_ids as $v){
                $posts_ids[] = $v->post_id;
            }
            $posts = Post::whereIn('id',$posts_ids)->orderBy('created_at', 'desc')->paginate(1);
        } catch (\Exception $e) {
            $posts = [];
        }
        return HelperManagement::_view('blog.blog.lists', compact('posts'));
    }
    
    public function showPost($slug)
    {
        return $slug;
    }
    
    public function showAbout()
    {
        return 'about';
    }
    
}