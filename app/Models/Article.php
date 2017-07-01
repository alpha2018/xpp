<?php namespace App\Models;

class Article extends BaseModel
{
    //
    protected $table = 'blog_articles';

    public function scopeOfType($query, $article_type_id)
    {
        return $query->where('article_type_id', '=', $article_type_id);
    }

    public function scopeOfStatus($query, $status = 1)
    {
        return $query->where('status', '=', $status);
    }

    public function scopeOfPeople($query, $user_id = null)
    {
        return $query->where('user_id', '=', $user_id);
    }
}
