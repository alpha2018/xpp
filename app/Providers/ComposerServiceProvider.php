<?php

namespace App\Providers;

use App\Http\Controllers\Note\NoteController;
use App\Models\Note\Folder;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * 在容器中注册绑定.
     *
     * @return void
     * @author http://laravelacademy.org
     */
    public function boot()
    {
        // 使用基于类的composers...
//        view()->composer(
//            'note.index', 'App\Http\ViewComposers\FolderComposer'
//        );

        // 使用基于闭包的composers...
//        view()->composer('note.index', function ($view){
//            $folders = new NoteController(Folder::class);
//            $view->with('folders',$folders->getFolders());
//        });
    }

    /**
     * 注册服务提供者.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
