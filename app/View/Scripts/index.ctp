<div class="scripts index">
	<h2>
		<?php echo __('Scripts'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Ajouter un script',array('controller' => 'scripts', 'action' => 'add'),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<table class="u-full-width">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name','Script'); ?></th>
					<th><?php echo $this->Paginator->sort('created','Créé le'); ?></th>
					<th><?php echo $this->Paginator->sort('modified','Modifié le'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($scripts as $script):  ?>
					<tr>
						<td><?php echo h($script['Script']['name']); ?>&nbsp;</td>
						<td>
							<?php
								if (!empty($script['Script']['created'])) {
									echo h($this->Date->showFrenshDate($script['Script']['created']));
								} else {
									echo h('-');
								}
							?>
						</td>
						<td>
							<?php
								if (!empty($script['Script']['modified'])) {
									echo h($this->Date->showFrenshDate($script['Script']['modified']));
								} else {
									echo h('-');
								}
							?>
						</td>
						<td class="actions">
							<?php
								echo $this->Html->link(
									$this->Html->image(
										'icons/edit.svg',
										array(
											'width' => '30',
											'height' => '30'
									)),
									array(
										'action' => 'edit',
										'admin' => TRUE,
										$script['Script']['id']
									),
									array(
										'escape' => false
								));
							?>
							<?php echo $this->Form->postLink($this->Html->image('icons/delete.svg',array('width' => '30','height' => '30','class' => 'button-delete')), array('action' => 'delete', $script['Script']['id']),array('escape' => false), __('Voulez vous vraiment supprimer %s?', $script['Script']['name'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">
						<?php
							echo $this->Paginator->counter(array('format' => __('Page {:page} sur {:pages}, {:current} enregistrement(s) sur {:count} au total.')));
							echo $this->Pagination->showPagination('Script');
						?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>