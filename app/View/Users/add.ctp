<div class="users form">
	<h2>
		<?php echo __('Ajouter un utilisateur'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Liste des utilisateurs',array('controller' => 'users', 'action' => 'index'),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<?php
			echo $this->Form->create('User');
			echo $this->Form->input(
				'name',
				array(
					'label' => 'Nom d\'utilisateur',
					'placeholder' => 'Ex: Stephanie de Monaco'
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
					'label' => 'Groupe'
			));
			echo $this->Form->button(
				'Ajouter',
				array(
					'class' => 'button-primary'
			));
			echo $this->Form->end();
		?>
	</div>
</div>
