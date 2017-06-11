<?php namespace App\Http\Controllers\Xpp;

use App\Models\Article;
use App\Models\File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    public $article;
    protected $articleTypeId= 1;

    public function __construct(Article $article)
    {
        $this->article = $article->ofType($this->articleTypeId);
    }

    public function getImagePreview($name)
    {
        $file = File::find(46);
        if(!count($file)){
            return response()->json(['success'=>false, 'status_code'=>500]);
        }

        $binary = $file->binary_long_blob;

        $img = Image::make($binary);

        $img = $img->resize(120, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $img->response('jpg');

        $img = Image::make($binary)->resize(300, 200);
        return $img->response('jpg');

        return response($binary)->header('Content-type',$file->mime_type);
    }

    public function upload(Request $request)
    {
        try {
            $images = $request->input('images');

            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $images, $result)){
                $type = $result[2];
                $rand = rand(1000,9999);
                $filename = md5(time().$rand).'.'.$type;
                $imageBinary = base64_decode(str_replace($result[1], '', $images));

                $fileModel = new \App\Models\File();
//        $fileModel->client_original_name = $clientOriginalName;
//        $fileModel->client_original_extension = $clientOriginalExtension;
//        $fileModel->client_original_mime_type = $clientOriginalMimeType;
//        $fileModel->client_size = $clientSize;

                $fileModel->binary_long_blob = $imageBinary;
                $fileModel->filename = $filename;
//        $fileModel->extension = $extension;
//        $fileModel->mime_type = $mimeType;
//        $fileModel->size = $size;
//
//        $fileModel->mime_prefix = $mimePrefix;
//        $fileModel->mime_postfix = $mimePostfix;
                $fileModel->save();
                return response($fileModel->id);

            }

        }catch (\Exception $e){
            print_r($e->getMessage());
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = $this->article->paginate(20);

        foreach ($articles as $article){
            $article->thumb = '/article/image/preview/1';
            $article->a_href = '/static/article.html?article_id='.$article->id.'';
        }
        //return response(1,500);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = $request->input('status', 0);
        if($status == 'on' || $status == 'On'){
            $status = 1;
        }
        $title = $request->input('title');
        $description = $request->input('description');
        $images = trim($request->input('images'), ',');
        $categoryId = $request->input('category_id');

        $article = $this->article->where('images', '=', $images)
            ->first();
        if(!empty($article)){
            return response(['success'=>false, 'msg'=>'重复提交', 'status'=>500]);
        }
        try {
            $article = new Article();
            $article->title = $title;
            $article->slug = md5($images . $title . $description.$this->articleTypeId);
            $article->description = $description;
            $article->status = $status;
            $article->category_id = $categoryId;
            $article->images = $images;
            $article->article_type_id = $this->articleTypeId;
            $article->save();
        }catch (QueryException $e){
            return response(['success'=>false, 'msg'=>'重复提交', 'status'=>500]);
        }

        return response(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return 1;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
