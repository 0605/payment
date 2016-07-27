<?php
/**
 * @author: helei
 * @createTime: 2016-07-15 17:10
 * @description: 支付宝支付接口的基类。
 * @link      https://github.com/helei112g/payment/tree/paymentv2
 * @link      https://helei112g.github.io/
 */

namespace Payment\Charge\Ali;


use Payment\Charge\ChargeStrategy;
use Payment\Common\Ali\Data\Charge\ChargeBaseData;
use Payment\Common\AliConfig;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;

abstract class AliCharge implements ChargeStrategy
{
    /**
     * 支付宝的配置文件
     * @var AliConfig $config
     */
    protected $config;

    /**
     * 支付数据
     * @var ChargeBaseData $chargeData
     */
    protected $chargeData;

    /**
     * AliCharge constructor.
     * @param array $config
     * @throws PayException
     */
    public function __construct(array $config)
    {
        /* 设置内部字符编码为 UTF-8 */
        mb_internal_encoding("UTF-8");

        try {
            $this->config = new AliConfig($config);
        } catch (PayException $e) {
            throw $e;
        }
    }

    /**
     * 获取支付对应的数据完成类
     * @return ChargeBaseData
     * @author helei
     */
    abstract protected function getChargeDataClass();

    /**
     * 支付的业务逻辑
     * @param array $data
     * @return array|string
     * @throws PayException
     * @author helei
     */
    public function charge(array $data)
    {
        $chargeClass = $this->getChargeDataClass();

        try {
            $this->chargeData = new $chargeClass($this->config, $data);
        } catch (PayException $e) {
            throw $e;
        }

        $this->chargeData->setSign();

        $data = $this->chargeData->getData();
        if ('Payment\Charge\Ali\AliAppCharge' == get_called_class()) {
            // 如果是移动支付，直接返回数据信息。并且对sign做urlencode编码
            $data['sign'] = urlencode($data['sign']);
            return ArrayUtil::createLinkstring($data);
        }

        $retData = $this->config->getewayUrl . http_build_query($data);
        return $retData;
    }
}