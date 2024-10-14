<?php

namespace amap\track;

use amap\enum\TrackEnum;
use amap\track\Request;

class Service
{

    static function add(string $name, string $desc = '')
    {
        $req = new Request(
            TrackEnum::API_SERVICE_ADD,
            TrackEnum::API_SERVICE_ADD_METHOD,
            [
                'name' => $name,
                'desc' => $desc,
            ],
        );
        return $req->data;
    }

    static function delete(int $sid)
    {
        new Request(
            TrackEnum::API_SERVICE_DELETE,
            TrackEnum::API_SERVICE_DELETE_METHOD,
            [
                'sid' => $sid,
            ],
        );
    }

    static function update(int $sid, string $name = '', string $desc = '')
    {
        $params = ['sid' => $sid];
        if ($name !== '') {
            $params['name'] = $name;
        }
        if ($desc !== '') {
            $params['desc'] = $desc;
        }
        $req = new Request(
            TrackEnum::API_SERVICE_UPDATE,
            TrackEnum::API_SERVICE_UPDATE_METHOD,
            $params,
        );
        return $req->data;
    }

    static function all()
    {
        $req = new Request(
            TrackEnum::API_SERVICE_LIST,
            TrackEnum::API_SERVICE_LIST_METHOD,
        );
        return $req->data['results'] ?? [];
    }

}
