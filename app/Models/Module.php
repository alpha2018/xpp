<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
     
    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    protected $dateFormat = 'U';
    
    /**
     * The database table used by the model .
     *
     * @var string
     */
    protected $table = 'modules';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    
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
        'name',
        'display_name',
        'description',
        'sort',
        'is_active',
        'created_id',
        'created_name',
        'update_id',
        'update_name',
        'fathers_link',
        'parent_id',
        'type',
        'uri',
        'is_sidebar'
    ];
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['*'];
}