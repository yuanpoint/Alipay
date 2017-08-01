<?php
/**
*统一收单线下交易查询
*/
namespace Alipay\Api;

use Alipay\Api;

class TradeQuery extends Common{

	public $out_trade_no;//商户订单号

	public $trade_no;//支付宝交易号

	public $request_url = 'https://openapi.alipay.com/gateway.do';//请求接口地址

	public function Request(){
		//构建公共参数
		$params = $this->common_content();

		//构建业务参数
		$params['biz_content']=$this->biz_content();

		//排序字符串
		$string = $this->getSignContent($params);

		//生成签名
		$params['sign']=$this->Sign($string);

		//格式化请求参数
		$requestData = http_build_query($params);

		//请求
		return $this->postCurl($requestData,$this->request_url);
	}

	/**
	*构建公共参数
	*/
	public function common_content(){
		$params = array(
			'app_id'=>$this->get_appid(),
			'method'=>'alipay.trade.query',
			'format'=>$this->format,
			'charset'=>$this->charset,
			'sign_type'=>$this->sign_type,
			'timestamp'=>$this->timestamp,
			'version'=>$this->version,
			'notify_url'=>$this->get_notifyUrl()	
		);
		return $params;
	}
	/**
	*构建业务参数
	*/
	public function biz_content(){
		$params = array(
			'out_trade_no'=>$this->out_trade_no,
			'trade_no'=>$this->trade_no
		);
		//参数去空
		foreach ($params as $key => $value) {
			if($value=='' || $value==NULL){
				unset($params[$key]);
			}
		}
		//返回json数据
		return json_encode($params);
	}
}















?>