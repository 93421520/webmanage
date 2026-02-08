<?php
namespace Core;

use mysqli;
use Exception;

/**
 * 数据库工厂类 - 负责主控库与客户独立库的双连管理
 */
class DB {
    private static $masterInstance = null;
    private static $clientInstance = null;

    // 防止外部实例化
    private function __construct() {}

    /**
     * 获取主控库连接 (Master DB)
     */
    public static function master() {
        if (self::$masterInstance === null) {
            // 这里填写你的 WampServer 主库配置
            $config = [
                'host' => '127.0.0.1',
                'user' => 'root',
                'pass' => '',
                'name' => 'webmaster' 
            ];

            self::$masterInstance = new mysqli($config['host'], $config['user'], $config['pass'], $config['name']);

            if (self::$masterInstance->connect_error) {
                throw new Exception("主控库连接失败: " . self::$masterInstance->connect_error);
            }
            self::$masterInstance->set_charset("utf8mb4");
        }
        return self::$masterInstance;
    }

    /**
     * 初始化并获取客户独立库连接 (Client DB)
     * @param array $config 动态传入该客户的数据库配置
     */
    public static function initClient($config) {
        if (self::$clientInstance !== null) {
            self::$clientInstance->close();
        }

        self::$clientInstance = new mysqli(
            $config['host'] ?? '127.0.0.1',
            $config['user'],
            $config['pass'],
            $config['name']
        );

        if (self::$clientInstance->connect_error) {
            throw new Exception("客户数据库连接失败: " . self::$clientInstance->connect_error);
        }
        self::$clientInstance->set_charset("utf8mb4");
        
        return self::$clientInstance;
    }

    /**
     * 获取当前已连接的客户库实例
     */
    public static function client() {
        if (self::$clientInstance === null) {
            throw new Exception("尚未初始化客户数据库连接。");
        }
        return self::$clientInstance;
    }
}