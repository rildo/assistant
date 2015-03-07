<div class="groups form">
	<h2>
		<?php echo __('Modifier le groupe : '.$this->Form->value('Group.name')); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Liste des groupes',array('controller' => 'groups', 'action' => 'index'),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<?php
			echo $this->Form->create('Group');echo $this->Form->input('id');
			echo $this->Form->input(
				'name',
				array(
					'label' => 'Libellé',
					'placeholder' => 'Ex: Utilisateurs'
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