<?php
/**
 * @author: helei
 * @createTime: 2016-07-27 11:00
 * @description: 退款调试接口
 */

require_once __DIR__ . '/../autoload.php';

use Payment\Common\PayException;
use Payment\Config;
use Payment\Client\Refund;


$aliConfig = require_once __DIR__ . '/aliconfig.php';
$wxConfig = require_once __DIR__ . '/wxconfig.php';

// ali: 14887239163319   14887240631516
// wx:  14887927481312    14887931921301

$tmp = time() . rand(1000, 9999);
// ali退款
$data = [
    'out_trade_no' => '14887240631516',
    'refund_fee' => '0.01',
    'reason' => '测试帐号退款',
    'refund_no' => $tmp,
];

// wx退款
/*$data = [
    'out_trade_no' => '14887927481312',
    'total_fee' => '0.01',
    'refund_fee' => 0.01,
    'refund_no' => $tmp,
];*/
var_dump($tmp);

$channel = 'ali_refund';//xx_refund
try {
    $ret = Refund::run($channel, $aliConfig, $data);
} catch (PayException $e) {
    echo $e->errorMessage();
    exit;
}

var_dump($ret);exit;
