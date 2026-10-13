<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Trajet - <?= esc($title) ?></h2>

<!-- Form to update an existing itinerary -->
<form method="post" action="<?= site_url('Trajet/update/' . $item->id) ?>" onsubmit="return validateFormTrajetEdit()">
	<?= csrf_field() ?>

	<!-- Button to dynamically add a new trajet -->
	<button type="button" id="add-trajet" class="btn btn-success mt-3 mb-4">Ajouter un trajet</button>
	<br>


	<!-- Display all locations and select the current departure location -->
	<label for="id_lieu_depart" class="fw-bold">Lieu de départ</label>
	<select id="id_lieu_depart" name="id_lieu_depart" class="form-control mb-3" required>
		<?php foreach ($lieux as $lieu): ?>
			<option value="<?= esc($lieu->id) ?>" <?= $lieu->id == $trajets[0]->id_lieu_depart ? 'selected' : '' ?>>
				<?= esc($lieu->surnom) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type='hidden' id='oldid_lieu_depart' name='oldid_lieu_depart' value='<?= isset($trajets) ? $trajets[0]->id_lieu_depart : '' ?>'>


	<!-- Container for all existing and dynamically added trajets -->
	<div id="trajets-container">

		<!-- Loop through all trajets of the itinerary -->
		<?php foreach ($trajets as $index => $trajet): ?>
			<div class="trajet-row mb-4">

				<!-- Add a separator between trajets, except for the first one -->
				<?php if ($index > 0): ?>
					<hr class="border border-dark opacity-75">
				<?php endif; ?>

				<!-- Display the arrival location number -->
				<label class="fw-bold trajet-title">Lieu d'arrivée <?= $index + 1 ?></label>

				<!-- Display all locations and select the current arrival location -->
				<select name="arrivees[<?= $index ?>]" class="form-control" required>
					<option value="" disabled hidden>Choisir un lieu d'arrivée</option>
					<?php foreach ($lieux as $lieu): ?>
						<option value="<?= esc($lieu->id) ?>" <?= $lieu->id == $trajet->id_lieu_arrive ? 'selected' : '' ?>>
							<?= esc($lieu->surnom) ?>
						</option>
					<?php endforeach; ?>
				</select>
				<input type='hidden' class='oldid_lieu_arrive' name='oldid_lieu_arrive' value='<?= isset($trajet) ? $trajet->id_lieu_arrive : '' ?>'>

				<!-- Display the remove button for all trajets except the first one -->
				<?php if ($index > 0): ?>
					<button type="button" class="btn btn-danger mt-3 remove-trajet">Supprimer trajet</button>
				<?php endif; ?>

			</div>
		<?php endforeach; ?>
	</div>


	<!-- Display the current itinerary name -->
	<label for="nom" class="fw-bold">Nom</label>
	<input type="text" id="nom" name="nom" oninput="setUpper(document.getElementById('nom'));" value="<?= esc($item->nom, 'attr') ?>" class="form-control" required>
	<input type="hidden" id="oldnom" name="oldnom" value="<?= isset($item) ? esc(($item->nom)) : '' ?>">


	<!-- Display all available motifs and select the current one -->
	<label for="motif" class="fw-bold">Motif</label>
	<select id="motif" name="motif" class="form-control mb-2" required>
		<?php foreach ($motifs as $motif): ?>
			<option value="<?= esc($motif) ?>" <?= $item->motif == $motif ? 'selected' : '' ?>>
				<?= esc(ucfirst($motif)) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type='hidden' id='oldmotif' name='oldmotif' value='<?= isset($item) ? $item->motif : '' ?>'>


	<!-- Return to the itinerary details without saving -->
	<a href="<?= site_url('Trajet/show/' . $item->id) ?>" class="btn btn-secondary mt-3">Retour</a>

	<!-- Submit the form to update the itinerary -->
	<button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>

<!-- Load JavaScript functions and dynamic trajet management -->
<script src="<?= base_url('js/main.js') ?>"></script>
<script src="<?= base_url('js/validateForm.js') ?>"></script>
<script src="<?= base_url('js/trajetForm.js') ?>"></script>

<?= $this->endSection() ?>