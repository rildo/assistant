<div class="groups form">
	<h2>
		<?php echo $title; ?>
		<div class="action-space">
			<?php echo $this->Html->link('Liste des sources',array("admin" => false,'controller' => 'sources', 'action' => 'index'),array('class' => 'button')); ?>
		</div>
	</h2>
	<div class="sub-content">
		<?php
			echo $this->Form->create('Source');
			echo $this->Form->input('id');
			echo $this->Form->input(
				'name',
				array(
					'label' => 'Libellé',
					'placeholder' => 'Ex: XBMC'
			));
		?>
		<?= $this->Form->input('type_id', array('label' => 'Type de la source')); ?>
		<div id="config1" class="config">
			<?= $this->Form->input('config1.host', array('label' => 'Serveur')); ?>
			<?= $this->Form->input('config1.user', array('label' => 'Utilisateur')); ?>
			<?= $this->Form->input('config1.pass', array('label' => 'Mot de passe', "type" => "password")); ?>
			<?= $this->Form->input('config1.name', array('label' => 'Base de donnée')); ?>
		</div>
		<div id="config2" class="config">
			<?= $this->Form->input('config2.path', array('label' => 'Chemin')); ?>
		</div>
		<?php
			echo $this->Form->button(
				'Modifier',
				array(
					'class' => 'button-primary'
			));
			echo $this->Form->end();
		?>
		
		<script>
			$(document).ready(function() {
				function sourceVal() {
					var val = $("#SourceTypeId").val();
					$(".config").hide();
					$("#config"+val).show();
				}
				$("#SourceTypeId").change(sourceVal);
				sourceVal();
			});
		</script>
			
	</div>
</div>