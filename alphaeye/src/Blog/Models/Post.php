<?php namespace Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Blog\Models\BlogModel;

/**
 * 文章
 * @author computer
 *
 */
class Post extends BlogModel
{
    /**
     * The database table used by the model .
     *
     * @var string
     */
    protected $table = 'blog_posts';
    
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
        'title',
        'deleted_at'
    ];
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['*'];
}
