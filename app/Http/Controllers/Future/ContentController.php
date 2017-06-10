<?php
namespace App\Http\Controllers\Future;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    /**
     * 表格名称
     */
    public $caption = '';

    /**
     * 列显示名称,是一个数组对象
     * ['id','name']
     */
    public $col_names = [

    ];

    /**
     *
     * @var array
     * ['name'=>'id'],['name'=>'name']
     */
    public $col_model = [

    ];


    /**
     * 操作按钮
     * [[1,'编辑'],[2,'查看'],[5,'删除']]
     */
    public $buttons = [];

    /**
     * 数据
     * @var array
     */
    public $data = [];

    /**
     * 保存的视图名称
     * @var string
     */
    public $view_name ;

    /**
     * 保存的视图地址
     * @var string
     */
    public $path;

    /**
     * 当前访问的pathInfo
     * @var string
     *
     */
    public $pathInfo;


    /**
     * @var string
     */
    //public $requestUri;

    /**
     * @var
     */
    public $uri;

    /**
     * @var string
     */
    public $filename;

    /**
     * 页面title
     *
     * @var string
     */
    public $title = '';

    /**
     * 按钮样式
     * 1: 默认
     * 2: 成功
     * 3: 信息
     * 4: 警告
     * 5: 危险
     *
     * @var array
     */
    public $button_style = [
        [
            'className'=>'sui-btn btn-bordered btn-small',
            'label'=>'<i class="ace-icon fa fa-pencil align-top "></i> 默认',
            'onclick'=>''
        ],
        [
            'className'=>'sui-btn btn-bordered btn-small btn-primary',
            'label'=>'<i class=""></i> 编辑',
            'onclick'=>''
        ],
        [
            'className'=>'sui-btn btn-bordered btn-small btn-success',
            'label'=>'<i class=""></i> 成功',
            'onclick'=>''
        ],
        [
            'className'=>'sui-btn btn-bordered btn-small btn-info',
            'label'=>'<i class=""></i> 信息',
            'onclick'=>''
        ],
        [
            'className'=>'sui-btn btn-bordered btn-small btn-warning',
            'label'=>'<i class=""></i> 警告',
            'onclick'=>''
        ],
        [
            'className'=>'sui-btn btn-bordered btn-small btn-danger',
            'label'=>'<i class=""></i> 删除',
            'onclick'=>'ajaxDel({{ $item->id }})'
        ],
    ];


    public function __construct()
    {
        $this->pathInfo =request()->getPathInfo();

        //$this->requestUri = request()->getRequestUri();

        $this->uri = request()->getUri();

        $this->view_name = str_replace('/','_',$this->pathInfo).'.blade.php';

        $this->path = config('build.view_path');

        $this->filename = $this->path.'/'.$this->view_name;
    }

    public function  save()
    {


        $thead = $this->setThead();

        $btnString = $this->setBtnString();

        $tbody = $this->setTbody($btnString);

        $javascript = $this->setJavascript();

        $page = $this->setPage();

        $html = $this->setHtml($thead,$tbody,$page,$javascript);




        $handle = fopen($this->filename,'w');

        if(flock($handle,LOCK_EX)) {
            fwrite($handle, $html);
            flock($handle,LOCK_UN);
        }
        fclose($handle);


        //print_r($ret1,$ret2);

         //$ret = Storage::disk('local')->put($this->filename , $html);

        //return $ret;
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
    protected function setTbody($btnString)
    {
        $colModel = $this->col_model;

        $tbody = '@foreach($items as $item)';

        $tbody .= '<tr>';
//dd($colModel);
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

            $btnString .= '<button data-loading-text="Loading..." class="'.$this->button_style[$v['0']]['className'].'"';

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
    protected function setThead()
    {
        $colNames = $this->col_names;

        $thead = '<tr>';

        foreach ($colNames as $aColNames) {
            $thead .= '<th>'.$aColNames.'</th>';
        }

        $thead .= '</tr>';

        return $thead;
    }

    /**
     * 设置html
     *
     * @param $thead
     * @param $tbody
     * @param $page
     * @param $javascript
     * @return string
     */
    protected function setHtml($thead,$tbody,$page,$javascript)
    {
        $title = $this->title;
        //dd(dirname(__FILE__));


        $content = file_get_contents(dirname(__FILE__).'/content.blade.php');

        $content = str_replace('@@title@@', $title, $content);

        $content = str_replace('@@thead@@', $thead, $content);

        $content = str_replace('@@tbody@@', $tbody, $content);

        $content = str_replace('@@pager@@', $page, $content);

        $content = str_replace('@@javascript@@', $javascript, $content);

        return $content;
        dd($content);

        $title = $this->title;

        $html = <<<CREATE
@extends('layouts.app') @section('content')

<section class="data-section">
	<h2>$title</h2>
	<p>sui前端组件库+vue库+laravel框架实现</p>
	<form class="sui-form form-dark" method="get">

		<div class="input-control">
			<input type="text" class="input-medium" name="kw"><i class="sui-icon icon-touch-magnifier"></i>
			<button type="submit" class="sui-btn btn-primary btn-">Search</button>
		</div>

	</form>
	<table class="sui-table table-bordered table-hover">

		<thead>
			$thead
		</thead>
		<tbody>
            $tbody
            
		</tbody>
	</table>
	<div class="sui-pagination">
	$page
	</div>
	
	<!- dialog ->
    <div id="J_Dialog" tabindex="-1" role="dialog"
		class="sui-modal hide fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true"
						class="sui-close">×</button>
					<h4 id="myModalLabel" class="modal-title">供应商收编</h4>
				</div>
				<div class="modal-body sui-form form-horizontal">
					<div class="sui-msg msg-block msg-default msg-tips">
						<div class="msg-con">以下为供销平台上已经获得小二授权经营您的品牌但还未被您进行收编的供应商</div>
						<s class="msg-icon"></s>
					</div>

					<form id="user_form"
						class="ui-form form-horizontal
		sui-validate" role="form">
						<input type="hidden" name="id" value="">
						<div class="control-group">
							<label for="inputName" class="control-label">用户名：</label>
							<div class="controls">
								<input type="text" id="inputName" name="name" placeholder="用户名"
									data-rules="required|minlength=4|maxlength=16" Value="">
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div><!-/dialog ->
	
</section>

$javascript

<script>
    function ajaxDel(_this) {
        if(!confirm('是否确认删除？')){
		    return false;
		}
		
		var id = $(_this).attr('data-id')
		console.log(_this);
		
		console.log(id);
		
        $.ajax({
            url:'$this->pathInfo/'+id,
            type:'POST',
            headers: {
                'X-HTTP-Method-Override': 'DELETE' ,
                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
            },
            data:{},
            beforeSend : function(){
                loding.load();
            },
            success:function(res){
						
                if(res.code == 200){
                    location.replace(document.URL);
                }

			},
            complete: function () {
                    loding.close();
            }
        });
    }
</script>

@endsection
CREATE;
        return $html;
    }


    public function addTh(...$ths)
    {
        foreach ($ths as $th){
            $this->col_names[] = $th;
        }

    }

    public function addTd(...$tds)
    {
        foreach ($tds as $td){
            $this->col_model[] = $td;
        }
    }

    public function addBtn(...$btns)
    {
        foreach ($btns as $btn){
            $this->buttons[] = $btn;
        }


        if(count($this->buttons) > 0){
            $this->col_names[] = '操作';
        }
    }
}