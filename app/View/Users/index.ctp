<div class="users index">
	<h2>
		<?php echo __('Utilisateurs'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Ajouter un utilisateur',array('controller' => 'users', 'action' => 'add'),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<table class="u-full-width">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name','Nom d\'utilisateur'); ?></th>
					<th><?php echo $this->Paginator->sort('email','E-Mail'); ?></th>
					<th><?php echo $this->Paginator->sort('UserAsOneGroup.name','Groupe'); ?></th>
					<th><?php echo $this->Paginator->sort('created','Créé le'); ?></th>
					<th><?php echo $this->Paginator->sort('modified','Modifié le'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($user['UserAsOneGroup']['name'], array('controller' => 'groups', 'action' => 'view', $user['UserAsOneGroup']['id'])); ?>
						</td>
						<td>
							<?php
								if (!empty($user['User']['created'])) {
									echo h($this->Date->showFrenshDate($user['User']['created']));
								} else {
									echo h('-');
								}
							?>
						</td>
						<td>
							<?php
								if (!empty($user['User']['modified'])) {
									echo h($this->Date->showFrenshDate($user['User']['modified']));
								} else {
									echo h('-');
								}
							?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link($this->Html->image('icons/edit.svg',array('width' => '30','height' => '30')), array('action' => 'edit', $user['User']['id']),array('escape' => false)); ?>
							<?php echo $this->Form->postLink($this->Html->image('icons/delete.svg',array('width' => '30','height' => '30','class' => 'button-delete')), array('action' => 'delete', $user['User']['id']),array('escape' => false), __('Voulez vous vraiment supprimer %s?', $user['User']['name'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">
						<?php
							echo $this->Paginator->counter(array('format' => __('Page {:page} sur {:pages}, {:current} enregistrement(s) sur {:count} au total.')));
							echo $this->Pagination->showPagination('User');
						?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>