@extends('admin.app')
@section('content')
    <p>
        <a class="btn btn-primary" href="{{url('admin/servers/create')}}">增加服务器</a>
    </p>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>IPADDR</th>
            <th>User</th>
            <th>Pass</th>
            <th>安全码</th>
            <th>Op</th>
        </tr>
        </thead>
        <tbody>
        @foreach($servers as $server)
            <tr @if ($server->status) class="danger" @else class="success" @endif>
                <td>{{$server->id}}</td>
                <td>{{$server->name}}</td>
                <td>{{$server->ip.':'.$server->port}}</td>
                <td>{{$server->user}}</td>
                <td>{{$server->pass}}</td>
                <td>{{$server->authcode}}</td>
                <td>
                    <form action="http://{{$server->ip.':'.$server->port}}/admin/index.php?c=session&a=login" method="post" target="_blank">
                        <input type="hidden" name="username" value="{{$server->user}}">
                        <input type="hidden" name="passwd" value="{{$server->pass}}">
                        <input type="submit" value="后台" class="btn btn-success btn-xs">
                        <a class="btn btn-info btn-xs" href="{{url('admin/servers/'.$server->id.'/edit')}}">修改</a>
                        @if ($server->status)
                            <a href="{{route('admin.servers.unsuspend', $server->id)}}" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="恢复服务器及其所有服务">恢复</a>
                        @else
                            <a href="{{route('admin.servers.suspend', $server->id)}}" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="暂停服务器及其所有服务,用户无法使用该服务器">暂停</a>
                        @endif
                        <button type="button" data-toggle="modal" data-target="#modal-delete" data-serverid="{{$server->id}}" class="btn btn-danger btn-xs">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$servers->links()}}
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">请确认</h4>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        确定要删除这个服务器及其所有服务?
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        {{csrf_field()}}
                        {{method_field(('DELETE'))}}
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">确认删除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#modal-delete').on('show.bs.modal', function (event) {
            let pid = $(event.relatedTarget).data('serverid');
            $(this).find('.modal-footer form').attr('action', '{{url('admin/servers')}}' + '/' + pid);
        });
    </script>
@endsection