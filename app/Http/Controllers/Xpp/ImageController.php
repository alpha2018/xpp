<?php namespace App\Http\Controllers\Xpp;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image as InterventionImage;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/6/13
 * Time: 下午6:29
 */
class ImageController extends Controller
{
    protected $image;
    protected $cache;
    public function __construct(Image $image, CacheManager $cache)
    {
        $this->image = $image;
        if (app()->environment('production')) {
            $this->cache = $cache->store('file');
        } else {
            $this->cache = $cache->store('file');
        }
    }

    public function preview($id)
    {
        return $this->show($id, 120);
    }


    public function show($id, $width)
    {
        $image = $this->image->find($id, ['id']);
        if (empty($image)) {
            return response('404 Not Found', 404);
        }

        if ($width == 0 || $width > 690) {
            $width = 690;
        }

        $cacheKey = __CLASS__ . __METHOD__ . $id. $width;

        $img = $this->cache->rememberForever($cacheKey, function () use ($id, $width) {
            $file = $this->image->find($id, ['id', 'binary_long_blob']);
            $binary = $file->binary_long_blob;
            Log::debug('image_cache');

            $img = InterventionImage::make($binary)->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();});

            return $img->response('jpg');
        });

        return $img;

    }

    public function upload(Request $request)
    {
        $images = $request->input('images');

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $images, $result)) {
            $type = $result[2];
            $rand = rand(1000, 9999);
            $filename = md5(time() . $rand) . '.' . $type;
            $imageBinary = base64_decode(str_replace($result[1], '', $images));

            $image = $this->image;
            $image->binary_long_blob = $imageBinary;
            $image->filename = $filename;
            $image->save();
            return response($image->id);
        }
    }
}