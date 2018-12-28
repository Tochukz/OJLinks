<!DOCTYPE html>
<html>
<head>
	<title>
        @section('title')
            | OJLinks Bookshop
        @show
    </title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="token" content="{{csrf_token()}}" />
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}"/>
	<link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}"/>
	@yield('style')
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"> </script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"> </script>	
	<![endif]-->
</head>
<body>
@include('admin.navbar') <!-- The content area will be included inde  admin.navbar -->

@include('admin.footer')
<script src="{{ asset('js/jquery-1.11.3.min.js ')}}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
    
@yield('script')
    
<script src="{{ asset('js/admin.js') }}"> </script>

</body>
</html>