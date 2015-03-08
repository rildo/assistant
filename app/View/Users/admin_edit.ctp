<div class="users form">
	<h2>
		<?php echo __('Modifier l\'utilisateur : '.$this->Form->value('User.name')); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Liste des utilisateurs',array('controller' => 'users', 'action' => 'index', 'admin' => TRUE),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<?php
			echo $this->Form->create('User');
			echo $this->Form->input('id');
			echo $this->Form->input(
				'name',
				array(
					'label' => 'Nom d\'utilisateur',
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'title' => '3 caractères minimum',
					'id' => 'userName'
			));
			echo $this->Form->input(
				'email',
				array(
					'label' => 'E-Mail',
					'type' => 'email',
					'placeholder' => 'Ex: steph@gmail.com'
			));
			echo $this->Form->input(
				'group_id',
				array(
					'label' => 'Groupe',
					'options' => $groups
			));
			echo $this->Form->button(
				'Modifier',
				array(
					'class' => 'button-primary'
			));
			echo $this->Form->end();
		?>
	</div>
</div>