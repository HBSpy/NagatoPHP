<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>NagatoPHP</title>

		<?php echo $this->tag->stylesheetLink('css/bootstrap.min.css'); ?>
		<?php echo $this->tag->javascriptInclude('js/jquery-1.11.0.min.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/bootstrap.min.js'); ?>

		<!--[if lt IE 9]>
		<?php echo $this->tag->javascriptInclude('js/html5shiv.js'); ?>
		<?php echo $this->tag->javascriptInclude('js.respond.min.js'); ?>
		<![endif]-->
	</head>
	<style>
		.background {
			position: fixed;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			background-attachment: fixed;
			/* text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); */
			/* background-color: #04a5e6; */
			background-image: -moz-linear-gradient(top, #542687, #04a5e6);
			/* background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#542687), to(#04a5e6)); */
			/* background-image: -webkit-linear-gradient(top, #542687, #04a5e6); */
			background-image: -o-linear-gradient(top, #542687, #04a5e6);
			background-image: linear-gradient(to bottom, #542687, #04a5e6);
			/* background-repeat: repeat-x; */
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff542687', endColorstr='#ff04a5e6', GradientType=0);
		}

		.container {
			position: relative;
			background-color: #fff;
		}
	</style>
	<body>
		<div class="background"></div>
		<?php echo $this->getContent(); ?>
	</body>
</html>
