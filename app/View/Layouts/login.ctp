<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
	<?php

		echo $this->Html->meta('icon');

		echo $this->Html->css(array('normalize','skeleton','menu','dropdown','general','content'));
		echo $this->Html->script(array('jquery-2.1.3.min','bootstrap.min'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="one-half column" style="margin-top: 25%">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</div>
</body>
</html>
