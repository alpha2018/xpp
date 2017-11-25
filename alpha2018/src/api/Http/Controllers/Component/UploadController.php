<?php namespace Api\Http\Controllers\Component;
use Api\Http\Controllers\ApiController;
use Api\Logics\FileLogic;
use Api\Models\Component\File;
use Api\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 17/2/5
 * Time: 下午5:25
 */

class UploadController extends ApiController
{
    protected $fileLogic;

    public function __construct(FileLogic $fileLogic)
    {
        $this->fileLogic = $fileLogic;
    }

    public function getImageUpload()
    {
        return view('future.upload.image');
    }

    public function postImageUpload(Request $request)
    {
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }

        if(!$this->fileLogic->saveFile($file)['success']){
            exit('保存文件失败！');
        }

        $file = File::find(1);

        $binary = $file->binary_long_blob;

        return response($binary)->header('Content-type',$file->mime_type);
    }

    public function getFile()
    {
        $file = File::find(1);

        $binary = $file->binary_long_blob;

        $img = Image::make($binary);

        $img = $img->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $img->response('jpg');

        $img = Image::make($binary)->resize(300, 200);
        return $img->response('jpg');

        return response($binary)->header('Content-type',$file->mime_type);
    }

    public function getImagePreview(Request $request)
    {
        $file = File::find(1);
        if(!count($file)){
            return response()->json(['success'=>true, 'status_code'=>500]);
        }

        $binary = $file->binary_long_blob;

        $img = Image::make($binary);

        $img = $img->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $img->response('jpg');

        $img = Image::make($binary)->resize(300, 200);
        return $img->response('jpg');

        return response($binary)->header('Content-type',$file->mime_type);
    }

    public function postFileupload(Request $request){
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $savePath = 'test/'.$newFileName;
        $bytes = Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );
        if(!Storage::exists($savePath)){
            exit('保存文件失败！');
        }
        header("Content-Type: ".Storage::mimeType($savePath));
        echo Storage::get($savePath);
    }
}