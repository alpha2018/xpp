<?php namespace Blog\Repositories;
use Blog\Models\Article;
use Illuminate\Contracts\Foundation\Application;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/4/17
 * Time: 下午3:11
 */
class ArticleRepository
{
    protected $model;
    protected $app;

    public function __construct(Application $app, Article $article)
    {
        $this->app = $app;
        $this->model = $this->app->make($article);
    }

    /**
     * Get the article record
     *
     * @param  int $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }


    /**
     * Delete the article.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }
}