<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Modules\Site\Controllers\SidebarRepository as SidebarRepository;

class ProfileComposer
{
    /**
     * 用户仓库实现.
     *
     * @var UserRepository
     */
    protected $sidebars;

    /**
     * 创建一个新的属性composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(SidebarRepository $sidebars)
    {
        // Dependencies automatically resolved by service container...
        $this->sidebars = $sidebars;
    }

    /**
     * 绑定数据到视图.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sidebars', $this->sidebars->getSidebar());
    }
}