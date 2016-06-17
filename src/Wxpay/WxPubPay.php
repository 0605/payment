<?php
/**
 * @author: helei
 * @createTime: 2016-06-11 11:28
 * @description: 微信 APP 支付接口
 */

namespace Payment\Wxpay;



use Payment\Contracts\ChargeInterface;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;
use Payment\Utils\Curl;
use Payment\Utils\DataParser;
use Payment\Utils\StrUtil;
use Payment\Wxpay\Data\PayResultData;
use Payment\Wxpay\Helper\WxUnifiedOrder;

class WxPubPay implements ChargeInterface
{
    // 支付方式
    protected $tradeType;
    protected $config;

    public function __construct($tradeType)
    {
        $this->tradeType = $tradeType;
        $this->config = new WxConfig();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws PayException
     * @author helei
     */
    public function charges(array $data)
    {
        try {
            $unified = WxUnifiedOrder::createUnifiedData($data, $this->tradeType);
        } catch (PayException $e) {
            throw $e;
        }

        // 设置签名
        $unified->setSign();

        // 微信统一下单接口
        $url = $this->config->getGetewayUrl() . 'pay/unifiedorder';

        // 获取用于请求的xml数据
        $xml = DataParser::toXml($unified->getValues());

        // 进行curl请求
        $curl = new Curl();
        $ret = $curl->post($xml)->submit($url);

        // 格式化为数据
        $retArr = DataParser::toArray($ret['body']);
        if (! is_array($retArr)) {
            throw new PayException('微信支付数据解析错误');
        }

        // 返回结果
        return $this->handleRetData($retArr);
    }

    /**
     * @param array $data
     * @return array
     * @author helei
     */
    protected function handleRetData(array $data)
    {
        if ($data['return_code'] == 'SUCCESS' && $data['result_code'] == 'SUCCESS') {
            // 下单成功
            $payResult = new PayResultData();
            // 验证返回的结果签名
            if (! $payResult->signVerify($data)) {
                return [// 验证签名错误，说明是其他伪造
                    'type'  => 'err',
                    'data'  => [],
                ];
            }
            // 对返回结果签名，生成后，返回客户端
            $payResult->setPrepayId($data['prepay_id']);
            $payResult->setNonceStr(StrUtil::getNonceStr());
            $payResult->setTimestamp((string)time());
            $payResult->setSign();

            return [
                'type'  => 'succ',
                'data'  => $payResult->getValues(),
            ];
        }

        return [
            'type'  => 'err',
            'data'  => $data['return_msg'],
        ];
    }
}