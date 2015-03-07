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
		<header class="u-full-width">
			<div class="header-logo-space u-pull-left">
				<?php echo $this->Html->link('Assistant','/'); ?>
			</div>
			<div class="header-quick-nav">
				<div class="quick-nav-right">
					<div class="notifications-toggler">
						<a href="#">
							<div class="user-details">
								<span class="badge important">999</span>
								Rildo
							</div>
						</a>
						<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
							<li><a href="user-profile.html"> My Account</a> </li>
							<li><a href="calender.html">My Calendar</a> </li>
							<li><a href="email.html"> My Inbox&nbsp;&nbsp;<span class="badge important">2</span></a> </li>
							<li class="divider"></li>
							<li>
								<?php
									echo $this->Html->link(
										$this->Html->image(
											'icons/log_out.svg',
											array(
												'width' => '25',
												'height' => '25'
												)
											).' '.__('Log out')
										,
										array(
											'controller' => 'users',
											'action' => 'logout'
										),
										array('escape' => false)
									);
								?>
							</li>
						</ul>
					</div>
					<ul class="header-quick-section ">
						<li class="quicklinks dropdown">
							<?php
								echo $this->Html->link(
									$this->Html->image(
										'icons/settings.svg',
										array(
											'width' => '40',
											'height' => '40'
										)
									),
									'#',
									array(
										'escape' => false,
										'data-toggle' => 'dropdown',
										'class' => 'dropdown-toggle',
										'id' => 'user-options',
										'data-target' => '#',
										'aria-haspopup' => 'true',
										'role' => 'button',
										'aria-expanded' => 'false'
									)
								);
							?>
							<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
								<li><a href="user-profile.html"> My Account</a> </li>
								<li><a href="calender.html">My Calendar</a> </li>
								<li><a href="email.html"> My Inbox&nbsp;&nbsp;<span class="badge important">2</span></a> </li>
								<li class="divider"></li>
								<li class="title">Administration</li>
								<li><?= $this->Html->link("Utilisateurs", array('controller' => 'users', 'actions' => 'index')); ?></li>
								<li class="divider"></li>
								<li>
									<?php
										echo $this->Html->link(
											$this->Html->image(
												'icons/log_out.svg',
												array(
													'width' => '25',
													'height' => '25'
													)
												).' '.__('Log out')
											,
											array(
												'controller' => 'users',
												'action' => 'logout'
											),
											array('escape' => false)
										);
									?>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</header>
		<div id="container">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
			<?php echo $this->element('sql_dump'); ?>
		</div>
	</body>
</html>
