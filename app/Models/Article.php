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

    public function scopeOfNotDeleted($query, $is = true)
    {
        if($is){
            return $query->whereNull('deleted_at');
        }else{
            return $query->whereNotNull('deleted_at');
        }
    }

    protected $publicAttr = '<i style="margin-left: 0.5em;border:1px solid rgba(158,217,157,1);font-size: 12px;color: rgba(158,217,157,1)">发布</i>';
    protected $privateAttr = '<i style="margin-left: 0.5em;border:1px solid rgba(236,139,137,1);font-size: 12px;color: rgba(236,139,137,1)">私密</i>';
    protected $stickAttr = '<i style="margin-left: 0.5em;border:1px solid rgba(236,139,137,1);font-size: 12px;color: rgba(236,139,137,1)">置顶</i>';

    public function getStatusTitleAttribute()
    {
        $status = $this->status;
        if($status == 1){
            $value = $this->title.$this->publicAttr;
        }else{
            $value = $this->title.$this->privateAttr;
        }

        return $value;
    }

    public function getStickTitleAttribute()
    {
        $stick = $this->stick;
        $value = $this->title;
        if(!empty($stick)){
            $value = $this->title.$this->stickAttr;
        }

        return $value;
    }
}
