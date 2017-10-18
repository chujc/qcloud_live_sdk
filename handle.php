<?php
/**
 * Email: john1688@qq.com
 * User: john
 * Date: 2017/10/18
 * Time: 15:35
 */
require 'SDK.php';

class handle extends SDK {

    /**
     * 开启关闭推流
     * @param $stream_id
     * @param int $status 	0表示禁用； 1表示允许推流；2表示断流
     * @link https://cloud.tencent.com/document/api/267/5959
     */
    public function Live_Channel_SetStatus($stream_id, $status)
    {
        $sign = $this->getSign();

        if (!in_array($status, array(
            0,1,2
        ))) {
            $status = 0;
        }

        $this->url =  "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Channel_SetStatus&t={$this->time}&sign={$sign}&Param.s.channel_id={$stream_id}&Param.n.status={$status}";

        if ($stream_id) {
            $this->url = $this->url."&Param.s.stream_id=$stream_id";
        }
       $this->request();
    }


    /**
     * 云端混流 暂时用不到需要的看文档
     * @link https://cloud.tencent.com/document/api/267/8832
     */
    public function Mix_StreamV2()
    {
        $sign = $this->getSign();
        $this->url =  "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Channel_SetStatus&t={$this->time}&sign={$sign}";

    }

    /**
     * 创建录制任务
     * @param $stream_id
     * @param $start_time
     * @param $end_time
     * @param int $task_sub_type
     * @param string $file_format
     * @param string $record_type
     * @link https://cloud.tencent.com/document/api/267/9567
     */
    public function Live_Tape_Start($stream_id, $start_time, $end_time, $task_sub_type = 0, $file_format = 'flv', $record_type = 'video')
    {

        $start_time = urlencode($start_time);
        $end_time = urlencode($end_time);

        $sign = $this->getSign();
        $this->url =  "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Tape_Start&t={$this->time}&sign={$sign}&Param.s.channel_id={$stream_id}&Param.s.start_time={$start_time}&Param.s.end_time={$end_time}&Param.n.task_sub_type={$task_sub_type}&Param.s.file_format={$file_format}&Param.s.record_type={$record_type}";

        $this->request();
    }

    /**
     * 暂停并延迟恢复
     * @param $stream_id
     * @param $abstime_end
     * @param $action
     * @link https://cloud.tencent.com/document/api/267/9500
     */
    public function channel_manager($stream_id, $abstime_end, $action)
    {
        $action = $action == 'forbid' ? 'forbid' : 'resume';
        $sign = $this->getSign();
        $this->url =  "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Channel_SetStatus&t={$this->time}&sign={$sign}&Param.s.channel_id={$stream_id}&Param.n.abstime_end={$abstime_end}&Param.s.action={$action}";

        $this->request();

    }

    /**
     * 结束录制任务
     * @param $stream_id
     * @param $task_id
     * @param int $task_sub_type
     * @link https://cloud.tencent.com/document/api/267/9568
     */
    public function Live_Tape_Stop($stream_id, $task_id, $task_sub_type = 0)
    {

        $task_sub_type = $task_sub_type == 0 ? 0 : 1;

        $sign = $this->getSign();
        $this->url =  "http://fcgi.video.qcloud.com/common_access?appid={$this->APPID}&interface=Live_Tape_Stop&t={$this->time}&sign={$sign}&Param.s.channel_id={$stream_id}&Param.s.task_id={$task_id}&Param.n.task_sub_type={$task_sub_type}";

        $this->request();
    }
}
