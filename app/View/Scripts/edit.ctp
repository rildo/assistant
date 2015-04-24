<div class="script form">
	<h2>
		<?php echo __('Modifier le script : '.$this->Form->value('Script.name')); ?>
		<span class="action-space">
			<?php echo $this->Html->link('Liste des scripts',array('controller' => 'scripts', 'action' => 'index', 'admin' => FALSE),array('class' => 'button')); ?>
		</span>
	</h2>
	<div class="sub-content row">
		<div class="nine columns">
			<section>
				<h5>Commande</h5>
				<div>
					<span class="t-blue" id="prefix-content"><?php echo $this->Form->value('Script.prefix'); ?></span>
					<?php echo $this->Form->value('Script.script_location'); ?>
					<span class="t-red" id="suffix-content"><?php echo $this->Form->value('Script.suffix'); ?></span>
				</div>
				<br />
				<?php
					echo $this->Form->create('Script');
					echo $this->Form->input('id');
					echo $this->Form->label('prefix', 'Préfixe', array('class'=>'t-blue'));
					echo $this->Form->input('prefix',array('class' => 'u-full-width','placeholder' => 'Préfixe', 'label' => FALSE));
					echo $this->Form->label('suffix', 'Suffixe', array('class'=>'t-red'));
					echo $this->Form->input('suffix',array('class' => 'u-full-width','placeholder' => 'Suffixe', 'label' => FALSE));
			  		echo '<br />';
					echo $this->Form->button('Modifier');
					echo $this->Form->end();
				?>
			</section>
			<section>
				<h5>Liste des exécutions programmées</h5>
				<?php if (empty($triggers)): ?>
					Aucune exécution n'a été programmée.
				<?php else: ?>
					<table class="u-full-width">
						<thead>
							<tr>
								<th><?php echo __('E-Mail'); ?></th>
								<th><?php echo __('Minute'); ?></th>
								<th><?php echo __('Heure'); ?></th>
								<th><?php echo __('Jour'); ?></th>
								<th><?php echo __('Mois'); ?></th>
								<th><?php echo __('Jour de la semaine'); ?></th>
								<th><?php echo __('Créé le'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($triggers as $k => $trigger): ?>
								<tr>
									<td><?php echo __((empty($trigger['Trigger']['email'])?'-':$trigger['Trigger']['email'])); ?></td>
									<td><?php echo $trigger['Trigger']['minute']; ?></td>
									<td><?php echo $trigger['Trigger']['hour']; ?></td>
									<td><?php echo $trigger['Trigger']['day']; ?></td>
									<td><?php echo $trigger['Trigger']['month']; ?></td>
									<td><?php echo $trigger['Trigger']['weekday']; ?></td>
									<td><?php echo __($this->Date->showFrenshDate($trigger['Trigger']['created'])); ?></td>
									<td>
										<?php
											echo $this->Form->postLink(
												$this->Html->image(
													'icons/delete.svg',
													array(
														'width' => '30',
														'height' => '30',
														'class' => 'button-delete'
													)
												),
												array(
													'controller' => 'Trigger',
													'action' => 'delete',
													$trigger['Trigger']['id'],
													'script' => $trigger['Script']['id']
												),
												array(
													'escape' => false
												),
												__('Voulez vous vraiment supprimer ce déclencheur ?')
											);
										?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</section>
			<section>
				<h5>Programmer l'exécution</h5>
			  	<?php
			  		// Form start
			  		echo $this->Form->create('Trigger',array('url' => array('controller' => 'trigger', 'action' => 'add', $scriptId)));
			  		// Inputs
			  		echo $this->Form->label('common-settings', 'Valeurs prédéfinies');
			  		echo '<br />';
			  		echo $this->Form->input('common-settings', array('label' => FALSE,'type' => 'select', 'options' => $commonSettings, 'div' => FALSE, 'class' => 'input-424'));
			  		echo '<br />';
			  		echo $this->Form->label('minute', 'Minutes');
			  		echo '<br />';
			  		echo $this->Form->input('minute', array('label' => FALSE,'type' => 'text', 'value' => '*', 'div' => FALSE, 'class' => 'input-120'));
			  		echo $this->Form->input('minute-helper', array('label' => FALSE,'type' => 'select', 'options' => $choiceMinutes, 'div' => FALSE, 'class' => 'input-300'));
			  		echo '<br />';
			  		echo $this->Form->label('hour', 'Heures');
			  		echo '<br />';
			  		echo $this->Form->input('hour', array('label' => FALSE,'type' => 'text', 'value' => '*', 'div' => FALSE, 'class' => 'input-120'));
			  		echo $this->Form->input('hour-helper', array('label' => FALSE,'type' => 'select', 'options' => $choiceHours, 'div' => FALSE, 'class' => 'input-300'));
			  		echo '<br />';
			  		echo $this->Form->label('day', 'Jours');
			  		echo '<br />';
			  		echo $this->Form->input('day', array('label' => FALSE,'type' => 'text', 'value' => '*', 'div' => FALSE, 'class' => 'input-120'));
			  		echo $this->Form->input('day-helper', array('label' =>  FALSE,'type' => 'select', 'options' => $choiceDays, 'div' => FALSE, 'class' => 'input-300'));
			  		echo '<br />';
			  		echo $this->Form->label('month', 'Mois');
			  		echo '<br />';
			  		echo $this->Form->input('month', array('label' => FALSE,'type' => 'text', 'value' => '*', 'div' => FALSE, 'class' => 'input-120'));
			  		echo $this->Form->input('month-helper', array('label' => FALSE,'type' => 'select', 'options' => $choiceMonths, 'div' => FALSE, 'class' => 'input-300'));
			  		echo '<br />';
			  		echo $this->Form->label('weekday', 'Jours de la semaine');
			  		echo '<br />';
			  		echo $this->Form->input('weekday', array('label' => FALSE,'type' => 'text', 'value' => '*', 'div' => FALSE, 'class' => 'input-120'));
			  		echo $this->Form->input('weekday-helper', array('label' => FALSE,'type' => 'select', 'options' => $choiceWeekday, 'div' => FALSE, 'class' => 'input-300'));
			  		echo '<br />';
			  		// Button
					echo $this->Form->button('Ajouter');
					// Form end
			  		echo $this->Form->end();
			  	?>
			</section>
		</div>
		<br />
		<div class="script-history three columns">
			<h5>Historique</h5>
			<table>
				<thead>
					<tr>
						<th>Début</th>
						<th>Fin</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (!empty($this->request->data['ScriptLog'])):
							foreach ($this->request->data['ScriptLog'] as $launch):
					?>
						<tr>
							<td><?php echo __($this->Date->showFrenshDatetime($launch['start_datetime'])); ?></td>
							<td><?php echo __($this->Date->showFrenshDatetime($launch['end_datetime'])); ?></td>
							<td>&nbsp;</td>
						</tr>
					<?php
							endforeach;
						else:
					?>
						Ce script n'a jamais été lancé pour le moment.
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>