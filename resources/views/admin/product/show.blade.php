@extends('admin.app')
@section('content')
    <button onclick="history.back()" class="btn btn-primary">返回</button>
    <h1>Product #{{$product->id}} <small>{{$product->name}}</small></h1>
    <ul class="list-group">
        <li class="list-group-item">
            空间大小: {{$product->web_quota }} M
        </li>
        <li class="list-group-item">
            数据库大小: {{$product->db_quota}} M
        </li>
        <li class="list-group-item">
            流量限制: {{$product->flow_limit}} G/Monthly
        </li>
        <li class="list-group-item">
            数据库: {{$product->db_type}}
        </li>
        <li class="list-group-item">
            域名绑定个数: {{$product->domain != -1 ?: 'Unlimited'}}
        </li>
        <li class="list-group-item">
            @foreach($servers as $server)
                @if ($server->status == 1)
                    <span class="label label-danger">{{$server->name}}({{$server->ip}})</span>
                @else
                    <span class="label label-success">{{$server->name}}({{$server->ip}})</span>
                @endif

            @endforeach
        </li>
    </ul>
    <ul class="list-group">
        <li class="list-group-item">
            FTP服务: {{$product->ftp ? '开启' : '关闭'}}
        </li>
        @if ($product->ftp)
        <li class="list-group-item">
            FTP连接数: {{$product->ftp_connect ?: 'Unlimited'}}
        </li>
        <li class="list-group-item">
            FTP上传速度: {{$product->ftp_usl ?: 'Unlimited'}} K/每秒
        </li>
        <li class="list-group-item">
            FTP下载速度: {{$product->ftp_dsl ?: 'Unlimited'}} K/每秒
        </li>
        @endif
    </ul>
    <ul class="list-group">
        <li class="list-group-item">
            绑定子目录: {{$product->subdir_flag ? '允许' : '禁止'}}
        </li>
        <li class="list-group-item">
            最多子目录: {{$product->subdir_max ?: 'Unlimited'}}
        </li>
    </ul>
    <ul class="list-group">
        <li class="list-group-item">
            <b>Additions</b>
        </li>
        <li class="list-group-item">
            <p>
                .htaccess支持: {{$product->htaccess ? '开启' : '关闭'}}
            </p>
            <p>
                开启日志分析: {{$product->log_handle ? '开启' : '关闭'}}
            </p>
            <p>
                自定义控制: {{$product->access ? '开启' : '关闭'}}
            </p>
            <p>
                SSL支持: {{$product->ssl ? '开启' : '关闭'}}
            </p>
        </li>
    </ul>
@endsection