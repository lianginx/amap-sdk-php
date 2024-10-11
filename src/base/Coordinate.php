<?php

namespace amap\base;

use amap\enum\BaseEnum;

class Coordinate
{

    /**
     * 坐标转换
     * 将用户输入的非高德坐标（GPS 坐标、mapbar 坐标、baidu 坐标）转换成高德坐标
     * @link https://lbs.amap.com/api/webservice/guide/api/convert#t4
     */
    static function convert(
        string $locations,
        string $coordsys = 'autonavi',
        string $sig = '',
        string $output = 'JSON'
    ) {
        $params = [
            'locations' => $locations,
            'coordsys' => $coordsys,
            'output' => $output,
        ];
        if ($sig != '') {
            $params['city'] = $sig;
        }
        $req = new Request(
            BaseEnum::API_ASSISTANT_COORDINATE_CONVERT,
            BaseEnum::API_ASSISTANT_COORDINATE_CONVERT_METHOD,
            $params,
        );
        return $req->data;
    }

}
