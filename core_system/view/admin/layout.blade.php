<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>WebManage - @yield('title')</title>
    <style>
        body { margin: 0; font-family: "Microsoft YaHei", sans-serif; display: flex; height: 100vh; background: #f4f7f6; }
        .sidebar { width: 240px; background: #2c3e50; color: #fff; display: flex; flex-direction: column; }
        .sidebar-header { padding: 20px; font-size: 20px; font-weight: bold; text-align: center; border-bottom: 1px solid #34495e; }
        .nav { flex: 1; padding: 20px 0; }
        .nav a { color: #bdc3c7; display: block; padding: 12px 25px; text-decoration: none; transition: 0.3s; }
        .nav a:hover { background: #34495e; color: #fff; }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .top-bar { height: 60px; background: #fff; display: flex; align-items: center; justify-content: space-between; padding: 0 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .content-body { padding: 30px; overflow-y: auto; flex: 1; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">WebManage</div>
        <div class="nav">
            <a href="index.php?action=dashboard">控制面板</a>
            <a href="index.php?action=site_info">站点资料</a>
            <a href="index.php?action=products">产品管理</a>
        </div>
        <a href="index.php?action=logout" style="padding: 20px; color: #e74c3c; text-align: center; border-top: 1px solid #34495e; text-decoration: none;">安全退出</a>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <div>当前管理站点 ID: <strong>{{ C_ID }}</strong></div>
            <div>管理员: <strong>{{ $_SESSION['admin_name'] }}</strong></div>
        </div>
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</body>
</html>