<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link  rel="stylesheet" href={{ URL::asset('css/users/registration.css')}}>
</head>
<body>
 <div class='MAIN'>
 	<ul class='ul'>
 		<li class='li-main'>
 			<div class='first'>
 				<form method='POST' action="{{ url('registration') }}" >
 					{{ csrf_field() }}
 					<UL class='ul-second'>
 						<li class='input'>
 							<input name="uname" type="text"  placeholder="Username">
 						</li>
 						
 						<li class='input'>
 							<input name="password" type="password"  placeholder="Password">
 						</li>
 						<li class='input'>
 							<input name="re-pass" type="pasword"  placeholder="Re-type password">
 						</li>
 						<li class='input'>
 							<input name="emer" type="text"  placeholder="Emer">
 						</li>
 						<li class='input'>
 							<select name='gjinia'>
 								 <option value='male'>Male</option>
 								 <option value='female'>Female</option>
 							</select>
 						</li>
 						<li class='input'>
 							<input name="qyteti" type="text"  placeholder="Qyteti">
 						</li>
 						<li class='input'>
 							<input name="adresa" type="text"  placeholder="Adresa">
 						</li>
 						<li class='input'>
 							<input name="cel" type="number"  placeholder="Cel">
 						</li>
 						<li class='input'>
 							<input name="tel" type="number"  placeholder="tel">
 							<li class='input'>
 							<input name="email" type="email"  placeholder="email">
 						</li>
 						<li  class="button"><button name="register">Register</button></li>
 					</UL>
 				</form>
 			</div>
 		</li>
 		<li class='li-main'>
 			<div class='second'>
 				<ul class='error'>
 				@foreach($errors->all() as $message)
                  <li><span>{{ $message }}</span></li>
                @endforeach
 				</ul>
 			</div>
 		</li>
 	</ul>

 	<div>
 	   @if(session()->has('message'))
         <div class="alert alert-success">
        {{ session()->get('message') }}
         </div>
      @endif
 	</div>
 </div>
</body>
</html>