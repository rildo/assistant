<div class="groups index">
	<h2>
		<?php echo __('Groupes'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Ajouter un groupe',array('controller' => 'groups', 'action' => 'add'),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<table class="u-full-width">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name','Libellé'); ?></th>
					<th><?php echo $this->Paginator->sort('created','Créé le'); ?></th>
					<th><?php echo $this->Paginator->sort('modified','Modifié le'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($groups as $group): ?>
					<tr>
						<td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
						<td>
							<?php
								if (!empty($group['Group']['created'])) {
									echo h($this->Date->showFrenshDate($group['Group']['created']));
								} else {
									echo h('-');
								}
							?>
						</td>
						<td>
							<?php
								if (!empty($group['Group']['modified'])) {
									echo h($this->Date->showFrenshDate($group['Group']['modified']));
								} else {
									echo h('-');
								}
							?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link($this->Html->image('icons/edit.svg',array('width' => '30','height' => '30')), array('action' => 'edit', $group['Group']['id']),array('escape' => false)); ?>
							<?php echo $this->Form->postLink($this->Html->image('icons/delete.svg',array('width' => '30','height' => '30','class' => 'button-delete')), array('action' => 'delete', $group['Group']['id']),array('escape' => false), __('Voulez vous vraiment supprimer %s?', $group['Group']['name'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<?php
							echo $this->Paginator->counter(array('format' => __('Page {:page} sur {:pages}, {:current} enregistrement(s) sur {:count} au total.')));
							echo $this->Pagination->showPagination('Group');
						?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>