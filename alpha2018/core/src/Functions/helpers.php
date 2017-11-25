<?php
if(! function_exists('vTrue')){
    function vTrue($result = 1)
    {
        return response()->json([
            'success'=>true, 'result'=>$result, 'msg'=>1,
            'status' => 200
        ]);
    }
}
if( !function_exists('vFalse')){
    function vFalse($msg){
        return response()->json([
            'success'=>false, 'result'=>null, 'msg'=>$msg,
            'status'=>500,
        ]);
    }
}


if(! function_exists('api_success_response')) {
    function api_success_response($result = null)
    {
        return response()->json(['success'=>true, 'result'=>$result]);
    }
}

if(!function_exists('api_false_response')){
    function api_false_response($msg = '操作失败', $status = 5000)
    {
        $response = response()->json(['status'=>$status, 'success'=>false, 'result'=>null, 'msg'=>$msg]);
        // 执行动作
        $response = $response->header('Access-Control-Allow-Origin', '*')
                            ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept')
                            ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS')
                            ->header('Access-Control-Allow-Credentials', 'false');  //true Access-Control-Allow-Origin 不能指定为 *

        return $response;
    }
}

if(!function_exists('http_client_request')){
    function http_client_request($method = 'GET', $url, $params = [])
    {
        $method = strtoupper($method);
        $client = new \GuzzleHttp\Client();
        switch ($method)
        {
            case 'GET':
                $res = $client->request('GET', $url, [
                    'query' => $params,
                ]);
                break;
            case 'POST':
                $res = $client->request('POST', $url, [
                    'form_params' => $params
                ]);
                break;
            default:
//                throw new \Exception('');
                $res = $client->request('GET', $url, [
                    'query' => $params,
                ]);
        }



        //echo $res->getStatusCode();// 200
        if(!$res->getStatusCode() == 200){

        }


        //echo $res->getHeaderLine('content-type');// 'application/json; charset=utf8'

        //echo $res->getBody();

        return json_decode($res->getBody(),true);
    }
}

if (!function_exists('api_path')){

}

if (!function_exists('web_path')){
    function web_path($path = '')
    {
        return base_path('alpha2018/src/Web').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if(!function_exists('try_catch')){
    function try_catch($closure){
        try{
            return $closure();
        }  catch (\Exception $e){
            dd($e);
        }
    }
}