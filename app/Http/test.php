<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/7/18
 * Time: 下午3:38
 */
Route::any('time', function (){
    $nowTime = time();
    $yesterdayStartTime = (date('Y-m-d', strtotime('-1 day')).' 00:00:00');
    $yesterdayEndTime = (date('Y-m-d', strtotime('-1 day')).' 23:59:59');
    $tomorrowStartTime = (date('Y-m-d',strtotime('+1 day')).' 00:00:00');
    $tomorrowEndTime = (date('Y-m-d',strtotime('+1 day')).' 23:59:59');

    $dayToDataList = [];
    $getTimeInterval = function ($day){
        return [
            strtotime(date('Y-m-d', strtotime($day.' day')).' 00:00:00'),
            strtotime(date('Y-m-d', strtotime($day.' day')).' 23:59:59'),
        ];
    };
    $dayToDataList['0'] = $getTimeInterval(0);
    $dayToDataList['-6'] = $getTimeInterval(-6);
    $dayToDataList['-2'] = $getTimeInterval(-2);
    $dayToDataList['-1'] = $getTimeInterval(-1);
    dd($dayToDataList);
});