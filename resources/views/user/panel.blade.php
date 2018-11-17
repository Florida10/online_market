<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
   <div>
   	<ul>
   		<li>
   			<div>
   				<ul>
   					<form method="POST" action="{{ url('login_user') }}">
   						{{ csrf_field() }}
   						<li>
   							<input type="text" name="username" placeholder="Username"  required>
   						</li>
   						<li>
   							<input type="password" name="password" placeholder="password"  >
   						</li>
   						<li>
   							<button name="login">Login</button>
   						</li>
   					</form>
   				</ul>
   			</div>
   		</li>
   		<li>
   		</li>
   	</ul>
   </div>
</body>
</html>