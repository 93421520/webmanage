<?php
require_once __DIR__ . '/../core_system/vendor/autoload.php';
session_start();

try {
    $app = Core\App::instance();
    $action = $_GET['action'] ?? 'dashboard';

    // 1. 处理登录提交
    // --- index.php 约第11行开始 ---
        if ($action === 'do_login') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // 修改点：切换到客户数据库逻辑
            $db = Core\DB::client(); 
            
            // 修改点：SQL匹配设计稿中的【管理用户表】
            // 字段名改为：用户名, 密码, 姓名
            $stmt = $db->prepare("SELECT id, 密码, 姓名 FROM 管理用户表 WHERE 用户名 = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();

            // 修改点：建议使用 password_verify，如果是明文则维持 $password === $user['密码']
            if ($user && password_verify($password, $user['密码'])) { 
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['姓名']; // 匹配设计稿字段
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                echo Core\View::make('admin.login', ['error' => '账号或密码不正确']);
                exit;
            }
        }

    // 2. 退出登录
    if ($action === 'logout') {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    // 3. 权限拦截：未登录则只允许看登录页
    if (!isset($_SESSION['admin_id'])) {
        echo Core\View::make('admin.login');
        exit;
    }

    // 4. 已登录：路由分发
    switch($action) {
        case 'dashboard':
            echo Core\View::make('admin.dashboard', ['name' => $_SESSION['admin_name']]);
            break;
        case 'site_info':
            echo Core\View::make('admin.site_info');
            break;
        case 'products':
            echo Core\View::make('admin.products');
            break;
        default:
            echo "404 - 页面未找到";
            break;
    }

} catch (\Exception $e) {
    echo "系统错误: " . $e->getMessage();
}