<?php
/**
*公共继承类
*/
namespace Alipay\Api;

use Alipay\Api;

class Common extends PopException{

	public $app_id;//应用ID

	public $method;//接口名称

	public $format='JSON';

	public $charset = 'UTF-8';

	public $sign_type = "RSA2";

	public $sign;

	public $timestamp;//发送请求的时间

	public $version='1.0';

	public $notify_url;// 支付宝服务器主动通知商户服务器里指定的页面http/https路径。建议商户使用https

	public $rsa_private_key;//开发者私钥

	public $biz_content;//业务请求参数的集合，最大长度不限，除公共参数外所有请求参数都必须放在这个参数中传递，具体参照各产品快速接入文档

	public $app_auth_token;//

	public function __construct(){

		$this->timestamp = date('Y-m-d H:i:s');//自动获取当前时间

	}

	/**
	 * 校验$value是否非空
	 *  if not set ,return true;
	 *    if is null , return true;
	 **/
	public function checkEmpty($value) {
		if (!isset($value))
			return true;
		if ($value === null)
			return true;
		if (trim($value) === "")
			return true;

		return false;
	}

	/**
	*拼接字符串函数
	*$params array 数组
	*@return  string $stringToBeSigned
	*/
	public function getSignContent($params) {
		ksort($params);

		$stringToBeSigned = "";
		$i = 0;
		foreach ($params as $k => $v) {
			if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
				if ($i == 0) {
					$stringToBeSigned .= "$k" . "=" . "$v";
				} else {
					$stringToBeSigned .= "&" . "$k" . "=" . "$v";
				}
				$i++;
			}
		}

		unset ($k, $v);
		return $stringToBeSigned;
	}

	/**
	*待签名的字符串 string $data
	*$signType 签名算法的规则，支付宝支持RSA、RSA2，推荐RSA2;
	*/
	public function sign($data, $signType = "RSA2") {

		$priKey=RSA_PRIVATE_KEY;
		$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
			wordwrap($priKey, 64, "\n", true) .
			"\n-----END RSA PRIVATE KEY-----";

		($res) or die('您使用的私钥格式错误，请检查RSA私钥配置'); 

		if ("RSA2" == $signType) {
			openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
		} else {
			openssl_sign($data, $sign, $res);
		}

		$sign = base64_encode($sign);

		return $sign;
	}

	/**
	*获取开发者appid
	*/
	public function get_appid(){
		$str = '';
		if($this->app_id!="" || $this->app_id!=null){
			$str = $this->app_id;
		}elseif(APPID!='' || APPID!=NULL){
			$str = APPID;
		}else{
			$str = "商户的appid为空";
		}
		return $str;
	}
	/**
	*获取开发者私钥
	*/
	public function get_rsa_private_key(){
		$str = '';
		if($this->rsa_private_key!='' || $this->rsa_private_key!=NULL){
			$str = $this->rsa_private_key;
		}elseif(RSA_PRIVATE_KEY!='' || RSA_PRIVATE_KEY!=NULL){
			$str = RSA_PRIVATE_KEY;
		}else{
			$str = "开发者私钥为空";
		}
		return $str;
	}
	/**
	 * 以post方式提交数据到对应的接口url
	 * 
	 * @param string $data  需要post的数据
	 * @param string $url  url
	 * @param bool $useCert 是否需要证书，默认不需要
	 * @param int $second   url执行超时时间，默认30s
	 * @throws WxPayException
	 */
	public function postCurl($data, $url, $second = 30)
	{		
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);

		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//不校验CA证书
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			return "出错了，curl错误代码为".$error;
		}
	}
}



















?>