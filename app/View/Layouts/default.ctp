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
			echo $this->Html->css(array('normalize','skeleton','menu','general','content','jsElements','jquery-ui'));
			$scripts = array('jquery-2.1.3.min','jquery-ui','bootstrap.min','init');
			
			// Add the specifics JS files for the current controller
			if (fileExistsInPath(JS.'components'.DS.strtolower($this->params['controller']).'.js')) {
				$scripts[] = 'components'.DS.strtolower($this->params['controller']);
			}
			
			echo $this->Html->script($scripts);
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
			<div class="u-pull-left">
				<ul class="quick-section">
					<li><?php echo $this->Html->link('Films',array('controller' => 'films', 'action' => 'index', 'admin' => FALSE)); ?></li>
					<li><?php echo $this->Html->link('Scripts',array('controller' => 'scripts', 'action' => 'index', 'admin' => FALSE)); ?></li>
					<li><?php echo $this->Html->link('Jeux',array('controller' => 'games', 'action' => 'index', 'admin' => FALSE)); ?></li>
				</ul>
			</div>
			<div class="header-quick-nav">
				<div class="quick-nav-right">
					<div class="notifications-toggler">
						<a href="<?= $this->Html->url(array("controller" => "messages", "action" => "last")); ?>" id="user-notification" class="dropdown-toggle" data-toggle="dropdown">
							<div class="user-details notifBadgeZone">
								<?= $userName; ?>
								<?php if (!empty($nbNonLu) && $nbNonLu>0): ?>
									<span class="badge important"><?= $nbNonLu; ?></span>
								<?php endif; ?>
							</div>
						</a>
						<div class="dropdown-menu pull-right" role="menu" aria-labelledby="user-notification">
							<h2>Notifications</h2>
							<div id="listNotification">
								<?php if(!empty($dernierMessage)): ?>
									<?php foreach($dernierMessage as $m) : ?>
										<?= $this->element("message", array("m" => $m)); ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<div class="notification-buttons">
								<a href="#" id="closeNotification" class="button">Fermer</a>
								<?php if (!empty($dernierMessage)): ?>
									<?= $this->Html->link("Effacer tout", array("controller" => "messages", "action" => "delete", "all"), array("class" => "button", "id" => "deleteAllNotification")); ?>
								<?php endif; ?>
								<?= $this->Html->link("", array("controller" => "messages", "action" => "countNotRead"), array("class" => "hide", "id" => "countNotRead")); ?>
							</div>
						</div>
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
								<li><?= $this->Html->link("Mon compte", array('admin' => false,"controller" => "users", 'action' => "account")); ?></li>
								<li><?= $this->Html->link("Notifications".(isset($nbNonLu) ? "&nbsp;&nbsp;<span class=\"badge ".($nbNonLu>0 ? "important" : "")."\">".intval($nbNonLu)."</span>" : ""), array('admin' => false,"controller" => "messages", 'action' => "index"), array("escape" => false, "class"=> "notifBadgeZone")); ?></li>
								<li class="divider"></li>
								<?php if ($userGroup==1): ?>
									<li class="title">Administration</li>
									<li><?= $this->Html->link("Utilisateurs", array('admin' => true,'controller' => 'users', 'action' => 'index')); ?></li>
									<li><?= $this->Html->link("Groupes", array('admin' => true,'controller' => 'groups', 'action' => 'index')); ?></li>
									<li class="divider"></li>
								<?php endif; ?>
								<li>
									<?php
										echo $this->Html->link(
											$this->Html->image(
												'icons/log_out.svg',
												array(
													'width' => '25',
													'height' => '25'
													)
												).' '.__('Déconnexion')
											,
											array(
												'admin' => false,
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
		</div>
	</body>
</html>
