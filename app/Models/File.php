<?php namespace App\Models;

class File extends BaseModel
{
    protected $table = 'blog_files';
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
