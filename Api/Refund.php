<?php
/**
*退款接口
*/
namespace Alipay\Api;
use Alipay\Api;
class Refund extends Common{
	
	public $out_trade_no;//商户订单号，不能和trade_no同时为空

	public $trade_no;//支付宝交易号

	public $refund_amount;//需要退款的金额，该金额不能大于订单金额，单位为元，支持两位小数

	public $refund_reason;//退款的原因说明

	public $out_request_no;//标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则必传

	public $operator_id;//商户的操作员编号

	public $store_id;//商户的门店编号

	public $terminal_id;//商户的终端编号

	public $request_url = 'https://openapi.alipay.com/gateway.do';

	//请求
	public function Request(){

		//构建请求公共参数
		$params = $this->common_content();
		//构建业务参数
		$params['biz_content']=$this->bizContent();
		//排序字符串
		$string = $this->getSignContent($params);

		//获取签名
		$params['sign']=$this->Sign($string);
 
		$requestString = http_build_query($params);

		//进行请求
		return $this->postCurl($requestString,$this->request_url);
	}

	/**
	*构建公共参数
	*/
	public function common_content(){
		$params = array(
			'app_id'=>$this->get_appid(),
			'method'=>'alipay.trade.refund',
			'format'=>$this->format,
			'charset'=>$this->charset,
			'sign_type'=>$this->sign_type,
			'timestamp'=>$this->timestamp,
			'version'=>$this->version
		);

		return $params;
	}
	/**
	*构建请求参数
	*/
	public function bizContent(){
		$params = array(
			'out_trade_no'=>$this->out_trade_no,
			'trade_no'=>$this->trade_no,
			'refund_amount'=>$this->refund_amount,
			'refund_reason'=>$this->refund_reason,
			'out_request_no'=>$this->out_request_no,
			'operator_id'=>$this->operator_id,
			'store_id'=>$this->store_id,
			'terminal_id'=>$this->terminal_id
		);
		//如果key为空，则删掉key和value
		foreach ($params as $key => $value) {
			if($value=='' || $value==NULL){
				unset($params[$key]);
			}
		}
		//返回json结果
		return json_encode($params);
	}
	
}










?>