<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Trajet - <?= $title ?></h2>

<form method="post" action="<?= site_url('Trajet/store/') ?>">

	<button type="button" id="add-trajet" class="btn btn-success mt-3 mb-4">Ajouter un trajet</button>
	<br>

	<!-- Display all locations into a list -->
	<label for="id_lieu_depart" class="fw-bold">Lieu de départ</label>
	<select id="id_lieu_depart" name="id_lieu_depart" onchange="disabledDefault('id_lieu_depart')" class="form-control mb-3" required>
		<option value="">    Choisir un lieu de départ    </option>
		<?php foreach ($lieux as $lieu): ?>
			<option value="<?= $lieu->id ?>">
				<?= esc($lieu->surnom) ?>
			</option>
		<?php endforeach; ?>
	</select>

	<div id="trajets-container">
		<div class="trajet-row mb-4">

			<!-- Display all locations into a list -->
			<label for="id_lieu_arrive" class="fw-bold trajet-title">Lieu d'arrivé 1</label>
			<select id="id_lieu_arrive" name="arrivees[0]" onchange="disabledDefault('id_lieu_depart')" class="form-control" required>
				<option value="">    Choisir un lieu d'arrivé    </option>
				<?php foreach ($lieux as $lieu): ?>
					<option value="<?= $lieu->id ?>">
						<?= esc($lieu->surnom) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<!-- Select a date -->
	<label class="fw-bold">Date début</label>
	<input type="date" id="date_debut" name="date_debut" min="<?= date('Y-m-d') ?>" value="<?= isset($item) ? date('Y-m-d', strtotime($item->date_debut)) : '' ?>" class="form-control mb-4" required>


	<!-- Select a reason -->
	<label class="fw-bold">Motif</label>
	<select id="motif" name="motif" class="form-control mb-2" required>
		<option value="" disabled selected hidden> Choississez une option </option>
		<?php foreach ($motifs as $motif): ?>
			<option value="<?= esc($motif) ?>">
				<?= esc(ucfirst($motif)) ?>
			</option>
		<?php endforeach; ?>
	</select>


	<!-- Redirection button -->
	<a href="<?= site_url('Trajet') ?>" class="btn btn-secondary mt-3">Retour</a>
	<button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>

<script src="<?= base_url('js/main.js') ?>"></script>
<script src="<?= base_url('js/trajetForm.js') ?>"></script>

<?= $this->endSection() ?>