<?php
/**
 * Email: john1688@qq.com
 * User: john
 * Date: 2017/10/18
 * Time: 15:35
 */
require 'SDK.php';

class query extends SDK {


    /**
     * 用于查询某条流是否处于正在直播的状态
     * @param $stream_id //直播码
     * @link https://cloud.tencent.com/document/api/267/5958
     */
    public function Live_Channel_GetStatus($stream_id)
    {

        $sign = $this->getSign();
        $this->url = "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Channel_GetStatus&t={$this->time}&sign={$sign}&Param.s.channel_id={$stream_id}";

        $this->request();
    }

    /**
     *  用于查询某条直播流某段时间内生成的录制文件。
     * @param $stream_id
     * @param int $page_no
     * @param int $page_size
     * @param string $sort_type
     * @param int $start_time
     * @param int $end_time
     *
     * @link https://cloud.tencent.com/document/api/267/5960
     */
    public function Live_Tape_GetFilelist($stream_id, $page_no = 1, $page_size = 10, $sort_type = 'asc', $start_time = null, $end_time = null)
    {

        if ($page_size > 100) {
            $page_size = 100;
        }

        if ($sort_type == 'asc') {
            $sort_type = 'desc';
        }

        $sign = $this->getSign();
        $this->url = "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Tape_GetFilelist&t={$this->time}&sign={$sign}&Param.s.channel_id={$stream_id}&Param.n.page_no={$page_no}&Param.n.page_size={$page_size}&Param.s.sort_type{$sort_type}";

        if ($start_time) {
            $start_time = date('Y-m-d H:i:s', $start_time);
            $this->url = $this->url."&Param.s.start_time={$start_time}";
        }
        if ($end_time) {
            $end_time = date('Y-m-d H:i:s', $end_time);
            $this->url = $this->url."&Param.s.end_time={$end_time}";
        }

        $this->request();
    }

    /**
     * 查询直播中的频道新产生的截图文件。
     * @param $bid
     * @param int $count
     * @link https://cloud.tencent.com/document/api/267/5961
     */
    public function Live_Queue_Get($bid, $count = 1)
    {
        $sign = $this->getSign();

        if ($count > 100) {
            $count = 100;
        }

        $this->url = "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Queue_Get&t={$this->time}&sign={$sign}&Param.n.bid={$bid}&Param.n.count={$count}";

        $this->request();

    }

    /**
     * 查询频道列表
     * @param int $status
     * @param int $page_no
     * @param int $page_size
     * @param int $order_type
     * @param string $order_field
     * @link https://cloud.tencent.com/document/api/267/7997
     */
    public function Live_Channel_GetChannelList($status = -1, $page_no = 1, $page_size = 10, $order_type = 1, $order_field = 'create_time')
    {


        $sign = $this->getSign();

        $order_type = $order_type ?:'0';

        $this->url = "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Channel_GetChannelList&t={$this->time}&sign={$sign}&Param.n.page_no={$page_no}&Param.n.page_size={$page_size}&Param.n.order_type={$order_type}&Param.n.order_field={$order_field}";

        if ($status >= 0) {
            $this->url =  $this->url."&Param.n.status={$status}";
        }
        $this->request();
    }

    /**
     * 查询直播中频道列表
     * @link https://cloud.tencent.com/document/api/267/8862
     */
    public function Live_Channel_GetLiveChannelList()
    {
        $sign = $this->getSign();
        $this->url = "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Channel_GetLiveChannelList&t={$this->time}&sign={$sign}";
        $this->request();
    }


}
