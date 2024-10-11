<?php

namespace amap\track;

use amap\enum\TrackEnum;
use amap\track\Request;

class Trace
{

    /**
     * 创建轨迹
     * 创建一条轨迹，一个终端下最多可创建500000条轨迹。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/track-sdk#t2
     */
    static function add(int $sid, int $tid, string $trname = '')
    {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
        ];
        if ($trname != '') {
            $params['trname'] = $trname;
        }
        $req = new Request(
            TrackEnum::API_TRACE_ADD,
            TrackEnum::API_TRACE_ADD_METHOD,
            $params
        );
        return $req->data;
    }

    /**
     * 删除轨迹
     * 删除一条轨迹，轨迹删除后无法进行恢复。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/track-sdk#t3
     */
    static function delete(int $sid, int $tid, int $trid)
    {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
            'trid' => $trid,
        ];
        new Request(
            TrackEnum::API_TRACE_ADD,
            TrackEnum::API_TRACE_ADD_METHOD,
            $params
        );
    }

    /**
     * 轨迹点上传（单点、批量）
     * 1. 可以将终端的轨迹点通过经纬度上传接口进行上传，支持批量上传以及单点上传。
     * 2. 在上传经纬度之前需要先通过创建轨迹接口创建一条轨迹，拿到trid，根据trid上传经纬度点；如果用户指定了trid（轨迹id），但是trid不存在，该点按照trid字段为空存储，并返回对应的错误信息：trid不存在，点已存储，此时点信息会绑定在tid上，不会生成轨迹。 
     * 3. 若一次上传多个点，其中有一个/多个出错时，服务会进行报错，但是正确的点会上传到服务器之中可以正常使用，并且在结果之中会显示出错点的序号。例如：用户上传了A、B、C、D、E 这五个点，其中C点的数据是错误的，服务会返回报错结果，及序号：3；但是A、B、D、E这4个点已经成功上传
     * @param array $points 点数据数组，数组中每个元素应包含以下字段：
     *  - location (string)         经纬度坐标，格式为 "X,Y"，小数点后最多6位，必填
     *  - locatetime (int)          定位时间，Unix时间戳，精确到毫秒，必填
     *  - speed (float|null)        速度，单位为km/h，小数点后最多3位，非必填
     *  - direction (float|null)    方向，取值范围[0~360]，顺时针方向，小数点后最多4位，非必填
     *  - height (float|null)       高度，单位为米，小数点后最多3位，非必填
     *  - accuracy (float|null)     定位精度，仅允许数字，小数点后最多3位，非必填
     *  - props(json)               用户自定义字段
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal#t4
     */
    static function pointUpload(int $sid, int $tid, int $trid, array $points)
    {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
            'trid' => $trid,
            'points' => json_encode($points),
        ];
        $req = new Request(
            TrackEnum::API_POINT_UPLOAD,
            TrackEnum::API_POINT_UPLOAD_METHOD,
            $params
        );
        return $req->data;
    }

}
