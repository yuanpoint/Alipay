<?php
/**
*异常类
*/
namespace Alipay\Api;
use Alipay\Api;
class PopException extends \Exception{
	public function errorMessage($errorMessage){

		$errorMsg = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
					<html xmlns='http://www.w3.org/1999/xhtml'>
					<head>
						<meta content='text/html; charset=utf-8' http-equiv='Content-Type'>
						<title>系统发生错误</title>
						<style type='text/css'>
							*{ padding: 0; margin: 0; }
							html{ overflow-y: scroll; }
							body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
							img{ border: 0; }
							.error{ padding: 24px 48px; }
							.face{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
							h1{ font-size: 32px; line-height: 48px; }
							.error .content{ padding-top: 10px}
							.error .info{ margin-bottom: 12px; }
							.error .info .title{ margin-bottom: 3px; }
							.error .info .title h3{ color: #000; font-weight: 700; font-size: 16px; }
							.error .info .text{ line-height: 24px; }
							.copyright{ padding: 12px 48px; color: #999; }
							.copyright a{ color: #000; text-decoration: none; }
						</style>
					</head>
					<body>
						<div class='error'>
							<p class='face'>:(</p>
							<h1>".$errorMessage."</h1>
							<div class='content'>
								<div class='info'>
									<div class='title'>
										<h3>错误位置</h3>
									</div>
									<div class='text'>
										<p>FILE: ".$this->getFile()." &nbsp;LINE:".$this->getLine()."</p>
									</div>
								</div>
							</div>
						</div>
					</body>
					</html>";
		echo $errorMsg;
	}
}










?>