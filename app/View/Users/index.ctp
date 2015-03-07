<div class="users index">
	<h2>
		<?php echo __('Users'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Add user',array(),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<table class="u-full-width">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>
					<th><?php echo $this->Paginator->sort('group_id'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($user['user_as_one_group']['name'], array('controller' => 'groups', 'action' => 'view', $user['user_as_one_group']['id'])); ?>
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
							<?php echo $this->Form->postLink($this->Html->image('icons/delete.svg',array('width' => '30','height' => '30','class' => 'button-delete')), array('action' => 'delete', $user['User']['id']),array('escape' => false), __('Are you sure you want to delete %s?', $user['User']['name'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">
						<?php
							echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
							echo $this->Pagination->showPagination('User');
						?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php
/*<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User As One Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>*/
