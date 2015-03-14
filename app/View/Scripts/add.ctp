<div class="users index">
	<h2>
		<?php echo __('Utilisateurs'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Ajouter un script',array('controller' => 'scripts', 'action' => 'index'),array('class' => 'button')); ?>
		</div>
	</h2>
	<?php echo $this->Form->create('User',array('class' => 'row')); ?>
		<div class="sub-content row">
			<div class="six columns">
				<h5>
					Sélectionnez un répertoire
				</h5>
				<?php echo $this->form->input('Répertoire', array('type' => 'file')); ?>
			</div>
			<div class="six columns">
				<h5>
					Sélectionnez un script
				</h5>
				<?php echo $this->form->input('Script', array('type' => 'file', 'webkitdirectory', 'directory', 'multiple')); ?>
			</div>
			<?php
				echo $this->Form->button(
					'Ajouter',
					array(
						'class' => 'button-primary'
				));
			?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>