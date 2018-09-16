<!DOCTYPE html>
<html>
<head>
	<title>Bakery Shop</title>
	 <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/css/lib/pe-icon-7-stroke.min.css" rel="stylesheet"/>
    <link href="/css/lib/light-bootstrap-dashboard.min.css" rel="stylesheet"/>
</head>
<body>
	<div id="app">
		<User></User>
	</div>
	<script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/js/lib/light-bootstrap-dashboard.js"></script>
</body>
</html>