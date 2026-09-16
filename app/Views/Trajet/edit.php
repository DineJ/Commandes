<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Trajet - <?= $title ?></h2>

<form method="post" action="<?= site_url('Trajet/update/'.$item->id) ?>" onsubmit="return validateForm()">

	<!-- Type number -->
	<label>id_lieu_depart</label>
	<input type="number" id="id_lieu_depart" name="id_lieu_depart" value="<?= isset($item) ? $item->id_lieu_depart : '' ?>" class="form-control" required>
	<input type="hidden" id="oldid_lieu_depart" name="oldid_lieu_depart" value="<?= isset($item) ? $item->id_lieu_depart : '' ?>">

	<!-- Type number -->
	<label>id_lieu_arrive</label>
	<input type="number" id="id_lieu_arrive" name="id_lieu_arrive" value="<?= isset($item) ? $item->id_lieu_arrive : '' ?>" class="form-control" required>
	<input type="hidden" id="oldid_lieu_arrive" name="oldid_lieu_arrive" value="<?= isset($item) ? $item->id_lieu_arrive : '' ?>">

	<!-- Type date_debut -->
	<label>date_debut</label>
	<input type="text" onchange="setUpper(document.getElementById('date_debut'));" id="date_debut" name="date_debut" value="<?= isset($item) ? $item->date_debut : '' ?>" class="form-control" required>
	<input type="hidden" id="olddate_debut" name="olddate_debut" value="<?= isset($item) ? $item->date_debut : '' ?>">

	<!-- Type date_arrivee -->
	<label>date_arrivee</label>
	<input type="text" onchange="setUpper(document.getElementById('date_arrivee'));" id="date_arrivee" name="date_arrivee" value="<?= isset($item) ? $item->date_arrivee : '' ?>" class="form-control" required>
	<input type="hidden" id="olddate_arrivee" name="olddate_arrivee" value="<?= isset($item) ? $item->date_arrivee : '' ?>">

	<!-- Select value -->
	<label>motif</label>
	<div>
		<select id="motif" name="motif" class="form-control" required>
			<option value="" disabled selected hidden> Choississez une option </option>
			<option value=B>B</option>
			<option value=BE>BE</option>
			<option value=C>C</option>
			<option value=C1>C1</option>
			<option value=C1E>C1E</option>
		</select>
	</div>
	<input type="hidden" id="oldmotif" name="oldmotif" value="<?= isset($item) ? $item->motif : '' ?>">

	<!-- Type number -->
	<label>km_depart</label>
	<input type="number" id="km_depart" name="km_depart" value="<?= isset($item) ? $item->km_depart : '' ?>" class="form-control" required>
	<input type="hidden" id="oldkm_depart" name="oldkm_depart" value="<?= isset($item) ? $item->km_depart : '' ?>">

	<!-- Type number -->
	<label>km_arrive</label>
	<input type="number" id="km_arrive" name="km_arrive" value="<?= isset($item) ? $item->km_arrive : '' ?>" class="form-control" required>
	<input type="hidden" id="oldkm_arrive" name="oldkm_arrive" value="<?= isset($item) ? $item->km_arrive : '' ?>">

	<!-- Redirection button -->
	<a href="<?= site_url('Trajet') ?>" class="btn btn-secondary mt-3">Retour</a>
	<button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>


<script>
	// Caps text
	function setUpper(element)
	{
		element.value=element.value.toUpperCase();
	}

	function validateForm()
	{

		// Count
		let compare = 0;
		let row = 0;

		// Get values
		let id_lieu_depart = document.getElementById('id_lieu_depart').value;
		let oldid_lieu_depart = document.getElementById('oldid_lieu_depart').value;
		row++;

		// Check values 
		if (id_lieu_depart == oldid_lieu_depart)
		{
			compare++;
		}

		// Get values
		let id_lieu_arrive = document.getElementById('id_lieu_arrive').value;
		let oldid_lieu_arrive = document.getElementById('oldid_lieu_arrive').value;
		row++;

		// Check values 
		if (id_lieu_arrive == oldid_lieu_arrive)
		{
			compare++;
		}

		// Get values
		let date_debut = document.getElementById('date_debut').value;
		let olddate_debut = document.getElementById('olddate_debut').value;
		row++;

		// Check values 
		if (date_debut == olddate_debut)
		{
			compare++;
		}

		// Get values
		let date_arrivee = document.getElementById('date_arrivee').value;
		let olddate_arrivee = document.getElementById('olddate_arrivee').value;
		row++;

		// Check values 
		if (date_arrivee == olddate_arrivee)
		{
			compare++;
		}

		// Get values
		let motif = document.getElementById('motif').value;
		let oldmotif = document.getElementById('oldmotif').value;
		row++;

		// Check values 
		if (motif == oldmotif)
		{
			compare++;
		}

		// Get values
		let km_depart = document.getElementById('km_depart').value;
		let oldkm_depart = document.getElementById('oldkm_depart').value;
		row++;

		// Check values 
		if (km_depart == oldkm_depart)
		{
			compare++;
		}

		// Get values
		let km_arrive = document.getElementById('km_arrive').value;
		let oldkm_arrive = document.getElementById('oldkm_arrive').value;
		row++;

		// Check values 
		if (km_arrive == oldkm_arrive)
		{
			compare++;
		}

		// Check counts
		if (compare == row)
		{
			alert("les valeurs sont identiques");
			return false;
		}
		return true;
	}
</script>

<?= $this->endSection() ?>