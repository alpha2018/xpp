<?php
namespace Libs\Utils;

use function GuzzleHttp\json_decode;
class HttpClient
{
    /**
     * post请求
     * @param string $params
     * @param mixed $method 接口编号
     * @param string $url
     * @return mixed
     */
    public static function post($params,$method,$url='')
    {
        $client = new \GuzzleHttp\Client();
        
        $res = $client->request('Post', 'http://localhost:8080/delugeServ/BridgeServlet', [
            'query' => ['param'=>$params,'method'=>$method]
        ]);
        
        //echo $res->getStatusCode();// 200
        if(!$res->getStatusCode() == 200){
            
        }
        
        
        //echo $res->getHeaderLine('content-type');// 'application/json; charset=utf8'
        
        //echo $res->getBody();
        
        return json_decode($res->getBody(),true);

    }
}