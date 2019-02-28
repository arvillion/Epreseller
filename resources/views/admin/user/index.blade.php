@extends('admin.app')
@section('content')

    <p>
        <a class="btn btn-primary" href="{{url('admin/users/create')}}">新添用户</a>
    </p>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>Email</th>
            <th>用户组</th>
            <th>api_token</th>
            <th>过期时间</th>
            <th>Op</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr @if ($user->status || $user->isExpired()) class="danger" @else class="success" @endif>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role ? $user->role->name : ''}}</td>
                <td>{{$user->api_token}}</td>
                <td>{{$user->expires_at->format('Y-m-d')}}</td>
                <td>
                    <a class="btn btn-info btn-xs" href="{{url('admin/users/'.$user->id.'/edit')}}">修改</a>
                    <button type="button" class="btn btn-primary btn-xs" data-target="#modal-months" data-toggle="modal" data-userid="{{$user->id}}">续期</button>
                    <button type="button" class="btn btn-warning btn-xs" data-target="#modal-change" data-toggle="modal" data-userid="{{$user->id}}">修改密码</button>
                    @if ($user->status)
                        <a href="{{route('admin.users.unsuspend', $user->id)}}" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="恢复用户及其所有服务">恢复</a>
                    @else
                        <a href="{{route('admin.users.suspend', $user->id)}}" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="暂停用户及其所有服务,用户一切操作被禁止">暂停</a>
                    @endif
                        <button type="button" class="btn btn-danger btn-xs" data-target="#modal-delete" data-toggle="modal" data-userid="{{$user->id}}">删除</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
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
                        确定要删除这个用户及其所有服务?
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

    <div class="modal fade" id="modal-change" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">修改密码</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-months" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">续期</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        {{csrf_field()}}
                        <div class="form-group form-inline">
                            <label for="months">月数</label>
                            <input class="form-control" id="months" name="months">
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{$users->links()}}
@endsection
@section('scripts')
    <script>
        $('#modal-delete').on('show.bs.modal', function (event) {
            let pid = $(event.relatedTarget).data('userid');
            $(this).find('.modal-footer form').attr('action', '{{url('admin/users/')}}' + '/' + pid);
        });
        $('#modal-change').on('show.bs.modal', function (event) {
            let pid = $(event.relatedTarget).data('userid');
            $(this).find('form').attr('action', '{{url('admin/users/')}}' + '/' + pid + '/password');
        });
        $('#modal-months').on('show.bs.modal', function (event) {
            let pid = $(event.relatedTarget).data('userid');
            $(this).find('form').attr('action', '{{url('admin/users/')}}' + '/' + pid + '/months');
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endsection