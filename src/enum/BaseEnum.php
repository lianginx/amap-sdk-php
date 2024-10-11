<?php

namespace amap\enum;

class BaseEnum
{
    const API_BASE_URL = 'https://restapi.amap.com';

    const API_GEOCODE_GEO = '/v3/geocode/geo';
    const API_GEOCODE_GEO_METHOD = 'GET';

    const API_GEOCODE_REGEO = '/v3/geocode/regeo';
    const API_GEOCODE_REGEO_METHOD = 'GET';

    const API_ASSISTANT_COORDINATE_CONVERT = '/v3/assistant/coordinate/convert';
    const API_ASSISTANT_COORDINATE_CONVERT_METHOD = 'GET';

}