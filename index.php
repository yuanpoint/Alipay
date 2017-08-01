<?php
/**
* 支付宝支付启动页
*author: yuanpoint 
* time 2017.7.18
*/
namespace Alipay;

use Alipay\Api;

//Alipay要求PHP环境必须大于PHP5.3
if (!substr(PHP_VERSION, 0, 3) >= '5.3') {
    return "Fatal error: Alipay requires PHP version must be greater than 5.3(contain 5.3). Because Alipay used php-namespace";
}
// 定义根目录
define('Alipay_ROOT_PATH',dirname(__FILE__) . '/');

//载入配置文件
require_once Alipay_ROOT_PATH . 'Config.php';

//载入自动加载类
require_once Alipay_ROOT_PATH . 'Autoload.php';




?>