<h1>Films</h1>

<table id="film">
	<thead>
		<tr>
			<th>Nom</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lists as $l) : ?>
		<tr>
			<td>
				<?= $l["Film"]["nom"]; ?>
				<?php $info = pathinfo($l["Film"]["path"]); ?>
				<span class="extension"><?= $info["extension"]; ?></span>
				<?php if(!empty($l["Stream"])): ?>
					<span class="quality"><?= $this->Film->getQualityFromWidth($l["Stream"][0]["iVideoWidth"]); ?></span>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>