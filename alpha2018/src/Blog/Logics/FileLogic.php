<?php namespace Api\Logics;
use Api\Models\Component\File;
use Api\Repositories\FileRepository;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 17/2/6
 * Time: 上午10:29
 */
class FileLogic
{
    public function saveFile($file)
    {
        $saveFile = app(FileRepository::class)->uploadFile($file);

        if(!$saveFile){
            return logicFalse();
        }

        return logicTrue($saveFile);
    }

    public function findImage($id, $method)
    {

    }
}