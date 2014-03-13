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
	<body>

		<?php echo $this->getContent(); ?>

	</body>
</html>
