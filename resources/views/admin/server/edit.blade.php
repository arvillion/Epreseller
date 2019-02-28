@extends('admin.app')
@section('content')
    <form method="post" action="{{url('admin/servers/'.$server->id)}}">
        <div class="form-group">
            <label for="serverID">ID</label>
            <input class="form-control" type="text" value="{{$server->id}}" disabled="disabled" id="serverID">
        </div>
        <div class="form-group">
            <label for="serverName">名称</label>
            <input class="form-control" type="text" value="{{$server->name}}" name="sname" id="serverName">
        </div>
        <div class="form-group">
            <label for="serverIP">IP</label>
            <input class="form-control" type="text" value="{{$server->ip}}" name="ip" id="serverIP">
        </div>
        <div class="form-group">
            <label for="serverPort">端口</label>
            <input class="form-control" type="text" value="{{$server->port}}" name="port" id="serverPort">
        </div>
        <div class="form-group">
            <label for="serverUser">User</label>
            <input class="form-control" type="text" value="{{$server->user}}" name="user" id="serverUser">
        </div>
        <div class="form-group">
            <label for="serverPass">Pass</label>
            <input class="form-control" type="text" value="{{$server->pass}}" name="pass" id="serverPass">
        </div>
        <div class="form-group">
            <label for="serverAC">安全码</label>
            <input class="form-control" type="text" value="{{$server->authcode}}" name="authcode" id="serverAC">
        </div>
        {{csrf_field()}}
        {{method_field('PUT')}}
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
@endsection