<div class="scripts add">
	<h2>
		<?php echo __('Ajouter un/des script(s)'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Liste des scripts', array('controller' => 'scripts', 'action' => 'index'),array('class' => 'button')); ?>
		</div>
	</h2>
	<?php
		if (empty($step) || $step == 1):
			echo $this->Form->create('Script',array('class' => 'row'));
	?>
		<div class="sub-content row">
			<div class="columns">
				<div class="alert alert-info">
					Pour ajouter un seul script, saisir le chemin absolu vers le script.<br />
					Pour ajouter plusieurs scripts, saisir le répertoire contenant les scripts à ajouter.
				</div>
				<br />
				<?php echo $this->form->input('script', array('type' => 'text','class' => 'u-full-width', 'label' => 'Répertoire / Script')); ?>
			</div>
			<?php
				echo $this->Form->button(
					'Ajouter',
					array(
						'class' => 'button-primary'
				));
			?>
		</div>
	<?php
			echo $this->Form->end();
		elseif(!empty($step) || $step == 2):
			echo $this->Form->create('scripts',array('class' => 'row'));
	?>
			<div class="sub-content row">
				<table class="u-full-width">
					<thead>
						<tr>
							<th><?php echo __('#'); ?></th>
							<th><?php echo __('Script'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($scripts as $key => $script): ?>
							<tr>
								<td><?php echo $this->Form->checkbox('checked_scripts'.'_'.$key,array('hiddenField' => false,'value'=>base64_encode($script))); ?></td>
								<td><?php echo __($script); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php
					echo $this->Form->input('step',array('value'=>2,'type'=>'hidden'));
					echo $this->Form->button(
						'Ajouter',
						array(
							'class' => 'button-primary'
					));
				?>
			</div>
	<?php
			echo $this->Form->end();
		endif;
	?>
</div>