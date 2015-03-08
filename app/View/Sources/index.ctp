<div class="groups index">
	<h2>
		<?php echo __('Source'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Ajouter une source',array("admin" => false,'controller' => 'sources', 'action' => 'edit'),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<table class="u-full-width">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name','Libellé'); ?></th>
					<th><?php echo $this->Paginator->sort("Type.name",'Type'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($sources as $source): ?>
					<tr>
						<td><?php echo h($source['Source']['name']); ?>&nbsp;</td>
						<td><?php echo h($source['SourceAsOneType']['name']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link($this->Html->image('icons/edit.svg',array('width' => '30','height' => '30')), array('action' => 'edit', $source['Source']['id']),array('escape' => false)); ?>
							<?php echo $this->Form->postLink($this->Html->image('icons/delete.svg',array('width' => '30','height' => '30','class' => 'button-delete')), array('action' => 'delete', $source['Source']['id']),array('escape' => false), __('Voulez vous vraiment supprimer %s?', $source['Source']['name'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<?php
							echo $this->Paginator->counter(array('format' => __('Page {:page} sur {:pages}, {:current} enregistrement(s) sur {:count} au total.')));
							echo $this->Pagination->showPagination('Source');
						?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>