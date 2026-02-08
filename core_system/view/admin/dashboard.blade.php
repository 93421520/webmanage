@extends('admin.layout')

@section('title', '控制面板')

@section('content')
<div class="card">
    <h2>欢迎回来，{{ $name }}</h2>
    <p>这是您的多站点管理系统后台。您现在可以管理当前站点的各项数据。</p>
    <div style="margin-top: 20px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div style="background: #eef5ff; padding: 20px; border-radius: 8px; border-left: 4px solid #007bff;">
            <div style="color: #666;">当前客户库</div>
            <div style="font-size: 24px; font-weight: bold; margin-top: 5px;">db_{{ C_ID }}</div>
        </div>
        <div style="background: #fff9ee; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107;">
            <div style="color: #666;">站点物理路径</div>
            <div style="font-size: 13px; margin-top: 10px; color: #888;">{{ DATA_PATH }}</div>
        </div>
    </div>
</div>
@endsection