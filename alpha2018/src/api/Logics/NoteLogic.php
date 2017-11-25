<?php namespace Api\Logics;
use Api\Models\Note\Folder;
use Illuminate\Support\Facades\Cache;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 17/1/18
 * Time: 下午2:38
 */
class NoteLogic
{
    protected $folder;

    public function __construct(Folder $folder)
    {
        $this->folder = $folder;
    }

    public function getFolders()
    {
        if(!Cache::has('folders')){
            $folders = $this->folder->all();

            Cache::put($this->folder->cacheKey, $folders, $this->folder->cacheLife);
        }

        $folders = Cache::get($this->folder->cacheKey);

        return $folders;
    }
}