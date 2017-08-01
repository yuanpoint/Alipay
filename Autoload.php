<?php
/**
 * Created by yuandian
 * User:yuandain
 * Date: 17/7/27
 * Time: 上午9:48
 */

namespace Alipay;

use Alipay\Api;

class Autoload{

    const NAMESPACE_PREFIX = 'Alipay\\';

    /**
     * 向PHP注册在自动载入函数
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * 根据类名载入所在文件
     */
    public static function autoload($className)
    {
        // die($className);
        $namespacePrefixStrlen = strlen(self::NAMESPACE_PREFIX);
        if (strncmp(self::NAMESPACE_PREFIX, $className, $namespacePrefixStrlen) === 0) {
            $filePath = str_replace('\\', DIRECTORY_SEPARATOR, substr($className, $namespacePrefixStrlen));
            $realpath = realpath(Alipay_ROOT_PATH . (empty($filePath) ? '' : DIRECTORY_SEPARATOR) . $filePath . '.php');
            if (file_exists($realpath)) {
                require_once $realpath;
            } else {
                die('File Not Exists. filePath: ' . $filePath . ', realPath: ' . $realpath . ' ,class:' . $className . "\n");
            }
        }
    }
}

Autoload::register();