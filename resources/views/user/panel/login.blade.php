<html>
<body>
<form action="{{$url}}/vhost/index.php?c=session&a=login" method="post" id="login">
    <input type="hidden" name="username" value="{{$user}}">
    <input type="hidden" name="passwd" value="{{$pass}}">
    <input type="submit" value="Login" class="btn btn-success">
</form>
<script>
    window.onload = function (){
        document.getElementById('login').submit();
    }
</script>
</body>
</html>