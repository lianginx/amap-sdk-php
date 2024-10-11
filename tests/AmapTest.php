<?php

use PHPUnit\Framework\TestCase;
use amap\track\{
    Service,
    Terminal,
    Trace,
};
use amap\base\{
    Geocode,
};

class AmapTest extends TestCase
{

    function testTrackService()
    {
        $test_name = 'test';
        $test_desc = 'test_desc';
        $next_name = "{$test_name}_update";

        try {

            // 创建
            $addResult = Service::add($test_name, $test_desc);
            self::assertIsArray($addResult);
            self::assertIsInt($addResult['sid']);
            self::assertEquals($test_name, $addResult['name']);

            // 修改
            $updateResult = Service::update($addResult['sid'], $next_name);
            self::assertIsArray($updateResult);
            self::assertEquals($next_name, $updateResult['name']);

            // 查询
            $allResult = Service::all();
            self::assertIsArray($allResult);
            self::assertNotCount(0, array_filter(
                $allResult,
                function ($item) use ($next_name, $test_desc) {
                    return $item['name'] == $next_name && $item['desc'] == $test_desc;
                }
            ));

        } finally {

            // 删除
            Service::delete($addResult['sid']);

        }
    }


    function testTrackTerminal()
    {
        $test_name = 'test';
        $test_desc = 'test_desc';
        $next_name = "{$test_name}_update";

        try {

            // 创建服务
            $addServiceResult = Service::add($test_name, $test_desc);

            // 创建终端
            $addTerminalResult = Terminal::add($addServiceResult['sid'], $test_name, $test_desc);
            self::assertIsArray($addTerminalResult);
            self::assertIsInt($addTerminalResult['sid']);
            self::assertEquals($test_name, $addTerminalResult['name']);

            // 更新终端
            Terminal::update($addServiceResult['sid'], $addTerminalResult['tid'], $next_name);

            // 查询终端
            $queryTerminalResult = Terminal::query($addServiceResult['sid']);
            self::assertIsArray($queryTerminalResult);
            self::assertIsInt($queryTerminalResult['count']);
            self::assertGreaterThanOrEqual(1, $queryTerminalResult['count']);
            self::assertNotCount(
                0,
                array_filter($queryTerminalResult['results'], function ($item) use ($next_name, $test_desc) {
                    return $item['name'] === $next_name && $item['desc'] === $test_desc;
                })
            );

            // 查询指定终端
            $queryTerminalResult = Terminal::query($addServiceResult['sid'], $addTerminalResult['tid']);
            self::assertIsArray($queryTerminalResult);
            self::assertIsInt($queryTerminalResult['count']);
            self::assertEquals(1, $queryTerminalResult['count']);
            self::assertCount(1, $queryTerminalResult['results']);
            self::assertEquals($next_name, $queryTerminalResult['results'][0]['name']);
            self::assertEquals($test_desc, $queryTerminalResult['results'][0]['desc']);

        } finally {

            // 删除服务
            Service::delete($addServiceResult['sid']);

        }
    }

    function testTrackTerminalSearch()
    {

        $test_name = 'test';
        $test_desc = 'test_desc';
        $terminal_name_list = array_map(
            function ($i) {
                return "test_$i";
            },
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        );

        try {

            // 创建服务
            $service = Service::add($test_name, $test_desc);

            // 创建终端
            $terminal_list = [];
            foreach ($terminal_name_list as $name) {
                $terminal_list[] = Terminal::add($service['sid'], $name);
            }

            // 搜索 1
            $search1 = Terminal::search($service['sid'], 'test_');
            self::assertEquals(10, $search1['count']);

            // 搜索 2
            $search2 = Terminal::search($service['sid'], 'test_1');
            self::assertEquals(2, $search2['count']);

            // 搜索 3
            $search3 = Terminal::search($service['sid'], 'test_2');
            self::assertEquals(1, $search3);

            // 搜索 4
            $search4 = Terminal::search($service['sid'], 'test_1', 'name=test_1');
            self::assertEquals(1, $search4['count']);

            // 搜索 5
            $search5 = Terminal::search($service['sid'], 'test_', '', 'sortrule=name:desc');
            self::assertEquals(10, $search1['count']);
            self::assertEquals('test_10', $search4['results'][0]['name']);
            self::assertEquals('test_1', $search4['results'][9]['name']);
            self::assertEquals('test_5', $search4['results'][4]['name']);

            // 搜索 6
            $search5 = Terminal::search($service['sid'], 'test_', '', '', 2, 6);
            self::assertEquals(10, $search1['count']);
            self::assertCount(4, $search4['results']);

        } catch (\Throwable $th) {
            // 删除服务
            Service::delete($service['sid']);
        }
    }


