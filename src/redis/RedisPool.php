<?php


namespace wxy\common\redis;


use EasySwoole\Pool\Config;
use EasySwoole\Pool\AbstractPool;
use EasySwoole\Redis\Config\RedisConfig;
use EasySwoole\Redis\Redis;

class RedisPool extends AbstractPool
{
    protected $redisConfig;

    /**
     * 重写构造函数,为了传入redis配置
     * RedisPool constructor.
     * @param Config      $conf
     * @param RedisConfig $redisConfig
     * @throws \EasySwoole\Pool\Exception\Exception
     */
    public function __construct(Config $conf,RedisConfig $redisConfig)
    {
        parent::__construct($conf);
        $this->redisConfig = $redisConfig;
    }

    protected function createObject()
    {
        //根据传入的redis配置进行new 一个redis
        $redis = new Redis($this->redisConfig);
        $redis->set("testTime",date('y-M-d H:i:s',time()));
        return $redis;
    }
}