<?php
/**
 * @author: helei
 * @createTime: 2016-06-14 16:41
 * @description:
 */

require_once __DIR__ . '/../autoload.php';

use Payment\Factory\ChargeFactory;
use Payment\Common\ChargeChannel;
use Payment\Common\PayException;

// 微信APP支付实例
$appCharge = ChargeFactory::getInstance(ChargeChannel::CHANNEL_IS_WX);

$payData = [
    "order_no"	=> 'F2016dd6dd1a23',// 必须， 商户订单号，适配每个渠道对此参数的要求，必须在商户系统内唯一
    "amount"	=> '1',// 订单总金额, 人民币为元
    "subject"	=> '测试即时到帐接口',// 必须， 商品的标题，该参数最长为 32 个 Unicode 字符
    "body"	=> '即时到帐接口，就是爱支付',// 必须， 商品的描述信息
    "client_ip"	=> '127.0.0.1',//  可选， 发起支付请求客户端的 IP 地址，格式为 IPV4
    "success_url"	=> 'http://mall.tys.tiyushe.net/pay-test/notify.html',// 必须， 支付成功的回调地址  统一使用异步通知  该url后，不能带任何参数。
    "time_expire"	=> '15',// 可选， 订单失效时间，单位是 分钟
    "description"	=> '这是附带的业务数据',//  可选，如果用户请求时传递了该参数，则返回给商户时会回传该参数
];

try {
    $reqArr = $appCharge->charges($data);// 调用该函数，会抛出  PayException 异常
    var_dump($reqArr);
} catch (PayException $e) {
    echo $e->errorMessage();
}