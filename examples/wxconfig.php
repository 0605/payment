<?php
/**
 * @author: helei
 * @createTime: 2016-08-01 11:37
 * @description: 微信配置文件
 */

return [
    'use_sandbox'       => true,// 是否使用 微信支付仿真测试系统

    'app_id'            => 'wx69a0839ab45806f0',  // 公众账号ID
    'mch_id'            => '1321535701',// 商户id
    'md5_key'           => 'yxpt1234567891234567891234567890',// md5 秘钥
    'app_cert_pem'      => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'wx' . DIRECTORY_SEPARATOR . 'apiclient_cert.pem',
    'app_key_pem'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'wx' . DIRECTORY_SEPARATOR . 'apiclient_key.pem',
    'sign_type'         => 'MD5',// MD5  HMAC-SHA256
    'limit_pay'         => [
        //'no_credit',
    ],// 指定不能使用信用卡支付   不传入，则均可使用
    'fee_type'          => 'CNY',// 货币类型  当前仅支持该字段

    'notify_url'        => 'https://helei112g.github.io/v1/notify/wx',

    'redirect_url'      => 'https://helei112g.github.io/',// 如果是h5支付，可以设置该值，返回到指定页面

    'return_raw'        => true,// 在处理回调时，是否直接返回原始数据，默认为true
];