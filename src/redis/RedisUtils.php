<?php


namespace wxy\common\redis;


use EasySwoole\Component\Singleton;
use EasySwoole\Redis\Redis;
use wxy\common\utils\TarsConfigUtils;

class RedisUtils
{
    use Singleton;

    /**
     * 注册redis连接配置
     * 请在框架启动后，读取配置参数，然后调用该方法
     * @param $connConfig 连接参数数组
     *            [ {'host'=>$host,
                    'port'=>$port,
                    'auth'=>$auth,
                    'db'=>$db,
     *              'maxConn'=>20,
     *              'minConn'=>5,
     *                  }
     *              ]
     */
    public function setConnectConfig($connConfig){
        var_dump('setConnectConfig1:' . json_encode($connConfig));
        $config = new \EasySwoole\Pool\Config();
        $conf = [
            'host' => $connConfig[0]['host'] ?? '127.0.0.1',
            'port' => $connConfig[0]['port'] ?? '6379',
            'auth' => $connConfig[0]['auth'] ?? '',
            'db' => $connConfig[0]['db'] ?? 0,
        ];
        $config->setMaxObjectNum($connConfig[0]['maxConn']??20);
        $config->setMinObjectNum($connConfig[0]['minConn']??2);

        $redisConfig = new \EasySwoole\Redis\Config\RedisConfig($conf);
        $customRedisPool = new RedisPool($config, $redisConfig);
        \EasySwoole\Pool\Manager::getInstance()->register($customRedisPool, 'redis');
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