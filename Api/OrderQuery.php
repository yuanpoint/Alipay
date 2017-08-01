<?php
/**
*查询转账订单接口
*/
namespace Alipay\Api;

use Alipay\Api;

class OrderQuery extends Common{

	public $out_biz_no;//商户转账唯一订单号：发起转账来源方定义的转账单据ID。 和支付宝转账单据号不能同时为空。当和支付宝转账单据号同时提供时，将用支付宝转账单据号进行查询，忽略本参数
	public $order_id;//支付宝转账单据号：和商户转账唯一订单号不能同时为空。当和商户转账唯一订单号同时提供时，将用本参数进行查询，忽略商户转账唯一订单号。

	public $request_url = 'https://openapi.alipay.com/gateway.do';//接口请求地址
	
	public function Request(){
		//构建请求公共参数
		$params = $this->common_content();
		//构建请求业务参数
		$params['biz_content']=$this->biz_content();
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
			'method'=>'alipay.fund.trans.order.query',
			'format'=>$this->format,
			'charset'=>$this->charset,
			'sign_type'=>$this->sign_type,
			'timestamp'=>$this->timestamp,
			'version'=>$this->version
		);
		return $params;
	}
	/**
	*构建请求业务参数
	*/
	public function biz_content(){
		$params = array(
			'out_biz_no'=>$this->out_biz_no,
			'order_id'=>$this->order_id
		);
		//如果为空，则去掉这个字段
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