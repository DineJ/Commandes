<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Liste des Trajets</h2>
<a href="<?= site_url('Trajet/create') ?>" class="btn btn-success">Ajouter</a>

<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">

		<!-- Datas name -->
		<thead>
			<tr>
				<th>Lieu départ</th>
				<th>Lieu arrivé</th>
				<th>Date départ</th>
				<th>Date arrivée</th>
				<th>Motif</th>
				<th>Km départ</th>
				<th>Km arrivé</th>
				<th>Action</th>
			</tr>
		</thead>

		<tbody>
			<!-- Display datas -->
			<?php foreach ($items as $item): ?>
				<tr>
					<td data-label="Lieu départ"><?= esc($item->surnom_depart) ?></td>
					<td data-label="Lieu arrivé"><?= esc($item->surnom_arrive) ?></td>
					<td data-label="Date départ"><?= esc(date('d/m/Y H:i:s', strtotime($item->date_debut))) ?></td>
					<td data-label="Date arrivée"><?= esc(date('d/m/Y H:i:s', strtotime($item->date_arrivee))) ?></td>
					<td data-label="Motif"><?= esc($item->motif) ?></td>
					<td data-label="Km départ"><?= esc($item->km_depart) ?></td>
					<td data-label="Km arrivé"><?= esc($item->km_arrive) ?></td>
					<td>
						<!-- Redirection button -->
						<a href="<?= site_url('Trajet/show/'.$item->id) ?>" class="btn btn-info btn-sm">Voir</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?= view('Partials/pager', ['pager' => $pager]) ?>
<?= $this->endSection() ?>