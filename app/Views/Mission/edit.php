<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Mission - <?= $title ?></h2>

<form method="post" action="<?= site_url('Mission/update/'.$item->id. '/' .$trajet->id) ?>" onsubmit="return validateFormMissionEdit()">

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

	<!-- Display start locations -->
	<label for="id_lieu_depart">Lieu de départ</label>
	<select id="id_lieu_depart" name="id_lieu_depart" class="form-control" required>
		<?php foreach($lieuxDepart as $l1): ?>
			<option value="<?= $l1->id ?>" <?= (isset($trajet) && $trajet->id_lieu_depart == $l1->id) ? 'selected' : '' ?>>
				<?= esc($l1->numero) . ' ' . esc($l1->adresse) . ' ' . esc($l1->nom_lieu) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldid_lieu_depart" name="oldid_lieu_depart" value="<?= isset($trajet) ? $trajet->id_lieu_depart : '' ?>">


	<!-- Display end location -->
	<label for="id_lieu_arrive">Lieu arrivé</label>
	<select id="id_lieu_arrive" name="id_lieu_arrive" class="form-control" required>
		<?php foreach($lieuxArrive as $l2): ?>
			<option value="<?= $l2->id ?>" <?= (isset($trajet) && $trajet->id_lieu_arrive == $l2->id) ? 'selected' : '' ?>>
				<?= esc($l2->numero) . ' ' . esc($l2->adresse) . ' ' . esc($l2->nom_lieu) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldid_lieu_arrive" name="oldid_lieu_arrive" value="<?= isset($trajet) ? $trajet->id_lieu_arrive : '' ?>">


	<!-- Select reasons of the travel -->
	<label for="motif">Motif</label>
	<select id="motif" name="motif" class="form-control" required>
		<?php foreach($motifs as $m): ?>
			<option value="<?= esc($m) ?>" <?= (isset($trajet) && $trajet->motif == $m) ? 'selected' : '' ?>>
				<?= esc(ucfirst($m)) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldmotif" name="oldmotif" value="<?= isset($trajet) ? $trajet->motif : '' ?>">

	<!-- Select start Km -->
	<label>Km de départ</label>
	<input type="number" id="km_depart" name="km_depart" value="<?= isset($trajet) ? $trajet->km_depart : '' ?>" class="form-control" required>
	<input type="hidden" id="oldkm_depart" name="oldkm_depart" value="<?= isset($trajet) ? $trajet->km_depart : '' ?>">

	<!-- Select end Km -->
	<label>Km arrivé</label>
	<input type="number" id="km_arrive" name="km_arrive" value="<?= isset($trajet) ? $trajet->km_arrive : '' ?>" class="form-control" required>
	<input type="hidden" id="oldkm_arrive" name="oldkm_arrive" value="<?= isset($trajet) ? $trajet->km_arrive : '' ?>">

	<!-- Redirection button -->
	<a href="<?= site_url('Mission/show/' .$item->id. '/' .$trajet->id) ?>" class="btn btn-secondary mt-3">Retour</a>
	<button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>


<script src="<?= base_url('js/validateForm.js') ?>"></script>
<script src="<?= base_url('js/validateKm.js') ?>"></script>
<?= $this->endSection() ?>
