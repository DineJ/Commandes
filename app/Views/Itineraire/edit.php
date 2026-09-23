<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Itineraire - <?= $title ?></h2>

<form method="post" action="<?= site_url('Itineraire/update/'.$item->id) ?>" onsubmit="return validateForm()">

	<!-- Type nom -->
	<label>nom</label>
	<input type="text" onchange="setUpper(document.getElementById('nom'));" id="nom" name="nom" value="<?= isset($item) ? $item->nom : '' ?>" class="form-control" required>
	<input type="hidden" id="oldnom" name="oldnom" value="<?= isset($item) ? $item->nom : '' ?>">

	<!-- Redirection button -->
	<a href="<?= site_url('Itineraire') ?>" class="btn btn-secondary mt-3">Retour</a>
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
		let nom = document.getElementById('nom').value;
		let oldnom = document.getElementById('oldnom').value;
		row++;

		// Check values 
		if (nom == oldnom)
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