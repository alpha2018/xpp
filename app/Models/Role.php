<?php namespace App\Models;

use App\Models\Common\Traits\Attribute\CommonAttribute;
use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole
{  
    use SoftDeletes;
    use CommonAttribute;

    protected $pathname = 'role';

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
    protected $table = 'roles';

    public function users(){
        return $this->belongsToMany('Modules\Admin\Models\User','role_user','role_id','user_id');
    }
    public function permissions(){
        return $this->belongsToMany('Modules\Admin\Models\Module','permission_role','role_id','module_id');
    }
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
//     */
//    protected $primaryKey = 'id';
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',


    ];
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['*'];

    /**
     * @param int $status
     * @param bool $trashed
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        /**
         * Note: You must return deleted_at or the User getActionButtonsAttribute won't
         * be able to differentiate what buttons to show for each row.
         */
        $dataTableQuery = $this->query()
            ->select([
                'id',
                'name',
                'display_name',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);

        if ($trashed == "true") {
            return $dataTableQuery->onlyTrashed();
        }

        // active() is a scope on the UserScope trait
        //return $dataTableQuery->active($status);

        return $dataTableQuery;
    }
}