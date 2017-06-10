<?php namespace App\Models\Note;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16/12/12
 * Time: 下午5:14
 */

class Folder extends BaseModel
{
    public $table = 'note_Folder';

    public $cacheKey = 'folders';

    public $cacheLife = 7*24*60;

    public $tags = ['folders'];
}