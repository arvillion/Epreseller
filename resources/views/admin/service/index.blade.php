@extends('admin.app')
@section('content')
    <p>
        <span class="label label-warning">产品/服务器被暂停</span>
        <span class="label label-danger">用户被暂停/服务被手动暂停</span>
    </p>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Pass</th>
            <th>产品/服务器</th>
            <th>经销商</th>
            <th>Op</th>
        </tr>
        </thead>
        <tbody>
        @foreach($services as $service)
            <tr @if ($service->status == 1)
                class="danger"
                @elseif ($service->status == -1)
                class="warning"
                @else
                class="success"
                @endif>
                <td>{{$service->id}}</td>
                <td>{{$service->user}}</td>
                <td>{{$service->pass}}</td>
                <td>
                    <label class="label label-default">{{$service->product->name}}</label>
                    /<label class="label label-default">{{$service->server->name}}</label>
                </td>
                <td>{{$service->reseller->name}}</td>
                <td>
                    {{--<button type="button" class="btn btn-warning" data-target="#modal-change" data-toggle="modal" data-serviceid="{{$service->id}}">修改密码</button>--}}
                    <button type="button" class="btn btn-danger" data-target="#modal-delete" data-toggle="modal" data-serviceid="{{$service->id}}">删除</button>
                    <form action="{{route('admin.services.status', ['id' => $service->id])}}" method="post" style="display: inline-block">
                        {{csrf_field()}}
                        @if (!$service->status)
                            <button type="submit" class="btn btn-warning">暂停</button>
                        @else
                            <button type="submit" class="btn btn-success">恢复</button>
                        @endif
                    </form>
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
                        确定要删除这个服务?
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
                            <input type="password" name="pass" class="form-control" id="password">
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{$services->links()}}
@endsection
@section('scripts')
    <script>
        $('#modal-delete').on('show.bs.modal', function (event) {
            let pid = $(event.relatedTarget).data('serviceid');
            $(this).find('.modal-footer form').attr('action', '{{url('admin/services/')}}' + '/' + pid);
        });
        $('#modal-change').on('show.bs.modal', function (event) {
            let pid = $(event.relatedTarget).data('serviceid');
            $(this).find('form').attr('action', '{{url('admin/services/')}}' + '/' + pid + '/password');
        });
    </script>
@endsection