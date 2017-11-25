<?php namespace Api\Models\Component;

use Api\Models\BaseModel;

class File extends BaseModel
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
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = True;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable .
     *
     * @var array
     */
    protected $fillable = [
        'binary_long_blob',
        'client_original_name',
        'client_original_extension',
        'mime_type',
        'filename',
        'size',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['*'];
}
