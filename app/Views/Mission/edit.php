<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Mission - <?= esc($title) ?></h2>

<form method="post" action="<?= site_url('Mission/update/' . $item->id) ?>" onsubmit="return validateFormMissionEdit()">
	<?= csrf_field() ?>

	<!-- Display all vehicles -->
	<label for="id_vehicule">Véhicule</label>
	<select id="id_vehicule" name="id_vehicule" class="form-control" required>
		<?php foreach($vehicules as $v): ?>
			<option value="<?= $v->id ?>" <?= (isset($item) && $item->id_vehicule == $v->id) ? 'selected' : '' ?>>
				<?= esc($v->plaque) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldid_vehicule" name="oldid_vehicule" value="<?= isset($item) ? $item->id_vehicule : '' ?>">

	<!-- Display all drivers -->
	<label for="id_user">Conducteur</label>
	<select id="id_user" name="id_user" class="form-control" required>
		<?php foreach($utilisateurs as $u): ?>
			<option value="<?= $u->id ?>" <?= (isset($item) && $item->id_user == $u->id) ? 'selected' : '' ?>>
				<?= esc($u->prenom) . ' ' . esc($u->nom) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldid_user" name="oldid_user" value="<?= isset($item) ? $item->id_user : '' ?>">

	<!-- Add an itinerary segment -->
	<button type="button" id="add-trajet" class="btn btn-success mt-3 mb-4">Ajouter un trajet</button>
	<br>

	<!-- Display the first departure location -->
	<label for="id_lieu_depart" class="fw-bold">Lieu de départ</label>
	<select id="id_lieu_depart" name="id_lieu_depart" class="form-control mb-3" required>
		<option value="" disabled <?= empty($trajets) ? 'selected' : '' ?>>Choisir un lieu de départ</option>
		<?php foreach($lieux as $lieu): ?>
			<option value="<?= $lieu->id ?>"
				<?= !empty($trajets) && $trajets[0]->id_lieu_depart == $lieu->id ? 'selected' : '' ?>>
				<?= esc($lieu->numero . ' ' . $lieu->adresse . ' ' . $lieu->nom_lieu) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldid_lieu_depart" name="oldid_lieu_depart" value="<?= !empty($trajets) ? esc($trajets[0]->id_lieu_depart) : '' ?>">

	<!-- Display every arrival location in itinerary order -->
	<div id="trajets-container">
		<?php foreach((empty($trajets) ? [null] : $trajets) as $index => $trajet): ?>
			<div class="trajet-row mb-4">
				<label class="fw-bold trajet-title" for="arrivee-<?= $index ?>">
					Lieu d'arrivée <?= $index + 1 ?>
				</label>
				<select id="arrivee-<?= $index ?>" name="arrivees[<?= $index ?>]" class="form-control" required>
					<option value="" disabled <?= $trajet === null ? 'selected' : '' ?>>Choisir un lieu d'arrivée</option>
					<?php foreach ($lieux as $lieu): ?>
						<option value="<?= esc($lieu->id) ?>"
							<?= $trajet !== null && $trajet->id_lieu_arrive == $lieu->id ? 'selected' : '' ?>>
							<?= esc($lieu->numero . ' ' . $lieu->adresse . ' ' . $lieu->nom_lieu) ?>
						</option>
					<?php endforeach; ?>
				</select>
				<?php if ($index > 0): ?>
					<button type="button" class="btn btn-danger mt-3 remove-trajet">Supprimer trajet</button>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<input type="hidden" id="oldid_lieu_arrive" name="oldid_lieu_arrive"
		   value="<?= !empty($trajets) ? esc($trajets[array_key_last($trajets)]->id_lieu_arrive) : '' ?>">

	<!-- Select reasons of the travel -->
	<label for="motif">Motif</label>
	<select id="motif" name="motif" class="form-control" required>
		<?php foreach($motifs as $m): ?>
			<option value="<?= esc($m) ?>" <?= $itineraire && $itineraire->motif == $m ? 'selected' : '' ?>>
				<?= esc(ucfirst($m)) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldmotif" name="oldmotif" value="<?= $itineraire ? esc($itineraire->motif) : '' ?>">

	<!-- Select start Km -->
	<label>Km de départ</label>
	<input type="number" id="km_depart" name="km_depart" value="<?= esc($item->km_depart) ?>" class="form-control" required>
	<input type="hidden" id="oldkm_depart" name="oldkm_depart" value="<?= esc($item->km_depart) ?>">

	<!-- Select end Km -->
	<label>Km arrivé</label>
	<input type="number" id="km_arrive" name="km_arrive" value="<?= esc($item->km_arrive) ?>" class="form-control" required>
	<input type="hidden" id="oldkm_arrive" name="oldkm_arrive" value="<?= esc($item->km_arrive) ?>">

	<!-- Redirection button -->
	<a href="<?= site_url('Mission/show/' . $item->id) ?>" class="btn btn-secondary mt-3">Retour</a>
	<button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>


<script src="<?= base_url('js/validateForm.js') ?>"></script>
<script src="<?= base_url('js/validateKm.js') ?>"></script>
<script src="<?= base_url('js/trajetForm.js') ?>"></script>

<?= $this->endSection() ?>