    function testTrackTrace()
    {
        $test_name = 'test';
        $test_desc = 'test_desc';
        $next_name = "{$test_name}_update";

        try {

            // 创建服务
            $service = Service::add($test_name, $test_desc);

            // 创建终端
            $terminal = Terminal::add($service['sid'], $test_name, $test_desc);

            // 创建命名轨迹
            $trace_1 = Trace::add($service['sid'], $terminal['tid'], $test_name);
            self::assertIsArray($trace_1);
            self::assertIsInt($trace_1['trid']);
            self::assertEquals($test_name, $trace_1['trname']);

            // 创建随机名称轨迹
            $trace_2 = Trace::add($service['sid'], $terminal['tid']);
            self::assertIsArray($trace_2);
            self::assertIsInt($trace_2['trid']);

            // 构建轨迹点
            $points = [
                [
                    'location' => '117.132923,31.830193',
                    'locatetime' => 1728461323000,
                    'speed' => 0.796,
                ],
                [
                    'location' => '117.132923,31.830193',
                    'locatetime' => 1728461320000,
                    'speed' => 0.074,
                ],
                [
                    'location' => '117.132928,31.830193',
                    'locatetime' => 1728461316000,
                    'speed' => 0.074,
                ],
                [
                    'location' => '117.132935,31.830190',
                    'locatetime' => 1728461307000,
                    'speed' => 0.074,
                ],
                [
                    'location' => '117.132935,31.830190',
                    'locatetime' => 1728461299000,
                    'speed' => 0.407,
                ],
                [
                    'location' => '117.132937,31.830190',
                    'locatetime' => 1728461295000,
                    'speed' => 0.222,
                ],
                [
                    'location' => '117.132937,31.830190',
                    'locatetime' => 1728461291000,
                    'speed' => 0.241,
                ],
                [
                    'location' => '117.132937,31.830190',
                    'locatetime' => 1728461287000,
                    'speed' => 0.278,
                ],
                [
                    'location' => '117.132935,31.830190',
                    'locatetime' => 1728461283000,
                    'speed' => 0.500,
                ],
                [
                    'location' => '117.132937,31.830188',
                    'locatetime' => 1728461275000,
                    'speed' => 0.222,
                ],
                [
                    'location' => '117.132937,31.830188',
                    'locatetime' => 1728461271000,
                    'speed' => 0.111,
                ],
                [
                    'location' => '117.132937,31.830188',
                    'locatetime' => 1728461267000,
                    'speed' => 0.074,
                ],
                [
                    'location' => '117.132937,31.830188',
                    'locatetime' => 1728461263000,
                    'speed' => 0.074,
                ],
                [
                    'location' => '117.132937,31.830188',
                    'locatetime' => 1728461259000,
                    'speed' => 0.167,
                ],
                [
                    'location' => '117.132935,31.830188',
                    'locatetime' => 1728461251000,
                    'speed' => 0.111,
                ],
                [
                    'location' => '117.132935,31.830188',
                    'locatetime' => 1728461247000,
                    'speed' => 0.389,
                ],
                [
                    'location' => '117.132933,31.830190',
                    'locatetime' => 1728461243000,
                    'speed' => 0.296,
                ],
                [
                    'location' => '117.132933,31.830190',
                    'locatetime' => 1728461240000,
                    'speed' => 0.389,
                ],
                [
                    'location' => '117.132930,31.830188',
                    'locatetime' => 1728461232000,
                    'speed' => 0.537,
                ],
                [
                    'location' => '117.132928,31.830188',
                    'locatetime' => 1728461228000,
                    'speed' => 0.074,
                ]
            ];

            // 批量点上传轨迹点
            $upload_result = Trace::pointUpload($service['sid'], $terminal['tid'], $trace_1['trid'], $points);
            self::assertIsArray($upload_result);

            // 查询轨迹信息
            $trSearch = Terminal::trSearch($service['sid'], $terminal['tid'], $trace_1['trid']);
            self::assertEquals(1, $trSearch['counts']);
            self::assertEquals(11, $trSearch['tracks'][0]['counts']);

            // 删除轨迹
            Trace::delete($service['sid'], $terminal['tid'], $trace_2['trid']);

            // 驾驶行为分析
            // $drivingBehavior = Analysis::drivingBehavior($service['sid'], $terminal['tid'], $trace_1['trid']);
            // self::assertIsArray($drivingBehavior);

            // 停留点分析
            // $stayPoint = Analysis::stayPoint($service['sid'], $terminal['tid'], $trace_1['trid']);
            // self::assertIsArray($stayPoint);
            // self::assertNotCount(0, $stayPoint);

        } finally {

            // 删除服务
            Service::delete($service['sid']);

        }
    }


    function testGeocodeGeo()
    {
        $result = Geocode::geo('中国江苏省苏州市昆山市花桥镇绿地杰座');
        self::assertIsArray($result);
        self::assertIsArray($result['geocodes']);
        self::assertEquals(1, $result['status']);
        self::assertEquals('中国', $result['geocodes'][0]['country']);
        self::assertEquals('苏州市', $result['geocodes'][0]['city']);
        self::assertEquals('320583', $result['geocodes'][0]['adcode']);
    }

    function testGeocodeReGeo()
    {
        $result = Geocode::reGeo('121.130196,31.284001');
        self::assertIsArray($result);
        self::assertIsArray($result['regeocode']);
        self::assertEquals(1, $result['status']);
    }


}