<?php
/**
*验证签名
*/
namespace Alipay\Api;

use Alipay\Api;

class ValidateSign{

	public $notify_time;

	public $notify_type;

	public $notify_id;

	public $app_id;

	public $charset;

	public $version;

	public $sign_type;

	public $sign;

	public $trade_no;

	public $out_trade_no;

	public $out_biz_no;

	public $buyer_id;

	public $buyer_logon_id;

	public $seller_id;

	public $seller_email;

	public $trade_status;

	public $total_amount;

	public $receipt_amount;

	public $invoice_amount;

	public $buyer_pay_amount;

	public $point_amount;

	public $refund_fee;

	public $subject;

	public $body;

	public $gmt_create;

	public $gmt_payment;

	public $gmt_refund;

	public $gmt_close;

	public $fund_bill_list;

	public $passback_params;

	public $voucher_detail_list;

	public function __construct(){
		$this->notify_time = $_POST['notify_time'];

		$this->notify_type = $_POST['notify_type'];

		$this->notify_id = $_POST['notify_id'];

		$this->app_id = $_POST['app_id'];

		$this->charset = $_POST['charset'];

		$this->version = $_POST['version'];

		$this->sign_type = $_POST['sign_type'];

		$this->sign = $_POST['sign'];

		$this->trade_no = $_POST['trade_no'];

		$this->out_trade_no = $_POST['out_trade_no'];

		$this->out_biz_no = $_POST['out_biz_no'];

		$this->buyer_id = $_POST['buyer_id'];

		$this->buyer_logon_id = $_POST['buyer_logon_id'];

		$this->seller_id = $_POST['seller_id'];

		$this->seller_email = $_POST['seller_email'];

		$this->trade_status = $_POST['trade_status'];

		$this->total_amount = $_POST['total_amount'];

		$this->receipt_amount = $_POST['receipt_amount'];

		$this->invoice_amount = $_POST['invoice_amount'];

		$this->buyer_pay_amount = $_POST['buyer_pay_amount'];

		$this->point_amount = $_POST['point_amount'];

		$this->refund_fee = $_POST['refund_fee'];

		$this->subject = $_POST['subject'];

		$this->body = $_POST['body'];

		$this->gmt_create = $_POST['gmt_create'];

		$this->gmt_payment = $_POST['gmt_payment'];

		$this->gmt_refund = $_POST['gmt_refund'];

		$this->gmt_close = $_POST['gmt_close'];

		$this->fund_bill_list = $_POST['fund_bill_list'];

		$this->passback_params = $_POST['passback_params'];

		$this->voucher_detail_list = $_POST['voucher_detail_list'];
	}

	/**
	*请求
	*/
	public function Request(){

		//构建参数数组
		$params = $this->returnData();

		//拼接字符串
		$string = $this->getSignContent($params);

		//对字符串url_decode编码
		$string = urldecode($string);

		//进行验签,返回bool值
		return $this->verify($string,$this->sign);
	}

	/**
	*构建参数数组
	*/
	public function returnData(){
		$params = array(
			'notify_time'=>$this->notify_time,
			'notify_type'=>$this->notify_type,
			'notify_id'=>$this->notify_id,
			'app_id'=>$this->app_id,
			'charset'=>$this->charset,
			'version'=>$this->version,
			'trade_no'=>$this->trade_no,
			'out_trade_no'=>$this->out_trade_no,
			'out_biz_no'=>$this->out_biz_no,
			'buyer_id'=>$this->buyer_id,
			'buyer_logon_id'=>$this->buyer_logon_id,
			'seller_id'=>$this->seller_id,
			'seller_email'=>$this->seller_email,
			'trade_status'=>$this->trade_status,
			'total_amount'=>$this->total_amount,
			'receipt_amount'=>$this->receipt_amount,
			'invoice_amount'=>$this->invoice_amount, 
			'buyer_pay_amount'=>$this->buyer_pay_amount,
			'point_amount'=>$this->point_amount,
			'refund_fee'=>$this->refund_fee,
			'subject'=>$this->subject,
			'body'=>$this->body,
			'gmt_create'=>$this->gmt_create,
			'gmt_payment'=>$this->gmt_payment,
			'gmt_refund'=>$this->gmt_refund, 
			'gmt_close'=>$this->gmt_close, 
			'fund_bill_list'=>$this->fund_bill_list, 
			'passback_params'=>$this->passback_params, 
			'voucher_detail_list'=>$this->voucher_detail_list
		);

		//对参数去除空值
		foreach ($params as $key => $value) {
			if($value=='' || $value==NULL){
				unset($params[$key]);
			}
		}

		return $params;
	}

	/**
	*验证签名
	*/
	function verify($data, $sign, $signType = 'RSA2') {

		$pubKey = RSA_PUBLIC_KEY; 

		$res = "-----BEGIN PUBLIC KEY-----\n" .
			wordwrap($pubKey, 64, "\n", true) .
			"\n-----END PUBLIC KEY-----";


		($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');  

		//调用openssl内置方法验签，返回bool值

		if ("RSA2" == $signType) {
			$result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
		} else {
			$result = (bool)openssl_verify($data, base64_decode($sign), $res);
		}

		//释放资源
		openssl_free_key($res);

		return $result;
	}

}




?>