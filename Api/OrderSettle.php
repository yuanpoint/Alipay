<?php
/**
*统一收单交易结算接口
*/
namespace Alipay\Api;
use Alipay\Api;

class OrderSettle extends Common{

	public $out_request_no;//订单号

	public $trade_no;//支付宝交易号

	public $royalty_parameters;//分账明细信息

	public $trans_out;

	public $trans_in;

	public $amount;

	public $amount_percentage;

	public $desc;

	public $operator_id;

}
















?>