@extends('admin.app')
@section('content')
    <button class="btn btn-primary" onclick="history.back()">返回</button>
    <form method="post" action="{{url('admin/servers')}}">
        <div class="form-group">
            <label for="serverName">名称</label>
            <input class="form-control" type="text" name="sname" id="serverName">
        </div>
        <div class="form-group">
            <label for="serverIP">IP</label>
            <input class="form-control" type="text" name="ip" id="serverIP">
        </div>
        <div class="form-group">
            <label for="serverPort">端口</label>
            <input class="form-control" type="text" name="port" id="serverPort">
        </div>
        <div class="form-group">
            <label for="serverUser">User</label>
            <input class="form-control" type="text" name="user" id="serverUser">
        </div>
        <div class="form-group">
            <label for="serverPass">Pass</label>
            <input class="form-control" type="text" name="pass" id="serverPass">
        </div>
        <div class="form-group">
            <label for="serverAC">安全码</label>
            <input class="form-control" type="text" name="authcode" id="serverAC">
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
@endsection