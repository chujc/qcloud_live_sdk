<?php
/**
 * Email: john1688@qq.com
 * User: john
 * Date: 2017/10/18
 * Time: 15:35
 */
require 'SDK.php';

class statistics extends SDK {

    function __construct()
    {
        $this->interface = array(
            'Get_LiveStat', //查询指定直播流的推流和播放信息
            'Get_LivePushStat', //仅返回推流统计信息以提高查询效率
            'Get_LivePlayStat', //仅返回播放统计信息以提高查询效率
            'Get_LivePlayStatHistory', //获取播放统计历史信息。
            'Get_LivePushStatHistory' //获取推流历史信息。
        );
    }

    /**
     * @param int $interface 接口类型
     * @param null $stream_id 如不设置stream_id：查询所有正在直播中的流
     * @param int $page_no 从1开始，默认为1
     * @param int $page_size 1~300，默认为300
     * @throws Exception
     * @return mixed
     * @link https://cloud.tencent.com/document/api/267/6110
     */
    public function getLive($interface = 0, $stream_id = null, $page_no = 1, $page_size = 300)
    {

        if (intval($interface)< 0 || intval($interface) > 2) {
            throw new Exception('未找到对应接口');
        }
        if ($page_size > 300) {
            $page_size = 300;
        }

        $sign = $this->getSign();

        $this->url =  "http://statcgi.video.qcloud.com/common_access?cmd={$this->APPID}&interface={$this->interface[$interface]}&t={$this->time}&sign={$sign}&Param.n.page_no={$page_no}&Param.n.page_size={$page_size}";

        if ($stream_id) {
            $this->url = $this->url."&Param.s.stream_id=$stream_id";
        }
        return $this->request();
    }

    /**
     * @param $cmd 需要申请下发配置，请联系腾讯商务人员或者提交工单，联系电话：4009-100-100
     * @param int $start_time
     * @param int $end_time
     * @param null $stream_id
     * @param null $domain
     * @link https://cloud.tencent.com/document/api/267/9580
     */
    public function Get_LivePlayStatHistory($cmd, $start_time, $end_time, $stream_id = null, $domain = null)
    {

        $sign = $this->getSign();

        $this->url =  "http://statcgi.video.qcloud.com/common_access?cmd={$cmd}&interface={$this->interface[3]}&t={$this->time}&sign={$sign}&Param.n.start_time={$start_time}&Param.n.end_time={$end_time}";

        if ($stream_id) {
            $this->url = $this->url."&Param.s.stream_id=$stream_id";
        }
        if ($domain) {
            $this->url = $this->url."&Param.s.domain=$domain";
        }
        return $this->request();
    }

    /**
     * @param $cmd
     * @param $start_time
     * @param $end_time
     * @param $stream_id
     * @link https://cloud.tencent.com/document/api/267/9579
     */
    public function Get_LivePushStatHistory($cmd, $start_time, $end_time, $stream_id)
    {
        $sign = $this->getSign();

        $this->url =  "http://statcgi.video.qcloud.com/common_access?cmd={$cmd}&interface={$this->interface[4]}&t={$this->time}&sign={$sign}&Param.n.start_time={$start_time}&Param.n.end_time={$end_time}&Param.s.stream_id=$stream_id";

        return $this->request();
    }
}
