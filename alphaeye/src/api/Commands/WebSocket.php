<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 17/3/14
 * Time: 下午4:19
 */
$ser = new WebSocketServer();
$ser->runWorker();

class WebSocketServer
{
    //webSocket配置
    const WEB_SOCKET_HOST = '0.0.0.0';
    const WEB_SOCKET_PORT = 9501;

    //redis配置
    const REDIS_HOST = '127.0.0.1';
    const REDIS_PORT = 6379;
    const REDIS_PASSWORD = null;

    //redis订阅
    const CHANNELS = ['foo'];

    /**
     * Run the worker instance.
     */
    public function runWorker()
    {
        $server = new \swoole_websocket_server(self::WEB_SOCKET_HOST, self::WEB_SOCKET_PORT);

        $server->set([
            'dispatch_mode' => 5, //1平均分配，2按FD取摸固定分配，3抢占式分配，默认为取模(dispatch=2), 5设置已此ID值进行hash固定分配
        ]);
//

        $server->on('open', function (\swoole_websocket_server $server, $request){
            echo "server: handshake success with fd{$request->fd}\n";
            $server->bind($request->fd, $request->get['_identity']);
            $server->helper = new Helper($request->fd, $request->get['_identity']);
//            $clientList = $server->getClientList();
//            foreach ($clientList as $client){
//                var_dump($server->connection_info($client));
//            }
            //$server->connection_info['fd'] = $request->fd;
            $this->redisSubscribeDaemon($server, $request);
        });

        $server->on('connect', function (\swoole_websocket_server $server, $request) {

        });

        $server->on('message', function (\swoole_websocket_server $server, $frame) {

            $this->handleRequest($server, $frame);
        });

        // 监听client关闭事件
        $server->on('close', function (\swoole_websocket_server $server, $fd) {
            echo "client {$fd} closed\n";
            //var_dump($server->worker_id);
            $server->stop($server->worker_id);// 关闭线程
        });
//
        $server->start();
    }

    /**
     * 处理请求
     * @param \swoole_websocket_server $server
     * @param $frame
     * @return bool
     */
    protected function handleRequest(\swoole_websocket_server $server, $frame)
    {
        //echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $fd = $frame->fd;
        parse_str($message = $frame->data, $parameter);

        $request = new Request($parameter);

        switch ($request->get('_method')) {
            case 'bind':
                if ( !$request->has('_identity') ) {
                    $server->push($fd, 'Undefined index: _identity');
                    $server->close($fd);
                    return false;
                }
                $identity = $request->get('_identity');
                break;
            case 'say':
                $server->push($frame->fd, $request->get('msg'));
                break;
            default:

        }
    }

    /**
     * redis subscribe
     *
     * @param $webSocketServer
     * @param $webSocketRequest
     */
    protected function redisSubscribeDaemon(\swoole_websocket_server $webSocketServer, $webSocketRequest)
    {
        $redis = new \Swoole\Coroutine\Redis();
        $redis->connect(self::REDIS_HOST, self::REDIS_PORT);
        $fd = $webSocketRequest->fd;// 当前连接的client标识
        $userIdentity = $webSocketServer->connection_info($fd)['uid'];

        while (true) {
            $redisSubscribe = $redis->subscribe(self::CHANNELS);
            $channel = $redisSubscribe['1'];
            parse_str($message = $redisSubscribe['2'], $parameter);

            $request = new Request($parameter);

            $toUserIdentity = $request->get('to_user');// md5(uid)

            if ( ($userIdentity == $toUserIdentity && $fd == $webSocketServer->helper->fd()) || empty($toUserIdentity) ) {
                $webSocketServer->push($fd, $request->get('msg'));
                continue;
            }
        }
    }
}

class Request
{
    protected $query;

    protected $request;

    /**
     * Constructor.
     *
     * @param array           $query      The GET parameters
     */
    public function __construct(array $query = array())
    {
        $this->initialize($query);
    }

    /**
     * Sets the parameters for this request.
     *
     * This method also re-initializes all properties.
     *
     * @param array           $query    The GET parameters
     */
    public function initialize(array $query = array())
    {
        $this->query = new ParameterBag($query);
    }

    public function get($key, $default = null, $deep = false)
    {
        if ($this !== $result = $this->query->get($key, $this, $deep)) {
            return $result;
        }

        return $default;
    }
}

class Response
{

}

class ParameterBag
{
    /**
     * Parameter storage.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns a parameter by name.
     *
     * @param string $path    The key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function get($path, $default = null, $deep = false)
    {
        if (!$deep || false === $pos = strpos($path, '[')) {
            return array_key_exists($path, $this->parameters) ? $this->parameters[$path] : $default;
        }
    }

    public function has($key)
    {
        return isset($this->parameters[$key]) ? true : false;
    }
}

class Helper
{
    protected $parameters;

    /**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     */
    public function __construct($fd, $identity)
    {
        $this->parameters = ['fd'=>$fd, 'identity'=>$identity];
    }

    public function fd()
    {
        return $this->parameters['fd'];
    }

    public function identity()
    {
        return $this->parameters['identity'];
    }
}



