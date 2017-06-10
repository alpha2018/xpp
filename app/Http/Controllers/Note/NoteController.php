<?php namespace App\Http\Controllers\Note;
use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\Note\Folder;
use Illuminate\Support\Facades\Cache;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16/12/9
 * Time: 下午6:36
 */

class NoteController extends Controller
{
    protected $folder;

    public function __construct(Folder $folder)
    {
        $this->folder = $folder;
    }

    public function index()
    {
        return view('note.index');
    }

    public function show()
    {
        return view('note.index');
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