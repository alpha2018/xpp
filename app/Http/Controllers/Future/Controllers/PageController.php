<?php namespace Modules\Future\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PageController extends Controller
{
    public function __construct()
    {

    }


    public function paginator(Request $request)
    {

        $pagedata  = [
            ['username'=>'zhangsan', 'age'=>26],
            ['username'=>'lisi', 'age'=>23],
            ['username'=>'wangwu', 'age'=>62],
            ['username'=>'zhaoliu', 'age'=>46],
            ['username'=>'wangmazi', 'age'=>25],
            ['username'=>'lanzi', 'age'=>24],
            ['username'=>'pangzi', 'age'=>21],
            ['username'=>'zhaoliu', 'age'=>46],
            ['username'=>'wangmazi', 'age'=>25],

            ['username'=>'lanzi', 'age'=>24],
            ['username'=>'wangmazi', 'age'=>25],
            ['username'=>'wangmazi', 'age'=>25],
            ['username'=>'wangmazi', 'age'=>25],
            ['username'=>'wangmazi', 'age'=>25],
            ['username'=>'wangmazi', 'age'=>25],

        ];

        $currentPage=1; //当前页码

        if($request->input('page'))
        {
            $currentPage=$request->input('page');
        }

        $perPage=10;    //每页显示数
        $total=count($pagedata);    //总条数

        $items = array_slice($pagedata, ($currentPage-1)*$perPage, $perPage); //注释1


        $pages=ceil($total/$perPage);
        //这里前面引入命名类，如果没有引入，可以这样做


        $paged=new LengthAwarePaginator($items,$total,$perPage,$currentPage);

        //$pafed = new Paginator($items,$perPage,$currentPage);

        $paged=$paged->setPath(request()->url());


        print_r($paged->render());

dd();

        return view();
    }
}