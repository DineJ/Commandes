<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2> Declarer un incident </h2>

<form method="post" action="<?= site_url('Incident/start_end') ?>">

	<?php if (empty($mission))
	{ ?>
		<!-- Display all vehicles into a list -->
		<label for="id_vehicule">Véhicule</label>
		<select id="id_vehicule" name="id_vehicule" onchange="disabledDefault('id_vehicule')" class="form-control" required>
			<option value=""> Choisir un véhicule </option>
			<?php foreach ($vehicule as $v): ?>
				<option value="<?= $v->id ?>" <?=(isset($item) && esc($item->id_vehicule == $v->id)) ? 'selected' : '' ?>>
					<?= esc($v->plaque) ?>
				</option>
			<?php endforeach; ?>
		</select>
	<?php
	}
	else
	{ ?>
		<input type="hidden" id="id_vehicule" name="id_vehicule" value="<?= esc($mission['0']->id_vehicule) ?>">
	<?php
	} ?>

	<!-- Display all incident type into a list -->
	<label for="id_type_incident">Type incident</label>
	<select id="id_type_incident" name="id_type_incident" onchange="disabledDefault('id_type_incident')" class="form-control" required>
		<option value=""> Choisir un type d'incident </option>
		<?php foreach ($typeIncident as $ti): ?>
			<option value="<?= $ti->id ?>" <?=(isset($item) && esc($item->id_type_incident == $ti->id)) ? 'selected' : '' ?>>
				<?= esc($ti->nom) ?>
			</option>
		<?php endforeach; ?>
	</select>


	<!-- Type a short explication -->
	<label>Explication Incident</label>
	<textarea oninput="setUpper(document.getElementById('explication_incident'));" id="explication_incident" name="explication_incident" class="form-control" required><?= isset($item) ? esc($item->explication_incident) : '' ?></textarea>

	<input type="hidden" id="id_user" name="id_user" value="<?= session()->get('user')['id'] ?>">
	<input type="hidden" id="date_incident" name="date_incident" value="<?= date('Y-m-d H:i:s') ?>">
	<!-- Redirection button -->
	<a href="<?= site_url('Non_admin') ?>" class="btn btn-secondary mt-3">Retour</a>
	<button type="submit" class="btn btn-primary mt-3">Terminer incident</button>
</form>


<script src="<?= base_url('js/main.js') ?>"></script>

<?= $this->endSection() ?>


