<?php
namespace wxy\common\utils;

use Tars\App;
use Tars\client\CommunicatorConfig;
use Tars\config\ConfigServant;

/**
 * 实现Tars框架中的配置处理，例如读取数据库配置参数等
 * Class TarsConfigUtils
 * @package wxy\common\utils
 */
class TarsConfigUtils
{
    /**
     * 获取Tars 服务启动相关配置信息
     * @return mixed
     */
    public static function getTarsConf()
    {
        return App::getTarsConfig();
    }

    /**
     * 获取tars主控地址信息，只能在Tars框架应用内调用，不能在外部系统直接调用
     * @return mixed
     */
    public static function getLocator()
    {
        $tarsConfig = App::getTarsConfig();
        $tarsClientConfig = $tarsConfig['tars']['application']['client'];
        $locator = $tarsClientConfig['locator'];
        return $locator;
    }

    /**
     * 获取Tars框架部署中服务配置》配置列表中指定的配置项
     * @param $app  应用名称
     * @param $server 服务名称
     * @param $filename 配置文件名称
     * @return mixed  正确时返回配置数据据，错误时false
     */
    public static function getConf($app, $server, $filename)
    {
        //这里使用了tars平台的配置下发功能，不喜欢的也可以直接写死配置在这里，像 QD.ActCommentServer的EnvConf 一样
        //在tar平台上，找到QD.UserService 点击服务配置，添加配置，文件名db.json，内容：
        //[
        //  {
        //    "host": "mysql.tarsActDemo.local", //这是是你的mysql地址, json不能有注释，这个要去掉
        //    "port": 3306,
        //    "username": "root",
        //    "password": "password",
        //    "db": "tars_test",
        //    "charset": "utf-8",
        //    "instanceName": "default"
        //  }
        //]

        $serverName = $app.".".$server;
        $config = new CommunicatorConfig();
        $config->setLocator(self::getLocator()); //这里配置的是tars主控地址
        $config->setModuleName($serverName); //主调名字用于显示再主调上报中。
        $config->setCharsetName("UTF-8"); //字符集

        $configServant = new ConfigServant($config);
        $result = $configServant->loadConfig($app, $server, $filename, $dbConfStr);
        var_dump($dbConfStr);
        //TODO 需要判断$result 是否正常
        $conf = json_decode($dbConfStr, true);
        if (!empty($conf)) {
            var_dump('download config success');
           return $conf;
        }
        var_dump('download config fail.');
        return false;
    }
}