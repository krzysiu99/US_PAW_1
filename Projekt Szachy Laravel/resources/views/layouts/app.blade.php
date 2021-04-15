<!DOCTYPE html>
<html>
	<head>
		<title>Szachy online</title>
		<meta charset="utf-8">
		@yield('head')
		<link rel="Shortcut icon" href="{{asset('images/favicon.ico')}}">
		<link rel="Stylesheet" type="text/css" href="{{asset('css/gra.css')}}">
		<link rel="Stylesheet" type="text/css" href="{{asset('css/stronaStartowa.css')}}">
		<link rel="Stylesheet" type="text/css" href="{{asset('css/poczekalnia.css')}}">
		<script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/jquery-ui.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('js/control.js')}}" type="text/javascript"></script>
		<script src="{{asset('js/poczekalnia.js')}}" type="text/javascript"></script>
	</head>
	<body>
		@yield('content')
	</body>
</html>