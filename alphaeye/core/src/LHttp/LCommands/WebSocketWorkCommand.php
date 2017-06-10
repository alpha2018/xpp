<?php namespace Api\Commands;

use Illuminate\Queue\Worker;
use Illuminate\Console\Command;

class WebSocketWorkCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'websocket:work
                            {--sleep=3 : Number of seconds to sleep when no job is available}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start WebSocket';

    /**
     * The queue worker instance.
     *
     * @var \Illuminate\Queue\Worker
     */
    protected $worker;

    /**
     * Create a new queue listen command.
     *
     * @param  \Illuminate\Queue\Worker  $worker
     * @return void
     */
    public function __construct(Worker $worker)
    {
        parent::__construct();

        $this->worker = $worker;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $server = $this->runWorker();
    }

    /**
     * Run the worker instance.
     */
    protected function runWorker()
    {
        $server = new \swoole_websocket_server("0.0.0.0", 9501);

        $server->set([
            'dispatch_mode' => 5, //1平均分配，2按FD取摸固定分配，3抢占式分配，默认为取模(dispatch=2), 5设置已此ID值进行hash固定分配
        ]);
        //
        $server->on('connect', function (\swoole_websocket_server $server, $request){
            var_dump(1);
        });

        $server->on('open', function (\swoole_websocket_server $server, $request) {

            var_dump($server);
            $this->bind($server, $request);
            echo "server: handshake success with fd{$request->fd}\n";

            $this->redisSubscribe($server, $request);
        });

        $server->on('message', function (\swoole_websocket_server $server, $frame) {
            $this->handleRequest($server, $frame);
        });

        $server->on('close', function (\swoole_websocket_server $server, $fd) {
            echo "client {$fd} closed\n";

        });
        //
        $server->start();
    }

    public function bind(\swoole_websocket_server $server, $request)
    {
        $server->bind($request->fd, $request->get['_identity']);
        $user['uid'] = $request->get['_identity'];
        $user['fd'] = $request->fd;


        $GLOBALS['connection_info'] = $user;
    }

    /**
     * 处理请求
     * @param \swoole_websocket_server $server
     * @param $frame
     * @return bool
     */
    public function handleRequest(\swoole_websocket_server $server, $frame)
    {
        //echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $fd = $frame->fd;
        $params = $frame->data;
        $params = json_decode($params, true);

        $params['_method'];
        switch ($params['_method']){
            case 'bind':
                if (!isset($params['_identity'])){
                    $server->push($fd, 'Undefined index: _identity');
                    $server->close($fd);
                    return false;
                }
                $identity = $params['_identity'];
                break;
            case 'say':
                $server->push($frame->fd, $frame->data);
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
    public function redisSubscribe(\swoole_websocket_server $webSocketServer, $webSocketRequest)
    {
        $redis = new \Swoole\Coroutine\Redis();
        $redis->connect('127.0.0.1', 6379);

        while (true){
            $fd = $webSocketRequest->fd;// 当前连接的client标识
            $userIdentity = $webSocketServer->connection_info($fd)['uid'];
            if (!$webSocketServer->exist($fd)){
                return $redis->close();
            }
            $redisSubscribe = $redis->subscribe(['foo', 'foo1']);
            $channel = $redisSubscribe['1'];
            $message = $redisSubscribe['2'];
            $messageJsonDecode = json_decode($message, true);

            $toUserIdentity = $messageJsonDecode['to_user'];// md5(uid)

            echo $GLOBALS['connection_info']['fd'];

            if($userIdentity == $toUserIdentity && $GLOBALS['connection_info']['fd'] == $fd){
                $webSocketServer->push($fd, $message);
                continue;
            }
            if (empty($toUserIdentity)){
                $webSocketServer->push($fd, $message);
                continue;
            }
        }
    }

    /**
     * Listen to the given queue in a loop.
     *
     * @param  string  $connectionName
     * @param  string  $queue
     * @param  \Illuminate\Queue\WorkerOptions  $options
     * @return void
     */
    public function daemon($connectionName, $queue, WorkerOptions $options)
    {
        $lastRestart = $this->getTimestampOfLastQueueRestart();

        while (true) {
            $this->registerTimeoutHandler($options);

            if ($this->daemonShouldRun($options)) {
                $this->runNextJob($connectionName, $queue, $options);
            } else {
                $this->sleep($options->sleep);
            }

            if ($this->memoryExceeded($options->memory) ||
                $this->queueShouldRestart($lastRestart)) {
                $this->stop();
            }
        }
    }
}
