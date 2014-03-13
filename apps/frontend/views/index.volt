<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>NagatoPHP</title>

		{{ stylesheet_link('css/bootstrap.min.css') }}
		{{ javascript_include('js/jquery-1.11.0.min.js') }}
		{{ javascript_include('js/bootstrap.min.js') }}

		<!--[if lt IE 9]>
			{{ javascript_include('js/html5shiv.js') }}
			{{ javascript_include('js.respond.min.js') }}
		<![endif]-->
	</head>
	<body>

		{{ content() }}

	</body>
</html>
