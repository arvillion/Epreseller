@extends('admin.app')
@section('content')
    <button class="btn btn-primary" onclick="history.back()">返回</button>
    <form method="post" action="{{url('admin/users')}}">
        <div class="form-group">
            <label for="userName">名称</label>
            <input class="form-control" type="text" name="sname" id="userName">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="text" name="email" id="email">
        </div>
        <div class="form-group">
            <label for="email">密码</label>
            <input class="form-control" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="userRole">用户组</label>
            <select id="userRole" class="form-control" name="user_role">
                @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
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
        $('#users').selectize({});
    </script>
@endsection

@section('styles')
    <link href="{{asset('css/selectize.css')}}" rel="stylesheet" >
@endsection