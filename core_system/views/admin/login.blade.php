@extends('admin.layout_simple') {{-- 创建一个不带侧边栏的简单布局 --}}

@section('title', '管理员登录')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; height: 80vh;">
    <div class="card" style="width: 400px; padding: 40px;">
        <h2 style="text-align: center; color: #2c3e50; margin-bottom: 30px;">系统登录</h2>
        
        @if(isset($error))
            <div style="color: #e74c3c; background: #fadbd8; padding: 10px; border-radius: 4px; margin-bottom: 20px; text-align: center;">
                {{ $error }}
            </div>
        @endif

        <form action="index.php?action=login_submit" method="POST">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px;">用户名</label>
                <input type="text" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px;">密码</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>
            <button type="submit" style="width: 100%; padding: 12px; background: #2c3e50; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                立即登录
            </button>
        </form>
        <div style="margin-top: 20px; text-align: center; color: #95a5a6; font-size: 12px;">
            站点 ID: {{ C_ID }}
        </div>
    </div>
</div>
@endsection