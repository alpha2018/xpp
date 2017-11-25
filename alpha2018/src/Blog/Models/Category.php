<?php namespace Blog\Models;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/4/17
 * Time: 上午10:34
 */
class Category extends BlogModel
{
    protected $table = 'blog_categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'name', 'path', 'description'
    ];
    /**
     * Get the articles for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::Class);
    }
}