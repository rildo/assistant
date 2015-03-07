<h4>Connexion</h4>
<?php echo $this->Session->flash(); ?>
<?= $this->Form->create("User"); ?>
<?= $this->Form->input("name", array("label" => false, "placeholder" => "Nom d'utilisateur")); ?>
<?= $this->Form->input("password", array("label" => false, "placeholder" => "Mot de passe")); ?>
<?= $this->Form->end("Connexion"); ?>