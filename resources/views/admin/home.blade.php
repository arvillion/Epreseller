@extends('admin.app')
@section('content')
    <div class="alert-success alert">
        欢迎您, {{Auth::user()->name}}
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>System</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    程序版本: 1.0 <label class="label label-info">Beta</label>
                </li>
            </ul>
        </div>
    </div>
@endsection