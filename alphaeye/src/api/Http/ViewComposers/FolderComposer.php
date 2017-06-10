<?php

namespace App\Http\ViewComposers;

use Api\Http\Controllers\Note\NoteController;
use Illuminate\Contracts\View\View;

class FolderComposer
{
    /**
     * 用户仓库实现.
     *
     * @var UserRepository
     */
    protected $folder;

    /**
     * 创建一个新的属性composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(NoteController $folder)
    {
        // Dependencies automatically resolved by service container...
        $this->folder = $folder;
    }

    /**
     * 绑定数据到视图.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('folders', $this->folder->getFolders());
    }
}