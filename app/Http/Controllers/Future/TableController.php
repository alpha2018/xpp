<?php
namespace App\Http\Controllers\Future;
use App\Http\Controllers\Controller;
use Davinciandalien\Blade\Traits\BladeTemplate;
use Davinciandalien\Blade\Traits\ViewFile;
use Illuminate\Support\Facades\Storage;

class TableController extends Controller
{
    use BladeTemplate, ViewFile;

    /**
     * 列显示名称,是一个数组对象
     * ['id','name']
     */
    public $colNames = [

    ];

    /**
     *
     * @var array
     * ['name'=>'id'],['name'=>'name']
     */
    public $colModel = [

    ];


    /**
     * 操作按钮
     * [[1,'编辑'],[2,'查看'],[5,'删除']]
     */
    public $buttons = [];



    /**
     * 页面title
     *
     * @var string
     */
    public $title;


    public function __construct()
    {
        $this->viewFile();
    }

    public function  make()
    {


        $thead = $this->setTableThead();

        $tbody = $this->setTableTbody($this->setBtnString());

        $javascript = $this->setJavascript();

        $page = $this->setPage();

        $bladeTemplate = $this->setBladeTemplate($thead,$tbody,$page,$javascript);

        $this->makeView($bladeTemplate);
    }

    /**
     * 设置分页
     *
     * @return string
     */
    protected function setPage()
    {
        return '{!! $items->render() !!}';
    }

    /**
     * 设置表格内容
     *
     * @param $btnString
     * @return string
     */
    protected function setTableTbody($btnString)
    {
        $colModel = $this->colModel;

        $tbody = '@foreach($items as $item)';

        $tbody .= '<tr>';

        foreach ($colModel as $aColModel) {

            $tbody .= '<td>{{ $item->'.$aColModel.' }}</td>';
        }

        $tbody .= '<td>'.$btnString.'</td>';

        $tbody .= '</tr>';

        $tbody .= '@endforeach';

        return $tbody;
    }

    /**
     * 设置按钮
     *
     * @return string
     */
    protected function setBtnString()
    {
        $btnString = "\n";

        foreach ($this->buttons as $k=>$v){

            $btnString .= '<button data-loading-text="Loading..." class="'.$this->btnStyle[$v['0']]['className'].'"';

            $btnString .= ' data-id="{{ $item->id }}"';

            //判断是否是5
            if($v['0'] == 5){

                $btnString .= ' onclick="ajaxDel(this)"';

            }else{// data-width normal large

                $btnString .= ' data-toggle="modal" data-target="#J_Dialog" data-width="normal" data-backdrop="static"';

                isset($v['2']) ? $btnString .= ' onclick="ajax'.ucfirst($v['2']).'(this)"' : '';
            }

            $btnString .= '>'.$v['1'].'</button>'."\n";
        }

        return $btnString;
    }

    /**
     * 设置javascrpt
     *
     * @return string
     */
    protected function setJavascript(){
        $javascript = '<script>'."\n";

        foreach ($this->buttons as $k=>$v) {
            if(isset($v['2'])) {
                $javascript .= 'function ajax' . ucfirst($v['2']) . '(_this){'."\n";

                $javascript .= <<<Javascript
    var btnName = $(_this).text();
	console.log(btnName);
	$('#myModalLabel').text(btnName);
    
Javascript;


                $javascript .= '}'."\n";
            }
        }

        $javascript .= '</script>'."\n";

        return $javascript;
    }

    /**
     * 设置表格的表头
     *
     * @return string
     */
    protected function setTableThead()
    {
        $colNames = $this->colNames;

        $thead = '<tr>';

        foreach ($colNames as $aColNames) {
            $thead .= '<th>'.$aColNames.'</th>';
        }

        $thead .= '</tr>';

        return $thead;
    }

    public function addTh(...$ths)
    {
        foreach ($ths as $th){
            $this->colNames[] = $th;
        }

    }

    public function addTd(...$tds)
    {
        foreach ($tds as $td){
            $this->colModel[] = $td;
        }
    }

    public function addBtn(...$btns)
    {
        foreach ($btns as $btn){
            $this->buttons[] = $btn;
        }


        if(count($this->buttons) > 0){
            $this->colNames[] = '操作';
        }
    }

    /**
     * @param string $functionName
     * @param array $args
     */
    function __call($name,$arguments){




        echo"你所调用的函数： ".$name."(参数: ";
        print_r($arguments);
        echo")不存在！<br>\n";
    }
}