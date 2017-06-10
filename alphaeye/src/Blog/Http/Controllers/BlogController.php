<?php namespace Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Blog\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class BlogController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth.basic.once');
    }

    public function tryCatch($closure)
    {
        DB::beginTransaction();
        try{
            $c = $closure();
            DB::commit();
            return $c;
        }  catch (\Exception $e){
            //dd($e);
            DB::rollback();
            throw new Exception($e->getMessage(), $e->getCode(), $e->getPrevious());
            dd($e);
        }
    }


    public function index()
    {
//        $a = 3;
//        $ret = $this->tryCatch(function () use ($a){
//            throw new \Exception($a);
//        });
//
//
//dd($ret,2);
        $posts = Post::where('published_at', '<=', Carbon::now())
                ->orderBy('published_at', 'desc')
                ->paginate(1);

       
        return view('blog.lists', compact('posts'));
    }

    public function showPost($slug)
    {
        $post = Post::whereSlug($slug)->firstOrFail();

        return view('blog.post')->withPost($post);
    }
}