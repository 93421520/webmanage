@extends('admin.layout')

@section('title', '站点资料设置')

@section('content')
<div class="card">
    <h2>基础信息配置</h2>
    <p style="color: #888; font-size: 14px;">这些信息将直接显示在您的站点前端（Logo、页脚等）。</p>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
    
    <form action="?action=save_site_info" method="POST">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">站点名称</label>
            <input type="text" name="site_name" placeholder="例如：我的官方网站" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">底部版权信息</label>
            <textarea name="footer_text" placeholder="© 2024 XXX公司 版权所有" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; height: 80px;"></textarea>
        </div>
        <button type="submit" style="background: #28a745; color: #fff; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-size: 16px;">保存配置</button>
    </form>
</div>
@endsection