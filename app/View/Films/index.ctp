<?php if (!$this->request->is("ajax")): ?>
<h1>Films</h1>

<div class="sub-content">
	<table id="film"  class="u-full-width">
		<thead>
			<tr>
				<th>Nom</th>
			</tr>
		</thead>
		<tbody>
			<?php endif; ?>
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
			<tr class="hide"><td>
				<?= $this->Paginator->next(">", array("id" => "nextFilm")); ?>
			</td></tr>
			<?php if (!$this->request->is("ajax")): ?>
		</tbody>
	</table>
</div>
<?php endif; ?>