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
									'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="20px" height="20px" viewBox="1.0 -2.0 20.0 27.0" enable-background="new 0 0 20 20" xml:space="preserve"><rect x="-167" y="-33" display="none" fill="#000000" width="198" height="87"/><g><path d="M-146.872,35.309c0,2.58,1.829,3.636,4.063,2.346l43.84-25.309c2.235-1.29,2.235-3.401,0-4.691l-43.84-25.309   c-2.234-1.29-4.063-0.234-4.063,2.346V35.309z"/></g><g><path d="M-81.322,25.872c0,1.721,1.219,2.424,2.708,1.564l29.227-16.873c1.49-0.86,1.49-2.268,0-3.128L-78.613-9.436   c-1.49-0.86-2.708-0.157-2.708,1.563V25.872z"/></g><g><path d="M-33.991,23.654c0,1.29,0.914,1.818,2.032,1.173l21.919-12.654c1.118-0.645,1.118-1.701,0-2.346L-31.959-2.827   c-1.118-0.645-2.032-0.117-2.032,1.173V23.654z"/></g><g><path d="M2.679,18.436c0,0.86,0.609,1.212,1.354,0.782l14.612-8.437c0.745-0.43,0.745-1.134,0-1.563L4.033,0.782   c-0.745-0.43-1.354-0.078-1.354,0.782V18.436z"/></g></svg>',
									array(
										'action' => 'launch',
										base64_encode($script['Script']['id'])
									),
									array(
										'escape' => false
									)
								);
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