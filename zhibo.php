<?php
/**
 * Email: john1688@qq.com
 * User: john
 * Date: 2017/10/18
 * Time: 15:35
 */
require 'SDK.php';
class zhibo extends SDK {

    /**
     * 获取推流地址
     * 如果不传key和过期时间，将返回不含防盗链的url
     * @param streamId '您用来区别不通推流地址的唯一id
     *        time 过期时间 sample 2016-11-12 12:00:00
     * @return String url
     */
    function getPushUrl($streamId, $time = null)
    {
        if ($time === null) {
            //如果没有传入time  默认2个小时;
            $time = date('Y-m-d H:i:s', time() + 3600 *2);
        }
        $txTime = strtoupper(base_convert(strtotime($time), 10, 16));
        $livecode = $this->BIZID . "_" . $streamId; //直播码
        $txSecret = md5($this->PUSH_KEY . $livecode . $txTime);
        $ext_str = "?" . http_build_query(array(
                "bizid" => $this->BIZID,
                "txSecret" => $txSecret,
                "txTime" => $txTime
            ));

        return "rtmp://" . $this->BIZID . ".livepush.myqcloud.com/live/" . $livecode . (isset($ext_str) ? $ext_str : "");
    }

    /**
     * 获取播放地址
     * @param streamId '您用来区别不通推流地址的唯一id
     * @return String url
     */
    function getPlayUrl($streamId)
    {
        $livecode = $this->BIZID . "_" . $streamId; //直播码
        return array(
            "rtmp://" . $this->BIZID . ".liveplay.myqcloud.com/live/" . $livecode,
            "http://" . $this->BIZID . ".liveplay.myqcloud.com/live/" . $livecode . ".flv",
            "http://" . $this->BIZID . ".liveplay.myqcloud.com/live/" . $livecode . ".m3u8"
        );
    }

}