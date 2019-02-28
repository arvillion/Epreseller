@extends('admin.app')
@section('content')
    <button class="btn btn-primary" onclick="history.back()">返回</button>
    <form method="post" action="{{url('admin/roles')}}">
        <div class="form-group">
            <label for="roleName">名称</label>
            <input class="form-control" type="text" name="sname" id="roleName">
        </div>
        <div class="form-group">
            <label for="products">产品</label>
            <select id="products" class="form-control" multiple name="products[]">
                @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
@endsection

@section('scripts')
    <script src="{{asset('js/selectize.min.js')}}"></script>
    <script>
        $('#products').selectize({});
    </script>
@endsection

@section('styles')
    <link href="{{asset('css/selectize.css')}}" rel="stylesheet" >
@endsection