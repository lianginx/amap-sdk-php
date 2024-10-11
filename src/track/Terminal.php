<?php

namespace amap\track;

use amap\enum\TrackEnum;
use amap\track\Request;

class Terminal
{

    /**
     * 创建终端
     * 每次调用此接口，可以在指定 Service 下创建1个终端，默认最大支持创建100000个。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal#t2
     */
    static function add(int $sid, string $name, string $desc = '', array $props = [])
    {
        $params = [
            'sid' => $sid,
            'name' => $name,
            'desc' => $desc,
        ];
        if ($props != []) {
            $params['props'] = json_encode($props);
        }
        $req = new Request(
            TrackEnum::API_TERMINAL_ADD,
            TrackEnum::API_TERMINAL_ADD_METHOD,
            $params
        );
        return $req->data;
    }

    /**
     * 删除终端
     * 用户可以通过指定 Service 的sid 与终端 id 对终端进行删除操作。开发者不可通过接口获取任何已删除终端的数据信息。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal#t3
     */
    static function delete(int $sid, int $tid)
    {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
        ];
        new Request(
            TrackEnum::API_TERMINAL_DELETE,
            TrackEnum::API_TERMINAL_DELETE_METHOD,
            $params
        );
    }

    /**
     * 修改终端
     * 希望对终端的属性进行修改调整的时候，需要调用此接口。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal#t4
     */
    static function update(int $sid, int $tid, string $name = '', string $desc = '', array $props = [])
    {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
        ];
        if ($name != '') {
            $params['name'] = $name;
        }
        if ($desc != '') {
            $params['$desc'] = $desc;
        }
        if ($props != []) {
            $params['props'] = json_encode($props);
        }
        new Request(
            TrackEnum::API_TERMINAL_UPDATE,
            TrackEnum::API_TERMINAL_UPDATE_METHOD,
            $params
        );
    }

    /**
     * 查询终端
     * 查询终端接口包含两个功能：
     * 1. 查询指定 service 中符合条件的终端及相关信息；
     * 2. 直接查询指定终端及相关信息；
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal#t5
     */
    static function query(int $sid, int $tid = null, string $name = '', int $page = 1)
    {
        $params = [
            'sid' => $sid,
            'page' => $page,
        ];
        if (!is_null($tid)) {
            $params['tid'] = $tid;
        }
        if ($name != '') {
            $params['name'] = $name;
        }
        $req = new Request(
            TrackEnum::API_TERMINAL_LIST,
            TrackEnum::API_TERMINAL_LIST_METHOD,
            $params
        );
        return $req->data;
    }


    /**
     * 关键字搜索终端
     * 根据关键字搜索设备，并返回实时位置。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal_search#关键字搜索终端
     */
    static function search(int $sid, string $keywords, string $filter = '', string $sortrule = '', int $page = 1, int $pagesize = 50)
    {
        $params = [
            'sid' => $sid,
            'keywords' => $keywords,
            'page' => $page,
            'pagesize' => $pagesize,
        ];
        if ($filter != '') {
            $params['filter'] = $filter;
        }
        if ($sortrule != '') {
            $params['sortrule'] = $sortrule;
        }
        $req = new Request(
            TrackEnum::API_TERMINAL_SEARCH,
            TrackEnum::API_TERMINAL_SEARCH_METHOD,
            $params,
        );
        return $req->data;
    }


    /**
     * 周边搜索终端
     * 根据圆心半径搜索设备，并返回实时位置。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal_search#周边搜索终端
     */
    static function aroundSearch()
    {
        throw new \Exception("暂未实现");
    }

    /**
     * 多边形区域内搜索终端
     * 根据圈定的多边形范围检索设备，并返回实时位置。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal_search#多边形区域内搜索终端
     */
    static function polygonSearch()
    {
        throw new \Exception("暂未实现");
    }

    /**
     * 行政区域内搜索终端
     * 根据行政区划关键字检索设备，并返回实时位置。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal_search#行政区域内搜索终端
     */
    static function districtSearch()
    {
        throw new \Exception("暂未实现");
    }


    /**
     * 查询终端位置
     * 通过指定服务与终端，返回该终端指定轨迹的最后位置，支持对终端最后位置的实时查询与历史查询；
     * 请注意，需要有一段正常的连续轨迹（至少5个点）才能进行终端位置查询，否则接口会报错。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/terminal_monitor
     */
    static function lastPoint(int $sid, int $tid, int $trid = null, string $correction = 'driving')
    {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
            'correction' => $correction,
        ];
        if (!is_null($trid)) {
            $params['trid'] = $trid;
        }
        $req = new Request(
            TrackEnum::API_TERMINAL_LASTPOINT,
            TrackEnum::API_TERMINAL_LASTPOINT_METHOD,
            $params,
        );
        return $req->data;
    }


    /**
     * 查询轨迹信息
     * 轨迹信息包括经纬度点，里程，时间等信息，查询策略支持如下两种方式：
     * 1. 查询某条指定轨迹：指定服务id、终端id、轨迹id，查询指定的轨迹信息，单次最多查询一条轨迹；
     * 2. 查询指定终端特定时间下的所有轨迹：指定服务id、终端id、并设置查询的时间间隔，查询该时间范围内的所有分段轨迹数据。
     * @link https://lbs.amap.com/api/track/lieying-kaifa/api/grasproad
     */
    static function trSearch(
        int $sid,
        int $tid,
        int $trid = null,
        int $starttime = null,
        int $endtime = null,
        string $correction = '',
        int $recoup = 0,
        int $gap = 500,
        int $ispoints = 1,
        int $page = 1,
        int $pagesize = 20
    ) {
        $params = [
            'sid' => $sid,
            'tid' => $tid,
            'recoup' => $recoup,
            'gap' => $gap,
            'ispoints' => $ispoints,
            'page' => $page,
            'pagesize' => $pagesize,
        ];
        if (!is_null($trid)) {
            $params['trid'] = $trid;
        }
        if (!is_null($starttime)) {
            $params['starttime'] = $starttime;
        }
        if (!is_null($endtime)) {
            $params['endtime'] = $endtime;
        }
        if ($correction != '') {
            $params['correction'] = $correction;
        }
        $req = new Request(
            TrackEnum::API_TERMINAL_TRSEARCH,
            TrackEnum::API_TERMINAL_TRSEARCH_METHOD,
            $params
        );
        return $req->data;
    }

}
