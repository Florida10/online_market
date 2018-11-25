<html>
<head>
    <title></title>
</head>
<body>
<form method="POST" action="{{url('login_man')}}">
    {{ csrf_field() }}
    <ul>
        <li>
            <div>
                <ul>
                    <li><input type="text" name="username" placeholder="Username" required></li>
                    <li><input type="password" name="password" placeholder="Password" required> </li>
                    <li><button name="login">Login</button></li>
                </ul>
            </div>
        </li>
        <li>
            <ul>
                @foreach( $errors->all() as $message )
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </li>

    </ul>

</form>

@if(!empty($message1))
    <div class="alert alert-success"> {{ $message1 }}</div>
@endif
</body>
</html>