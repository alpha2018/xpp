<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    /**
     * 获取指定navbar的所有文章
     */
    public function posts()
    {
        return $this->belongsToMany('Modules\Blog\Model\post', 'blog_post_navbar_pivot','navbar_id','post_id');
    }
    
    /**
     * 获取指定navbar的所有id
     */
    public function postsId()
    {
        return $this->belongsToMany('Modules\Blog\Model\post', 'blog_post_navbar_pivot','navbar_id','post_id')->withPivot('post_id');
    }

    /**
     * The database table used by the model .
     *
     * @var string
     */
    protected $table = 'blog_navbars';

    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'navbar',
        'title',
        'deleted_at'
    ];
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['*'];
    //
}
