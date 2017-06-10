<?php namespace Api\Repositories;
use Api\Models\Component\File;
use Illuminate\Cache\Repository;
use Rinvex\Repository\Repositories\BaseRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 17/2/17
 * Time: 下午7:03
 */
class FileRepository extends Repository
{
    public function model()
    {
        return File::class;
    }

    public function uploadFile($file)
    {
        $binary = file_get_contents($file->getRealPath());

        $clientOriginalName = $file->getClientOriginalName();
        $clientOriginalExtension = $file->getClientOriginalExtension();
        $clientOriginalMimeType = $file->getClientMimeType();
        $clientSize = $file->getClientSize();

        $filename = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $extension = $file->getExtension();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        list($mimePrefix,$mimePostfix) = explode('/', $mimeType);

        $fileModel = new File();
        $fileModel->client_original_name = $clientOriginalName;
        $fileModel->client_original_extension = $clientOriginalExtension;
        $fileModel->client_original_mime_type = $clientOriginalMimeType;
        $fileModel->client_size = $clientSize;

        $fileModel->binary_long_blob = $binary;
        $fileModel->filename = $filename;
        $fileModel->extension = $extension;
        $fileModel->mime_type = $mimeType;
        $fileModel->size = $size;

        $fileModel->mime_prefix = $mimePrefix;
        $fileModel->mime_postfix = $mimePostfix;
        $fileModel->save();
        return $fileModel->id;
    }
}