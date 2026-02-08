<?php
require_once __DIR__ . '/../core_system/vendor/autoload.php';
session_start();

try {
    $app = Core\App::instance();
    $action = $_GET['action'] ?? 'dashboard';

    // 1. 处理登录提交
    if ($action === 'do_login') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $db = Core\DB::master();
        $stmt = $db->prepare("SELECT * FROM sys_admins WHERE username = ? AND status = 1 LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && $password === $user['password']) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['real_name'];
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