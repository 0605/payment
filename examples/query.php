<?php
/**
 * @author: helei
 * @createTime: 2016-07-28 17:28
 * @description: 交易状态查询
 */

require_once __DIR__ . '/../autoload.php';

$aliconfig = require_once __DIR__ . '/aliconfig.php';

$wxconfig = require_once __DIR__ . '/wxconfig.php';

use Payment\QueryContext;
use Payment\Common\PayException;
use Payment\Config;

$query = new QueryContext();

// 通过支付宝交易号查询，  推荐
$data = [
    //'transaction_id'    => '2016011421001004330041239366',// 支付宝
    'transaction_id'    => '1007570439201601142692427764',// 微信
];

// 通过订单号查询
/*$data = [
    'order_no'    => '2016011402433464',// 支付宝
    'order_no'  => '2016011402010664',// 微信
];*/

try {
    // 支付宝查询
    //$query->initQuery(Config::ALI, $aliconfig);

    // 微信查询
    $query->initQuery(Config::WEIXIN, $wxconfig);

    $ret = $query->query($data);

} catch (PayException $e) {
    echo $e->errorMessage();exit;
}

var_dump($ret);