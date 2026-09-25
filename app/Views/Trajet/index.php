<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Liste des Trajets</h2>
<a href="<?= site_url('Trajet/create') ?>" class="btn btn-success">Ajouter</a>

<!-- Search bar -->
<form method="get" action="<?= site_url('Trajet') ?>" class="mb-3">
	<div class="input-group">
		<input type="text" name="q" class="form-control" placeholder="Rechercher :  Lieux — Date (dd/mm) " value="<?= isset($search) ?  esc($search) : '' ?>">
		<button type="submit" class="btn btn-primary">Rechercher</button>

		<!-- Reset search bar -->
		<?php if (!empty($search)) : ?>
			<a href="<?= site_url('Trajet') ?>" class="btn btn-outline-secondary">Réinitialiser</a>
		<?php endif; ?>
	</div>
</form>

<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">

		<!-- Datas name -->
		<thead>
			<tr>
				<th>Ordre</th>
				<th>Lieu départ</th>
				<th>Lieu arrivé</th>
				<th>Date départ</th>
				<th>Motif</th>
				<th>Action</th>
			</tr>
		</thead>

		<tbody>

			<!-- Display datas -->
			<?php foreach ($items as $item): ?>
				<tr>
					<td data-label="Ordre"><?= esc($item->nom) ?></td>
					<td data-label="Lieu départ"><?= esc(ucfirst($item->surnom_depart)) ?></td>
					<td data-label="Lieu arrivé"><?= esc(ucfirst($item->surnom_arrive)) ?></td>
					<td data-label="Date départ"><?= esc(date('d/m/Y', strtotime($item->date_debut))) ?></td>
					<td data-label="Motif"><?= esc(ucfirst($item->motif)) ?></td>
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