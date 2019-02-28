@extends('admin.app')
@section('content')

    <p>
        <a class="btn btn-primary" href="{{url('admin/roles/create')}}">新添用户组</a>
    </p>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>可用产品</th>
            <th>Op</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                <td>
                    @foreach($role->products as $product)
                        @if ($product->status == 1)
                            <span class="label label-warning">{{$product->name}}</span>
                        @else
                            <span class="label label-success">{{$product->name}}</span>
                        @endif
                    @endforeach
                </td>
                <td>
                    <a class="btn btn-info" href="{{url('admin/roles/'.$role->id.'/edit')}}">修改</a>
                    <button type="button" class="btn btn-danger" data-target="#modal-delete" data-toggle="modal" data-roleid="{{$role->id}}">删除</button>
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
                        确定要删除这个用户组?
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
    {{$roles->links()}}
@endsection
@section('scripts')
    <script>
        $('#modal-delete').on('show.bs.modal', function (event) {
            let pid = $(event.relatedTarget).data('roleid');
            $(this).find('.modal-footer form').attr('action', '{{url('admin/roles/')}}' + '/' + pid);
        });
    </script>
@endsection