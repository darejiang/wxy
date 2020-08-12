<?php


namespace wxy\common\modal;


use EasySwoole\ORM\AbstractModel;

/**
 * 自动分表必须断承这个类
 * dividid为分表的数据，这个与具体业务相关
 * dividid % 10 取余数得到对应表名的后缀
 * tableName初始化时应该使用没有后缀号的表名
 * Class AbstractDividModel
 * @package HttpServer\testModel
 */
abstract class AbstractDividModel extends AbstractModel
{
    public function setDividid($dividid){
        $modLeft = $dividid % 10;
        $this->tableName = $this->tableName.$modLeft;
        return $this;
    }

}