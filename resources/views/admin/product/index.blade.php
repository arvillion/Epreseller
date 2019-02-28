@extends('admin.app')
@section('content')

    <p>
        <a class="btn btn-primary" href="{{url('admin/products/create')}}">新添产品</a>
    </p>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>空间大小</th>
            <th>数据库大小</th>
            <th>流量限制</th>
            <th>个数限制(单用户)</th>
            <th>Op</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr @if ($product->status) class="danger" @else class="success" @endif>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->web_quota}} M</td>
                <td>{{$product->db_quota}} M</td>
                <td>{{$product->flow_limit}} G/月</td>
                <td>{{$product->account_limit ?: '无限制'}}</td>
                <td>
                    <a class="btn btn-success btn-xs" href="{{url('admin/products/'.$product->id)}}">详细信息</a>
                    <a class="btn btn-info btn-xs" href="{{url('admin/products/'.$product->id.'/edit')}}">修改</a>
                    @if ($product->status)
                        <a href="{{route('admin.products.unsuspend', $product->id)}}" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="恢复产品及其所有服务">恢复</a>
                    @else
                        <a href="{{route('admin.products.suspend', $product->id)}}" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="暂停产品及其所有服务,用户无法创建该产品的服务">暂停</a>
                    @endif
                    <button type="button" class="btn btn-danger btn-xs" data-target="#modal-delete" data-toggle="modal" data-productid="{{$product->id}}">删除</button>
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
                        确定要删除这个产品及其所有服务?
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
    {{$products->links()}}
@endsection
@section('scripts')
    <script>
        $('#modal-delete').on('show.bs.modal', function (event) {
            let pid = $(event.relatedTarget).data('productid');
            $(this).find('.modal-footer form').attr('action', '{{url('admin/products/')}}' + '/' + pid);
        });
    </script>
@endsection