<?php namespace App\Http\Controllers\Xpp;

use AlphaCore\Utils\AuthUtils;
use App\Models\Article;
use App\Models\File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    protected $article;
    /**
     * 文章类型ID
     * @var int
     */
    protected $articleTypeId = 1;

    public function __construct(Article $article)
    {
        $this->article = $article->ofType($this->articleTypeId);
        $this->middleware('auth', ['except'=>['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = $this->article->ofStatus()
            ->orderBy('stick', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20, [
                'id', 'article_type_id', 'description', 'class_date', 'images',
                'stick', 'title', 'view_count'
            ]);

        foreach ($articles as $article) {
            $images = $article->images;
            $imageArr = explode(',', $images);
            $imageArr = array_values(array_filter($imageArr));
            if (count($imageArr) > 0) {
                $thumb = '/article/image/preview/' . $imageArr['0'];
            } else {
                $thumb = '/static/images/pic_160.png';
            }
            $article->title = $article->stickTitle;
            $article->thumb = $thumb;
            $articleId = $article->id;
            $article->a_href = '/static/article.html?article_id=' . $articleId;
        }
        return $articles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = AuthUtils::user()->uid;
        $status = $request->input('status', 0);
        if ($status == 'on' || $status == 'On') {
            $status = 1;
        }
        $title = $request->input('title');
        $description = $request->input('description');
        $images = trim($request->input('images'), ',');
        $categoryId = $request->input('category_id');
        $classDate = $request->input('class_date');

        $article = $this->article->where('images', '=', $images)
            ->first();

        if (!empty($article)) {
            return response(['success' => false, 'msg' => '重复提交', 'status' => 500]);
        }
        try {
            $article = new Article();
            $article->user_id = $userId;
            $article->title = $title;
            $article->slug = md5($images . $title . $description . $this->articleTypeId);
            $article->description = $description;
            $article->status = $status;
            $article->category_id = $categoryId;
            $article->images = $images;
            $article->article_type_id = $this->articleTypeId;
            $article->class_date = $classDate;
            $article->save();
        } catch (QueryException $e) {
            return response(['success' => false, 'msg' => '重复提交', 'status' => 500]);
        }

        return response(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $article = $this->article->ofStatus()->where('id', '=', $id)->first();
        if (empty($article)) {
            return response('404 Not Found', 404);
        }
        $catId = $article->category_id;
        if ($catId == 1) {
            $article->category_name = '国画';
        } elseif ($catId == 2) {
            $article->category_name = '儿童画';
        } else {
            $article->category_name = '无';
        }
        $images = $article->images;
        $article->title = $article->stickTitle;
        $imageArr = array_values(array_filter(explode(',', $images)));
        $imageList = array_map(function ($v) {
            $v = '/article/image/' . $v . '/690';
            return $v;
        }, $imageArr);
        $article->image_list = $imageList;
        return response()->json(['success' => true, 'result' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
