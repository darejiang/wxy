<?php
namespace wxy\common\utils;


class DateFormatUtils
{
    /**
     * 将转入的时间转换为Y-m-d H:i:s
     * @param unknown $timestamp
     * @return string
     */
    public static function getdatetime($timestamp)
    {
        if (is_string($timestamp))	///如果是字符串,则先转换为日期时间截
        {
            $date = strtotime($timestamp);
        }else{
            $date = $timestamp;
        }
        if ($date == 0){
            return "";
        }else {
            return Date("Y-m-d H:i:s",$date);
        }
    }


    /**
     * 将转入的时间转换为Y-m-d
     * @param unknown $timestamp
     * @return string
     */
    public static function getshortdate($timestamp)
    {
        if (is_string($timestamp))	///如果是字符串,则先转换为日期时间截
        {
            $date = strtotime($timestamp);
        }else{
            $date = $timestamp;
        }

        if ($date == 0){
            return "";
        }else {
            return Date("Y-m-d",$date);
        }
    }


    /**
     * 校验日期格式是否正确
     *
     * @param string $date 日期
     * @param string $formats 需要检验的格式数组
     * @return boolean true/false
     */
    public static function checkDateIsValid($date,$formats = array("Y-m-d", "Y/m/d"))
    {
        $unixTime = strtotime($date);
        if (!$unixTime)
        { //strtotime转换不对，日期格式显然不对。
            return false;
        }

        //校验日期的有效性，只要满足其中一个格式就OK
        foreach ($formats as $format){
            if (date($format,$unixTime) == $date){
                return true;
            }
        }

        return false;
    }
}