<?php

namespace amap\enum;

class TrackEnum
{

    const API_BASE_URL = 'https://tsapi.amap.com';

    const API_SERVICE_ADD = '/v1/track/service/add';
    const API_SERVICE_ADD_METHOD = 'POST';

    const API_SERVICE_DELETE = '/v1/track/service/delete';
    const API_SERVICE_DELETE_METHOD = 'POST';

    const API_SERVICE_UPDATE = '/v1/track/service/update';
    const API_SERVICE_UPDATE_METHOD = 'POST';

    const API_SERVICE_LIST = '/v1/track/service/list';
    const API_SERVICE_LIST_METHOD = 'GET';


    const API_TERMINAL_ADD = '/v1/track/terminal/add';
    const API_TERMINAL_ADD_METHOD = 'POST';

    const API_TERMINAL_DELETE = '/v1/track/terminal/delete';
    const API_TERMINAL_DELETE_METHOD = 'POST';

    const API_TERMINAL_UPDATE = '/v1/track/terminal/update';
    const API_TERMINAL_UPDATE_METHOD = 'POST';

    const API_TERMINAL_LIST = '/v1/track/terminal/list';
    const API_TERMINAL_LIST_METHOD = 'GET';


    const API_TERMINAL_SEARCH = '/v1/track/terminal/search';
    const API_TERMINAL_SEARCH_METHOD = 'POST';

    const API_TERMINAL_AROUNDSEARCH = '/v1/track/terminal/aroundsearch';
    const API_TERMINAL_AROUNDSEARCH_METHOD = 'POST';

    const API_TERMINAL_POLYGONSEARCH = '/v1/track/terminal/polygonsearch';
    const API_TERMINAL_POLYGONSEARCH_METHOD = 'POST';

    const API_TERMINAL_DISTRICTSEARCH = '/v1/track/terminal/districtsearch';
    const API_TERMINAL_DISTRICTSEARCH_METHOD = 'POST';


    const API_TERMINAL_LASTPOINT = '/v1/track/terminal/lastpoint';
    const API_TERMINAL_LASTPOINT_METHOD = 'GET';


    const API_TRACE_ADD = '/v1/track/trace/add';
    const API_TRACE_ADD_METHOD = 'POST';

    const API_TRACE_DELETE = '/v1/track/trace/delete';
    const API_TRACE_DELETE_METHOD = 'POST';

    const API_POINT_UPLOAD = '/v1/track/point/upload';
    const API_POINT_UPLOAD_METHOD = 'POST';


    const API_TERMINAL_TRSEARCH = '/v1/track/terminal/trsearch';
    const API_TERMINAL_TRSEARCH_METHOD = 'GET';


    const API_ANALYSIS_DRIVINGBEHAVIOR = '/v1/track/analysis/drivingbehavior';
    const API_ANALYSIS_DRIVINGBEHAVIOR_METHOD = 'GET';

    const API_ANALYSIS_STAYPOINT = '/v1/track/analysis/staypoint';
    const API_ANALYSIS_STAYPOINT_METHOD = 'GET';

}