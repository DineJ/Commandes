<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Trajet - <?= $title ?></h2>

<form method="post" action="<?= site_url('Trajet/store/') ?>">

	<!-- Display all locations into a list -->
	<label for="id_lieu_depart">Lieu de départ</label>
	<select id="id_lieu_depart" name="id_lieu_depart" onchange="disabledDefault('id_lieu_depart')" class="form-control" required>
		<option value="">    Choisir un lieu de départ    </option>
		<?php foreach ($lieux as $l1): ?>
			<option value="<?= $l1->id ?>" <?= (isset($item) && $item->id_lieu_depart == $l1->id) ? 'selected' : '' ?>>
				<?= $l1->surnom ?>
			</option>
		<?php endforeach; ?>
	</select>


	<!-- Display all locations into a list -->
	<label for="id_lieu_arrivé">Lieu d'arrivé</label>
	<select id="id_lieu_arrivé" name="id_lieu_arrivé" onchange="disabledDefault('id_lieu_arrivé')" class="form-control" required>
		<option value="">    Choisir un lieu d'arrivé    </option>
		<?php foreach ($lieux as $l1): ?>
			<option value="<?= $l1->id ?>" <?= (isset($item) && $item->id_lieu_arrivé == $l1->id) ? 'selected' : '' ?>>
				<?= $l1->surnom ?>
			</option>
		<?php endforeach; ?>
	</select>


	<!-- Select a date -->
	<label>Date début</label>
	<input type="date" onchange="setUpper(document.getElementById('date_debut'));" id="date_debut" name="date_debut" min="<?= date('Y-m-d') ?>" value="<?= isset($item) ? date('Y-m-d', strtotime($item->date_debut)) : '' ?>" class="form-control" required>


	<!-- Select value -->
	<label>Motif</label>
	<div>
		<select id="motif" name="motif" class="form-control" required>
			<option value="" disabled selected hidden> Choississez une option </option>
			<option value=maraude>Maraude</option>
			<option value=livraison>Livraison</option>
			<option value=repas>Repas</option>
			<option value=demenagement>Démenagement</option>
			<option value=personnel>Personnel</option>
		</select>
	</div>


	<!-- Redirection button -->
	<a href="<?= site_url('Trajet') ?>" class="btn btn-secondary mt-3">Retour</a>
	<button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>

<script src="<?= base_url('js/main.js') ?>"></script>

<?= $this->endSection() ?>