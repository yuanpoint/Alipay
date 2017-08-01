<?php
/**
*统一收单交易退款查询
*/
namespace Alipay\Api;

use Alipay\Api;

class QueryRefund extends Common{

	public $trade_no;//支付宝交易号

	public $out_trade_no;//商家订单号

	public $out_request_no;//退款请求号

	public $request_url = 'https://openapi.alipay.com/gateway.do';//请求地址

	public function Request(){
		//构建公共参数
		$params = $this->common_content();
		//构建业务参数
		$params['biz_content']=$this->bizContent();

		//排序字符串
		$string = $this->getSignContent($params);

		//获取签名
		$params['sign']=$this->Sign($string);

		//对请求数据进行http
		$resquestString = http_build_query($params);

		return $this->postCurl($params,$this->request_url);
	}

	/**
	*构建公共参数
	*/
	public function common_content(){
		$params = array(
			'app_id'=>$this->get_appid(),
			'method'=>'alipay.trade.fastpay.refund.query',
			'format'=>$this->format,
			'charset'=>$this->charset,
			'sign_type'=>$this->sign_type,
			'timestamp'=>$this->timestamp,
			'version'=>$this->version
		);

		return $params;
	}
	/**
	*业务参数
	*/
	public function bizContent(){
		$params = array(
			'trade_no'=>$this->trade_no,
			'out_trade_no'=>$this->out_trade_no,
			'out_request_no'=>$this->out_request_no
		);
		//去除空值
		foreach ($params as $key => $value) {
			if($value=='' || $value==NULL){
				unset($params[$key]);
			}
		}
		return json_encode($params);
	}
}

















?>