<?php


namespace wxy\common\mysql;


use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;


class MysqlUtils
{
    /**
     * 注册redis连接配置
     * 请在框架启动后，读取配置参数，然后调用该方法
     * @param $connConfig 连接参数数组
     *            [ { 'host' => '127.0.0.1',
     *               'port' => '3306',
     *               'user' => 'root',
     *               'password' => 'olRfWg6gJYCJvnaH@13',
     *               'database' => 'tars_test',
     *               'timeout' => 15,
     *               'charset' => 'utf8',
     *              'maxConn'=>20,
     *              'minConn'=>5,
     *                  }
     *              ]
     * @return
     * @throws
     */
    public static function setConnectConfig($connConfig){
        var_dump('setConnectConfig1:' . json_encode($connConfig));
        $conf = [
            'host' => $connConfig[0]['host'] ?? '127.0.0.1',
            'port' =>  $connConfig[0]['port'] ?? '3306',
            'user' => $connConfig[0]['user'] ?? 'root',
            'password' => $connConfig[0]['password'] ?? '',
            'database' => $connConfig[0]['database'] ?? '',
            'timeout' => 15,
            'charset' => $connConfig[0]['charset'] ?? 'utf8',
        ];

        $config = new \EasySwoole\ORM\Db\Config($conf);
        //连接池配置
        $config->setGetObjectTimeout(3.0); //设置获取连接池对象超时时间
        $config->setIntervalCheckTime(30*1000); //设置检测连接存活执行回收和创建的周期
        $config->setMaxIdleTime(15); //连接池对象最大闲置时间(秒)
        $config->setMaxObjectNum($connConfig[0]['maxConn']??20); //设置最大连接池存在连接对象数量
        $config->setMinObjectNum($connConfig[0]['minConn']??5); //设置最小连接池存在连接对象数量
        $config->setAutoPing(5); //设置自动ping客户端链接的间隔

        DbManager::getInstance()->addConnection(new Connection($config));
    }
}