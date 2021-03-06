<?php namespace App\Http\Controllers\Xpp;
use AlphaCore\Utils\AuthUtils;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Praise;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/7/1
 * Time: 下午3:07
 */
class PeopleArticleController extends Controller
{
    protected $article;
    /**
     * 文章类型ID
     * @var int
     */
    protected $articleTypeId = 1;

    public function __construct(Article $article)
    {
        $this->article = $article->ofType($this->articleTypeId)->ofNotDeleted();
//        $this->middleware('auth', ['except'=>['show']]);
    }

    public function index()
    {
        //
        $userId = AuthUtils::user()->id;
        $articles = $this->article
            ->ofPeople($userId)
            ->orderBy('stick', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20, [
                'id', 'article_type_id', 'description', 'class_date', 'images',
                'stick', 'title', 'view_count', 'status'
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
            $article->thumb = $thumb;
            $articleId = $article->id;
            $article->title = $article->StatusTitle;

            $article->a_href = '/static/people/article.html?article_id=' . $articleId;
        }
        return $articles;
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
        $article = $this->article->where('id', '=', $id)->first();
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
        $article->title = $article->statusTitle;
        $images = $article->images;
        $imageArr = array_values(array_filter(explode(',', $images)));
        $imageList = array_map(function ($v) {
            $v = '/article/image/' . $v . '/690';
            return $v;
        }, $imageArr);
        $article->image_list = $imageList;
        return response()->json(['success' => true, 'result' => $article]);
    }

    public function destroy($id)
    {
        //
        $article = $this->article->where('id', '=', $id)->first();
        if (empty($article)) {
            return response('404 Not Found', 404);
        }
        if ($article->user_id != AuthUtils::user()->id){
            return response()->json(['success'=>false, 'msg'=>'无权限操作']);
        }
        $article->deleted_at = time();
        $article->save();

        return response()->json(['success'=>true, 'result'=>$article->id]);
    }

    public function postSetPublic($id)
    {
        $article = $this->article->where('id', '=', $id)->first();
        if (empty($article)) {
            return response('404 Not Found', 404);
        }
        if ($article->user_id != AuthUtils::user()->id){
            return response()->json(['success'=>false, 'msg'=>'无权限操作']);
        }
        $article->status = 1;
        $article->save();
        return response()->json(['success'=>true, 'result'=>$article->id]);
    }

    public function postSetPrivate($id)
    {
        $article = $this->article->where('id', '=', $id)->first();
        if (empty($article)) {
            return response('404 Not Found', 404);
        }
        if ($article->user_id != AuthUtils::user()->id){
            return response()->json(['success'=>false, 'msg'=>'无权限操作']);
        }
        $article->status = 0;
        $article->save();

        return response()->json(['success'=>true, 'result'=>$article->id]);
    }

    public function postPraise($id)
    {
        $article = $this->article->where('id', '=', $id)->first();
        if (empty($article)) {
            return response('404 Not Found', 404);
        }

        $praise = app(Praise::class)->where('article_id', '=', $id);
        try{
            $user = AuthUtils::user();
        }catch (\Exception $e){

        }


        if(!empty($user)){
            $userId = $user->id;
            $praise = $praise->where('user_id', '=', $userId);
            $unique = '';
        }else{
            $userId = 0;
            $unique = md5(request()->getClientIp().request()->header('user-agent'));
            $praise = $praise->where('unique', '=', $unique);
        }
        $praise = $praise->first();
        $praiseId = 0;
        if(empty($praise)){
            $praise = app(Praise::class);
            $praise->article_id = $id;
            $praise->user_id = $userId;
            $praise->unique = $unique;
            $praise->save();
            $praiseId = $praise->id;
        }

        return response()->json(['success'=>true, 'result'=>$praiseId]);
    }

    public function postCollection($id)
    {

    }
}