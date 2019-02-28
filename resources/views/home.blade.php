@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>用户信息</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    Email: {{$user->email}}
                </li>
                <li class="list-group-item">
                    用户组: {{$user->role->name}}
                </li>
                <li class="list-group-item">
                    到期时间: {{$user->expires_at}}({{$user->expires_at->diffForHumans()}})
                </li>
                <li class="list-group-item">API_TOKEN: {{$user->api_token}}</li>
                <li class="list-group-item">
                    状态:
                    @if ($user->status == 0)
                        <label class="label label-success">正常</label>
                    @elseif ($user->isExpired())
                        <label class="label label-danger">过期</label>
                    @else
                        <label class="label label-danger">暂停</label>
                    @endif
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <h2>产品信息</h2>
            @foreach ($user->role->products as $product)
                <h3>
                    {{$product->name}}
                    @if ($product->status != 0)
                        <label class="label label-warning">产品被暂停</label>
                    @endif
                </h3>
                <ul class="list-group">
                    @foreach ($product->servers as $server)
                        <li class="list-group-item
                        @if($user->status == 0 && $product->status == 0 && $server->status == 0)
                        active
                        @endif">
                            <h4 class="list-group-item-heading">
                                {{$server->name}} - {{$server->ip}}
                                @if ($server->status != 0)
                                    <label class="label label-warning">服务器被暂停</label>
                                @endif
                            </h4>
                            <p class="list-group-item-text">
                                <pre>product_id: {{$product->id}}<br>server_id: {{$server->id}}</pre>
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
</div>
@endsection
