<div class="users index">
	<h2>
		<?php echo __('Ajouter un/des script(s)'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Ajouter un script',array('controller' => 'scripts', 'action' => 'index'),array('class' => 'button')); ?>
		</div>
	</h2>
	<?php echo $this->Form->create('User',array('class' => 'row')); ?>
		<div class="sub-content row">
			<div class="columns">
				<div class="alert alert-info">
					Pour ajouter un seul script, saisir le chemin absolu vers le script.<br />
					Pour ajouter plusieurs scripts, saisir le répertoire contenant les scripts à ajouter.
				</div>
				<br />
				<?php echo $this->form->input('Répertoire / Script', array('type' => 'text','class' => 'u-full-width')); ?>
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