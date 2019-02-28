@extends('layouts.app')
@section('content')
    <div class="container">
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
                        <a class="btn btn-success btn-xs" href="{{route('products.show', $product->id)}}">详细信息</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$products->links()}}
    </div>
@endsection