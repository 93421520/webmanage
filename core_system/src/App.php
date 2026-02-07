<?php
namespace Core;

use Exception;

/**
 * 系统引导类 - 负责环境识别与核心组件初始化
 */
class App {
    private static $instance = null;
    public $customerId = null;

    private function __construct() {
        $this->boot();
    }

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 引导启动
     */
    private function boot() {
        // 1. 获取当前域名
        $host = $_SERVER['HTTP_HOST'];

        // 2. 从主控库匹配客户信息
        $db = DB::master();
        $stmt = $db->prepare("SELECT c.id, c.db_config FROM sys_domains d JOIN sys_customers c ON d.c_id = c.id WHERE d.domain_name = ? AND c.status = 'active' LIMIT 1");
        $stmt->bind_param("s", $host);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!$result) {
            // 如果没找到，尝试判断是否为总后台管理域名
            // 这里可以根据你的实际情况添加后台域名的逻辑
            die("站点未授权或不存在: " . htmlspecialchars($host));
        }

        // 3. 设置全局常量与属性
        $this->customerId = $result['id'];
        $dbConfig = json_decode($result['db_config'], true);

        define('C_ID', $this->customerId);
        define('DATA_PATH', dirname(dirname(__DIR__)) . "/sites_data/" . C_ID);
        define('PUB_PATH', dirname(dirname(__DIR__)) . "/public_html/" . C_ID);

        // 4. 初始化客户数据库
        DB::initClient([
            'user' => $dbConfig['user'],
            'pass' => $dbConfig['pass'],
            'name' => $dbConfig['name']
        ]);
    }
}