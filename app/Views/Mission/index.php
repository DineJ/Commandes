<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Liste des Missions</h2>

<!-- Search bar -->
<form method="get" action="<?= site_url("Mission") ?>" class="mb-3">
	<div class="input-group">
		<input type="text" name="q" class="form-control" placeholder="Rechercher par Nom, Prénom, Plaque (XX-XXX-XX), Date de départ (JJ/MM)" value="<?= isset($search) ?  esc($search) : '' ?>">
		<button type="submit" class="btn btn-primary">Rechercher</button>

		<!-- Reset search bar -->
		<?php if (!empty($search)) : ?>
			<a href="<?= site_url('Mission') ?>" class="btn btn-outline-secondary">Réinitialiser</a>
		<?php endif; ?>
	</div>
</form>


<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">

		<!-- Datas name -->
		<thead>
			<tr>
				<th>Plaque</th>
				<th>Conducteur</th>
				<th>Départ</th>
				<th>Arrivé</th>
				<th>Motif</th>
				<th>Date début</th>
				<th>Date arrivée</th>
				<th>Km départ</th>
				<th>Km arrivé</th>
				<th>Action</th>
			</tr>
		</thead>

		<tbody>
			<!-- Display datas -->
			<?php foreach ($items as $item): ?>
				<tr>
					<td data-label="Plaque"><?= esc($item->plaque) ?></td>
					<td data-label="Conducteur"><?= esc($item->conducteur) ?></td>
					<td class="concatenation" data-label="Lieu départ"><?= esc($item->numero_depart) . ' ' . esc($item->adresse_depart) . ' ' . esc($item->nom_lieu_depart) ?></td>
					<td class="concatenation" data-label="Lieu arrivé"><?= esc($item->numero_arrive) . ' ' . esc($item->adresse_arrivee) . ' ' . esc($item->nom_lieu_arrive) ?></td>
					<td data-label="Motif"><?= esc($item->motif) ?></td>
					<td data-label="Date départ"><?= esc(date('d/m/Y H:i', strtotime($item->date_debut))) ?></td>
					<td data-label="Date arrivée"><?= esc(date('d/m/Y H:i', strtotime($item->date_arrivee))) ?></td>
					<td data-label="Km départ"><?= esc($item->km_depart) ?></td>
					<td data-label="Km arrivé"><?= esc($item->km_arrive) ?></td>

					<td>
						<!-- Redirection button -->
						<a href="<?= site_url('Mission/show/'.$item->id) ?>" class="btn btn-info btn-sm">Voir</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?= view('Partials/pager', ['pager' => $pager]) ?>
<?= $this->endSection() ?>
