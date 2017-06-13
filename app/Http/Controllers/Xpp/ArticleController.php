<?php namespace App\Http\Controllers\Xpp;

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
    public $article;
    protected $cache;
    /**
     * 文章类型ID
     * @var int
     */
    protected $articleTypeId = 1;

    public function __construct(Article $article, CacheManager $cache)
    {
        $this->article = $article->ofType($this->articleTypeId);
        if (app()->environment('production')) {
            $this->cache = $cache->store('file');
        } else {
            $this->cache = $cache->store('redis');
        }
    }

    public function getImage($id, $width)
    {
        $file = File::find($id, ['id']);
        if (empty($file)) {
            return response('404 Not Found', 404);
        }

        $cacheKey = __CLASS__ . __METHOD__ . $id;

        $img = $this->cache->rememberForever($cacheKey, function () use ($id, $width) {
            $file = File::find($id, ['id', 'binary_long_blob']);
            $binary = $file->binary_long_blob;
            Log::debug('image_cache');
            $img = Image::make($binary);
            if ($width == 0 || $width > 690) {
                $width = 690;
            }

            $img = $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            return $img->response('jpg');
        });

        return $img;

    }

    public function getImagePreview($id)
    {
        $file = File::find($id, ['id']);
        if (empty($file)) {
            return response('404 Not Found', 404);
        }

        $cacheKey = __CLASS__ . __METHOD__ . $id;
        $binary = $this->cache->rememberForever($cacheKey, function () use ($id) {
            $file = File::find($id, ['id', 'binary_long_blob']);
            $binary = $file->binary_long_blob;
            Log::debug('image_preview_cache');
            return $binary;
        });

        $img = Image::make($binary);

        $img = $img->resize(120, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $img->response('jpg');

        return $img;
    }

    public function upload(Request $request)
    {
        try {
            $images = $request->input('images');

            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $images, $result)) {
                $type = $result[2];
                $rand = rand(1000, 9999);
                $filename = md5(time() . $rand) . '.' . $type;
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

        } catch (\Exception $e) {
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
        $articles = $this->article->ofStatus()->paginate(20);

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
        $status = $request->input('status', 0);
        if ($status == 'on' || $status == 'On') {
            $status = 1;
        }
        $title = $request->input('title');
        $description = $request->input('description');
        $images = trim($request->input('images'), ',');
        $categoryId = $request->input('category_id');
        $class_date = $request->input('category_id');

        $article = $this->article->where('images', '=', $images)
            ->first();

        if (!empty($article)) {
            return response(['success' => false, 'msg' => '重复提交', 'status' => 500]);
        }
        try {
            $article = new Article();
            $article->title = $title;
            $article->slug = md5($images . $title . $description . $this->articleTypeId);
            $article->description = $description;
            $article->status = $status;
            $article->category_id = $categoryId;
            $article->images = $images;
            $article->article_type_id = $this->articleTypeId;
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
