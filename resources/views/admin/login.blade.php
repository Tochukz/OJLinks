<!DOCTYPE html>
<html>
<head>
	<title>
       Login | OJlinks Bookstore
    </title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="token" content="{{csrf_token()}}" />
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}"/>
	<link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}"/>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"> </script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"> </script>	
	<![endif]-->
	<style>
		.col-sm-4{
			margin-top:4em;
			border:solid silver 1px;
			border-radius: 0.5em;
		}
		img{
			margin-top:2em;
		}
		form{
			margin-top: 3em;
			margin-bottom:5em;
		}
		p{text-align:right;}
		[type=checkbox]{
			size:1.5em;
		}
		[type=submit]{
			background-color:darkorange;
			width:10em;
			color:#383838;
			border-color:orange;
			font-weight:bold;
		}
		[type=submit]:hover{
			color:#fff;
			background-color:darkorange;
			border-color:orange;
		}
	</style>
</head>
<body>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="col-sm-4 col-sm-offset-4">
					<img src="{{asset('img/logo_trans1.png')}}" />
					<form action="{{url('/admin')}}" method="post">
						{{csrf_field()}}
						<div class="form-group">
							<input type="text"  class="form-control" placeholder= "email" />
						</div>
						<div class="form-group">
							<input type="password"  class="form-control" placeholder= "password" />
						</div>
						<div class="form-group">
							<input type="submit"  value="Login" class="btn btn-primary"/>							
						</div>
						<p><input type="checkbox" /><small>Remember me</small> &nbsp; &nbsp; <small><a href="#">Forgot password</a></small></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="{{ asset('js/jquery-1.11.3.min.js ')}}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
    
<script src="{{ asset('js/main.js') }}"> </script>
</body>
</html>