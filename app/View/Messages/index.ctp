<div class="groups index">
	<h2>
		<?php echo __('Notifications'); ?>
		<div class="action-space">
			<?php echo $this->Html->link('Marque tout comme vu',array("admin" => false,'controller' => 'messages', 'action' => 'read', 'all'),array('class' => 'button')); ?>
				<?php echo $this->Form->postLink("Vider", array('action' => 'delete', "all"),array('escape' => false, "class" => "button"), __('Voulez vous vraiment tout supprimer ?')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<table class="u-full-width">
			<thead>
				<tr>
					<th><?= __("Nom"); ?></th>
					<th><?= __("Message"); ?></th>
					<th><?= __("Actions"); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php if (!empty($lists)): ?>
				<?php foreach($lists as $l) : ?>
					<tr class="<?= ($l["Message"]["read"]==0 ? "bg-blue" : ""); ?>">
						<td>
							<?= $l["Message"]["name"]; ?>
						</td>
						<td>
							<?= $l["Message"]["message"]; ?>
						</td>
						<td>
							<?= $l["Message"]["read"]==0 ? $this->Html->link('Marque comme vu',array("admin" => false,'controller' => 'messages', 'action' => 'read', $l["Message"]["id"])) : ""; ?>
							<?php echo $this->Form->postLink($this->Html->image('icons/delete.svg',array('width' => '30','height' => '30','class' => 'button-delete')), array('action' => 'delete', $l['Message']['id']),array('escape' => false), __('Voulez vous vraiment supprimer %s?', $l['Message']['name'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>