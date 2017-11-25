<?php namespace App\Models\Common\Traits\Attribute;

/**
 * Class UserAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait CommonAttribute
{
    public function isEnable()
    {
        return is_null($this->disabled_at) ? true : false;
    }

    public function getEnableLabelAttribute()
    {
        if ($this->isEnable())
            return '<label class="label label-success">'.trans('启用').'</label>';
        return "<label class='label label-danger'>".trans('禁用')."</label>";
    }

	/**
	 * @return string
	 */
	public function getShowButtonAttribute()
	{
		return '<a href="' . route($this->pathname.'.show', $this) . '" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.view') . '"></i></a> ';
	}

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route($this->pathname.'.edit', $this) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getEnableButtonAttribute()
    {
        if($this->isEnable()){
            return '<a href="' . route('admin.access.user.mark', [
                $this,
                1
            ]) . '" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.backend.access.users.activate') . '"></i></a> ';
        }
        return '<a href="' . route('admin.access.user.mark', [
        $this,
        0
    ]) . '" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.backend.access.users.deactivate') . '"></i></a> ';
        // No break

    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        if (auth()->user()->getAuthIdentifier()) {
            return '<a href="' . route($this->pathname.'.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="cancel"
                 data-trans-button-confirm="delete"
                 data-trans-title="are_you_sure"
                 class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="delete"></i></a> ';
        }

        return '';
    }

	/**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="' . route($this->pathname.'.restore', $this) . '" name="restore_item" class="btn btn-xs btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.backend.access.users.restore_user') . '"></i></a> ';
    }

	/**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
        return '<a href="' . route($this->pathname.'.delete-permanently', $this) . '" name="delete_user_perm" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.backend.access.users.delete_permanently') . '"></i></a> ';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return $this->getRestoreButtonAttribute() .
                $this->getDeletePermanentlyButtonAttribute();
        }

        return
			$this->getShowButtonAttribute() .
			$this->getEditButtonAttribute() .
            $this->getDeleteButtonAttribute();
    }
}