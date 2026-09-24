<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Trajet - <?= $title ?></h2>

<form method="post" action="<?= site_url('Trajet/update/'.$item->id) ?>" onsubmit="return validateFormTrajetEdit()">

	<!-- Display all locations into a list -->
	<label for="id_lieu_depart" class="fw-bold">Lieu de départ</label>
	<select id="id_lieu_depart" name="id_lieu_depart" class="form-control mb-3" required>
		<?php foreach ($lieux as $lieu): ?>
			<option value="<?= $lieu->id ?>" <?= (isset($item) && $item->id_lieu_depart == $lieu->id) ? 'selected' : '' ?>>
				<?= esc($lieu->surnom) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldid_lieu_depart" name="oldid_lieu_depart" value="<?= isset($item) ? $item->id_lieu_depart : '' ?>">


	<!-- Display all locations into a list -->
	<label for="id_lieu_arrive" class="fw-bold">Lieu d'arrivé</label>
	<select id="id_lieu_arrive" name="id_lieu_arrive" class="form-control mb-3" required>
		<?php foreach ($lieux as $lieu): ?>
			<option value="<?= $lieu->id ?>" <?= (isset($item) && $item->id_lieu_arrive == $lieu->id) ? 'selected' : '' ?>>
				<?= esc($lieu->surnom) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" id="oldid_lieu_arrive" name="oldid_lieu_arrive" value="<?= isset($item) ? $item->id_lieu_arrive : '' ?>">


	<!-- Select a date -->
	<label class="fw-bold">Date début</label>
	<input type="date" id="date_debut" name="date_debut" value="<?= isset($item) ? esc(date('Y-m-d', strtotime($item->date_debut))) : '' ?>" class="form-control mb-3" required>
	<input type="hidden" id="olddate_debut" name="olddate_debut" value="<?= isset($item) ? esc(date('Y-m-d', strtotime($item->date_debut))) : '' ?>">


	<!-- Select a reason -->
	 <label class="fw-bold">Motif</label>
	<select id="motif" name="motif" class="form-control mb-2" required>
		<?php foreach ($motifs as $motif): ?>
			<option value="<?= esc($motif) ?>" <?= $item->motif === $motif ? 'selected' : '' ?>>
				<?= esc(ucfirst($motif)) ?>
			</option>
		<?php endforeach; ?>
	</select>


	<!-- Redirection button -->
	<a href="<?= site_url('Trajet') ?>" class="btn btn-secondary mt-3">Retour</a>
	<button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>


<script src="<?= base_url('js/validateForm.js') ?>"></script>

<?= $this->endSection() ?>