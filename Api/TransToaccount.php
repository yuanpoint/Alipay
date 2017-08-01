<?php
/**
*单笔转账到支付宝账户接口
*/
namespace Alipay\Api;
use Alipay\Api;

class TransToaccount extends Common{

	public $out_biz_no;//商户转账唯一订单号

	public $payee_type ='ALIPAY_LOGONID';//收款方账户类型。可取值： 1、ALIPAY_USERID：支付宝账号对应的支付宝唯一用户号。以2088开头的16位纯数字组成。 2、ALIPAY_LOGONID：支付宝登录号，支持邮箱和手机号格式。

	public $payee_account;//收款方账户。与payee_type配合使用。付款方和收款方不能是同一个账户

	public $amount;//转账金额，单位：元。 只支持2位小数，小数点前最大支持13位，金额必须大于等于0.1元。
	public $payer_show_name;//付款方姓名（最长支持100个英文/50个汉字）。显示在收款方的账单详情页。如果该字段不传，则默认显示付款方的支付宝认证姓名或单位名称。
	public $payee_real_name;//收款方真实姓名（最长支持100个英文/50个汉字）。 如果本参数不为空，则会校验该账户在支付宝登记的实名是否与收款方真实姓名一致。

	public $remark;//转账备注（支持200个英文/100个汉字）。 当付款方为企业账户，且转账金额达到（大于等于）50000元，remark不能为空。收款方可见，会展示在收款用户的收支详情中。

	public $request_url = 'https://openapi.alipay.com/gateway.do';//请求地址

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
			'method'=>'alipay.fund.trans.toaccount.transfer',
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
			'payee_type'=>$this->payee_type,
			'payee_account'=>$this->payee_account,
			'amount'=>$this->amount,
			'payer_show_name'=>$this->payer_show_name,
			'payee_real_name'=>$this->payee_real_name,
			'remark'=>$this->remark
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