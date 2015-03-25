<h1>Films</h1>

<table id="film">
	<thead>
		<tr>
			<th>Nom</th>
		</tr>
	</thead>
	<tbody>
	<?php if (!empty($lists)): ?>
		<?php foreach($lists as $l) : ?>
			<tr>
				<td>
					<?= $l["Film"]["nom"]; ?>
					<?php $info = pathinfo($l["Film"]["path"]); ?>
					<span class="extension"><?= $info["extension"]; ?></span>
					<?php if(!empty($l["Stream"])): ?>
						<span class="quality"><?= $this->Film->getQualityFromWidth($l["Stream"][0]["iVideoWidth"]); ?></span>
					<?php endif; ?>
					<?php if(!empty($l["File"]) && time()-strtotime($l["File"]["dateAdded"])<86400*$userMovieNew): ?>
						<span class="new">NEW</span>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>