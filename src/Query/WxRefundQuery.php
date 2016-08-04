<?php
/**
 * @author: helei
 * @createTime: 2016-08-02 17:55
 * @description:
 */

namespace Payment\Query;


use Payment\Common\WxConfig;


/**
 *
 * 微信退款订单查询
 * Class WxRefudnQuery
 * @package Payment\Query
 * anthor helei
 */
class WxRefundQuery extends WxTradeQuery
{
    protected function getReqUrl()
    {
        return WxConfig::REFUDN_QUERY_URL;// 查询退款url
    }
}