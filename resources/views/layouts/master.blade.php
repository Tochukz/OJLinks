<!DOCTYPE html>
<html>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111725857-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-111725857-1');
	</script>

	<title>
        @section('title')
            | OJLinks Bookshop
        @show
    </title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="token" content="{{csrf_token()}}" />

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
	<!--<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />-->

	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}"/>
	<link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}"/>
	@yield('style')

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"> </script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"> </script>	
	<![endif]-->
</head>
<body>
@include('partials.header')
@yield('body')
@include('partials.footer')


<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!--<script src="{{ asset('js/jquery-1.11.3.min.js ')}}"></script>-->
<!--<script src="{{ asset('js/bootstrap.min.js') }}"></script>-->
    
@yield('script')
    
<script src="{{ asset('js/main.js') }}"> </script>

</body>
</html>