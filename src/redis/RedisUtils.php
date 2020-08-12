<?php


namespace wxy\common\redis;


use EasySwoole\Component\Singleton;
use EasySwoole\Redis\Redis;

class RedisUtils
{
    use Singleton;

    public function __construct()
    {
        $config = new \EasySwoole\Pool\Config();
        $conf = [
            'host'=>'127.0.0.1',
            'port'=>'6379',
            'auth'=>'swoole123456',
            'db'=>0,
        ];
        $config->setMaxObjectNum(20);

        $redisConfig = new \EasySwoole\Redis\Config\RedisConfig($conf);
        $customRedisPool = new \HttpServer\redis\RedisPool($config,$redisConfig);
        \EasySwoole\Pool\Manager::getInstance()->register($customRedisPool,'redis');
    }

    //这种方式需要手动回收
    public function getRedis():Redis {
       return \EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
    }
    //回收到池子
    public function recycleRedis($redis){
        \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redis);
    }

    //这种方式不需要回收
    public function getRedisByDefer():Redis{
        return \EasySwoole\Pool\Manager::getInstance()->get('redis')->defer();
    }
}