<?php namespace App\Models;

class Article extends BaseModel
{
    //
    protected $table = 'blog_articles';

    public function scopeOfType($query, $article_type_id)
    {
        return $query->where('article_type_id', '=', $article_type_id);
    }
}
