<?php
/**
*支付类
*/
namespace Alipay\Api;
use Alipay\Api;
class Pay extends Common{

	public $body;//商品描述

	public $subject;//商品的标题/交易标题/订单标题/订单关键字等。

	public $out_trade_no;//商户网站唯一订单号

	public $timeout_express = '30m';//设置未付款支付宝交易的超时时间，一旦超时，该笔交易就会自动被关闭。当用户进入支付宝收银台页面（不包括登录页面），会触发即刻创建支付宝交易，此时开始计时。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。

	public $total_amount;//订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]

	public $seller_id;//收款支付宝用户ID。 如果该值为空，则默认为商户签约账号对应的支付宝用户ID

	public $product_code = 'QUICK_MSECURITY_PAY';//销售产品码，商家和支付宝签约的产品码，为固定值QUICK_MSECURITY_PAY

	public $goods_type;//商品主类型：0—虚拟类商品，1—实物类商品;注：虚拟类商品不支持使用花呗渠道

	public $passback_params;//公用回传参数，如果请求时传递了该参数，则返回给商户时会回传该参数。支付宝会在异步通知时将该参数原样返回。本参数必须进行UrlEncode之后才可以发送给支付宝

	public $promo_params;//优惠参数;注：仅与支付宝协商后可用

	public $extend_params;//业务扩展参数，详见下面的“业务扩展参数说明”

	public $enable_pay_channels;//可用渠道，用户只能在指定渠道范围内支付当有多个渠道时用“,”分隔注：与disable_pay_channels互斥

	public $disable_pay_channels;//禁用渠道，用户不可用指定渠道支付当有多个渠道时用“,”分隔注：与enable_pay_channels互斥

	public $store_id;//商户门店编号。该参数用于请求参数中以区分各门店，非必传项。

	##########################################业务扩展参数###############################################

	public $sys_service_provider_id;//系统商编号，该参数作为系统商返佣数据提取的依据，请填写系统商签约协议的PID

	public $needBuyerRealnamed;//是否发起实名校验T：发起;F：不发起

	public $TRANS_MEMO;//账务备注;注：该字段显示在离线账单的账务备注中

	public $hb_fq_num;//花呗分期数（目前仅支持3、6、12）;注：使用该参数需要仔细阅读“花呗分期接入文档”

	public $hb_fq_seller_percent;//卖家承担收费比例，商家承担手续费传入100，用户承担手续费传入0，仅支持传入100、0两种，其他比例暂不支持;注：使用该参数需要仔细阅读“花呗分期接入文档”

	public function Request(){
		//构建请求数组
		$params = $this->common_content();

		//获取业务参数
		$params['biz_content']=$this->get_bizContent();

		//拼接字符串
		$string = $this->getSignContent($params);
		//获取签名
		$params['sign'] = $this->Sign($string);

		//返回数据
		return http_build_query($params);

	}
	/**
	*获取支付成功的回调地址
	*/
	public function get_notifyUrl(){
		$str = '';
		if($this->notify_url!='' || $this->notify_url!=NULL){
			$str = $this->notify_url;
		}elseif(NOTIFY_URL!='' || NOTIFY_URL!=NULL){
			$str = NOTIFY_URL;
		}else{

			$this->errorMessage("回调地址不能为空");
		}
		return $str;
	}
	/**
	*构建公共参数
	*/
	public function common_content(){
		$params = array(
			'app_id'=>$this->get_appid(),
			'method'=>'alipay.trade.app.pay',
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
	public function get_bizContent(){
		$params = array(
			'body'=>$this->body,
			'subject'=>$this->subject,
			'out_trade_no'=>$this->out_trade_no,
			'timeout_express'=>$this->timeout_express,
			'total_amount'=>$this->get_totalAmount(),
			'seller_id'=>$this->seller_id,
			'product_code'=>$this->product_code,
			'goods_type'=>$this->goods_type,
			'passback_params'=>$this->passback_params,
			'promo_params'=>$this->promo_params,
			'enable_pay_channels'=>$this->enable_pay_channels,
			'disable_pay_channels'=>$this->disable_pay_channels,
			'store_id'=>$this->store_id
		);
		//将数组空值去掉之后从新排序
		foreach ($params as $key => $value) {
			if($value=='' || $value==NULL){
				unset($params[$key]);
			}
		}
		//加载扩展参数
		$extendParams = $this->extend_params;
		if(!is_array($extendParams)){
			$params['extend_params']=$extendParams;
		}else{
			 if(count($extend_params)>0){
		    	$extendParams = json_encode($extendParams);
		    	$params['extend_params']=$extendParams;
		    }
		}
		//将数组转换为json
		$params = json_encode($params);

		return $params;
	}
	/**
	*构建业务扩展参数
	*/
	public function extension_content(){
		if($this->extend_params!='' || $this->extend_params!=NULL){
			return $this->extend_params;
		}
		//构建参数数组
		$params = array(
			'sys_service_provider_id'=>$this->sys_service_provider_id,
			'needBuyerRealnamed'=>$this->needBuyerRealnamed,
			'TRANS_MEMO'=>$this->TRANS_MEMO,
			'hb_fq_num'=>$this->$hb_fq_num,
			'hb_fq_seller_percent'=>$this->hb_fq_seller_percent
		);
		//将数组空值去掉之后从新排序
		foreach ($params as $key => $value) {
			if($value=='' || $value==NULL){
				unset($params[$key]);
			}
		}
		return $params;
	}
	/**
	*对金额做验证
	*/
	public function get_totalAmount(){

		if($this->total_amount=='' || $this->total_amount==NULL){

			$this->errorMessage("金额不能为空");
		}else{

			return $this->total_amount;
		}
	}

}







?>