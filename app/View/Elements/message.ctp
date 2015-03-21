<div class="notification <?= ($m["Message"]["read"]==0 ? "bg-blue": ""); ?>">
	<h3><?= $m["Message"]["name"]; ?></h3>
	<p><?= $m["Message"]["message"]; ?></p>
	<span><?= $this->Time->format("d/m/Y H:i:s",$m["Message"]["date"]); ?></span>
</div>