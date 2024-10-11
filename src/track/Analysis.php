<?php

namespace amp\track;

use amap\enum\TrackEnum;
use amap\track\Request;

class Analysis
{

    /**
     * 驾驶行为分析
     * 急加速、急减速（刹车）、急转弯、超速行为
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/track_analysis#t1
     */
    static function drivingBehavior(
        int $sid,
        int $tid,
        string $trid,
        int $starttime = null,
        int $endtime = null,
        int $accelerationThres = null,
        int $decelerationThres = null,
        int $steeringThres = null,
        int $speedLimitThres = null
    ) {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
            'trid' => $trid,
        ];
        if (!is_null($starttime)) {
            $params['starttime'] = $starttime;
        }
        if (!is_null($endtime)) {
            $params['endtime'] = $endtime;
        }
        if (!is_null($accelerationThres)) {
            $params['accelerationThres'] = $accelerationThres;
        }
        if (!is_null($decelerationThres)) {
            $params['decelerationThres'] = $decelerationThres;
        }
        if (!is_null($steeringThres)) {
            $params['steeringThres'] = $steeringThres;
        }
        if (!is_null($speedLimitThres)) {
            $params['speedLimitThres'] = $speedLimitThres;
        }
        $req = new Request(
            TrackEnum::API_ANALYSIS_DRIVINGBEHAVIOR,
            TrackEnum::API_ANALYSIS_DRIVINGBEHAVIOR_METHOD,
            $params,
        );
        return $req->data;
    }

    /**
     * 停留点分析
     * 停留次数、停留坐标、停留点地址描述、停留起始时间、停留时长
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/track_analysis#t2
     */
    static function stayPoint(
        int $sid,
        int $tid,
        int $trid,
        int $starttime = null,
        int $endtime = null,
        int $stayRadius = 20,
        int $stayTime = 600,
        string $mode = 'driving'
    ) {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
            'trid' => $trid,
            'stayRadius' => $stayRadius,
            'stayTime' => $stayTime,
            'mode' => $mode,
        ];
        if (!is_null($starttime)) {
            $params['starttime'] = $starttime;
        }
        if (!is_null($endtime)) {
            $params['endtime'] = $endtime;
        }
        $req = new Request(
            TrackEnum::API_ANALYSIS_STAYPOINT,
            TrackEnum::API_ANALYSIS_STAYPOINT_METHOD,
            $params,
        );
        return $req->data;
    }

}
