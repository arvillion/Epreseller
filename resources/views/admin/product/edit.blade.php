@extends('admin.app')
@section('content')
    <button class="btn btn-primary" onclick="history.back()">返回</button>
    <form method="post" action="{{url('admin/products/'.$product->id)}}">
        <div class="form-group">
            <label for="productName">名称</label>
            <input class="form-control" type="text" name="sname" id="productName" value="{{$product->name}}">
        </div>
        <div class="form-group">
            <label for="productWebQuote">空间大小(M)</label>
            <input class="form-control" type="text" name="web_quota" id="productWebQuote" value="{{$product->web_quota}}">
        </div>
        <div class="form-group">
            <label for="productDBQuote">数据库大小(M)</label>
            <input class="form-control" type="text" name="db_quota" id="productDBQuote" value="{{$product->db_quota}}">
        </div>
        <div class="form-group">
            <label for="productFL">流量限制(G/Monthly)</label>
            <input class="form-control" type="text" name="flow_limit" id="productFL" value="{{$product->flow_limit}}">
        </div>
        <div class="form-group">
            <label for="account_limit">个数限制(单用户) 0为无限制</label>
            <input class="form-control" type="text" name="account_limit" id="account_limit" value="{{$product->account_limit}}">
        </div>
        <div class="form-group">
            <label for="servers">服务器</label>
            <select id="servers" class="form-control" multiple name="servers[]">
                @foreach($servers as $server)
                    <option value="{{$server->id}}" @if (in_array($server->id, $serverids)) selected @endif>{{$server->name}}({{$server->ip}})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="radio-inline">
                <input type="radio" name="db_type" value="mysql" {{$product->db_type == 'mysql' ? 'checked' : ''}}>mysql
            </label>
            <label class="radio-inline">
                <input type="radio" name="db_type" value="sqlsrv" {{$product->db_type == 'sqlsrv' ? 'checked' : ''}}>sql server
            </label>
        </div>
        <div class="form-group">
            <label for="domain">域名绑定个数(-1表示无限)</label>
            <input class="form-control" type="text" name="domain" id="domain" value="{{$product->domain}}">
        </div>
        <div>
            <b>绑定子目录</b>
            <label class="radio-inline">
                <input type="radio" name="subdir_flag" value="1" {{$product->subdir_flag == 1 ? 'checked' : ''}}>允许
            </label>
            <label class="radio-inline">
                <input type="radio" name="subdir_flag" value="0" {{$product->subdir_flag == 0 ? 'checked' : ''}}>禁止
            </label>
        </div>
        <div class="form-group">
            <label for="maxsubdir">最多子目录数 0为无限制</label>
            <input class="form-control" type="text" name="subdir_max" id="maxsubdir" value="{{$product->subdir_max}}">
        </div>
        <div class="form-group">
            <label for="spelmt">带宽限制(K/每秒) 0为无限制</label>
            <input class="form-control" type="text" name="speed_limit" id="spelmt" value="{{$product->flow_limit}}">
        </div>
        <div>
            <b>FTP服务</b>
            <label class="radio-inline">
                <input type="radio" name="ftp" value="1" {{$product->ftp == 1 ? 'checked' : ''}}>FTP开启
            </label>
            <label class="radio-inline">
                <input type="radio" name="ftp" value="0" {{$product->ftp == 0 ? 'checked' : ''}}>FTP关闭
            </label>
        </div>
        <div class="form-group">
            <label for="ftpcon">FTP连接数 0为无限制</label>
            <input class="form-control" type="text" name="ftp_connect" id="ftpcon" value="{{$product->ftp_connect}}">
        </div>
        <div class="form-group">
            <label for="ftpusl">FTP上传速度(K/每秒) 0为无限制</label>
            <input class="form-control" type="text" name="ftp_usl" id="ftpusl" value="{{$product->ftp_usl}}">
        </div>
        <div class="form-group">
            <label for="ftpdsl">FTP下载速度(K/每秒) 0为无限制</label>
            <input class="form-control" type="text" name="ftp_dsl" id="ftpdsl" value="{{$product->ftp_dsl}}">
        </div>
        <div>
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox1" value="1" name="htaccess" {{$product->htaccess == 1 ? 'checked' : ''}}> .htaccess支持
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox2" value="1" name="access" {{$product->access == 1 ? 'checked' : ''}}> 开启日志分析
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox3" value="1" name="log_handle" {{$product->log_handle == 1 ? 'checked' : ''}}> 自定义控制
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" value="1" name="ssl" {{$product->ssl == 1 ? 'checked' : ''}}> SSL支持
            </label>
        </div>
        {{method_field('PUT')}}
        {{csrf_field()}}
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
@endsection

@section('scripts')
    <script src="{{asset('js/selectize.min.js')}}"></script>
    <script>
        $('#servers').selectize({});
    </script>
@endsection

@section('styles')
    <link href="{{asset('css/selectize.css')}}" rel="stylesheet" >
@endsection