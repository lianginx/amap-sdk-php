<?php

namespace amap\base;

use amap\enum\BaseEnum;

class Geocode
{

    /**
     * 地理编码
     * @link https://lbs.amap.com/api/webservice/guide/api/georegeo#t4
     */
    static function geo(
        string $address,
        string $city = '',
        string $sig = '',
        string $output = 'JSON',
        string $callback = ''
    ) {
        $params = [
            'address' => $address,
            'output' => $output,
        ];
        if ($city != '') {
            $params['city'] = $city;
        }
        if ($sig != '') {
            $params['sig'] = $sig;
        }
        if ($callback != '') {
            $params['callback'] = $callback;
        }
        $req = new Request(
            BaseEnum::API_GEOCODE_GEO,
            BaseEnum::API_GEOCODE_GEO_METHOD,
            $params,
        );
        return $req->data;
    }

    /**
     * 逆地理编码
     * @link https://lbs.amap.com/api/webservice/guide/api/georegeo#t5
     */
    static function reGeo(
        string $location,
        string $poitype = '',
        int $radius = 1000,
        string $extensions = 'base',
        int $roadlevel = null,
        string $sig = '',
        string $output = 'JSON',
        string $callback = '',
        int $homeorcorp = 0
    ) {
        $params = [
            'location' => $location,
            'radius' => $radius,
            'extensions' => $extensions,
            'output' => $output,
            'homeorcorp' => $homeorcorp,
        ];
        if ($poitype != '') {
            $params['poitype'] = $poitype;
        }
        if (!is_null($roadlevel)) {
            $params['roadlevel'] = $roadlevel;
        }
        if ($sig != '') {
            $params['sig'] = $sig;
        }
        if ($callback != '') {
            $params['callback'] = $callback;
        }
        $req = new Request(
            BaseEnum::API_GEOCODE_REGEO,
            BaseEnum::API_GEOCODE_REGEO_METHOD,
            $params,
        );
        return $req->data;
    }

}
