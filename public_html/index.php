<?php
/**
 * 引导入口
 */

// 1. 引入 Composer 自动加载
require_once __DIR__ . '/../core_system/vendor/autoload.php';

try {
    // 2. 启动核心 App (单例模式)
    // 它会自动识别域名、连接数据库、定义常量 C_ID
    $app = Core\App::instance();

    // 3. 临时简单测试：输出当前客户信息
    echo "<h1>系统启动成功</h1>";
    echo "当前域名: " . $_SERVER['HTTP_HOST'] . "<br>";
    echo "识别客户ID: " . C_ID . "<br>";
    echo "客户数据目录: " . DATA_PATH . "<br>";

} catch (\Exception $e) {
    // 捕捉初始化阶段的所有错误（如数据库连不上、域名未绑定）
    header('HTTP/1.1 500 Internal Server Error');
    echo "System Error: " . $e->getMessage();
}