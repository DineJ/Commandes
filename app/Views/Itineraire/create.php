<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Itineraire - <?= $title ?></h2>

<form method="post" action="<?= site_url('Itineraire/store/') ?>">

	<!-- Type nom -->
	<label>nom</label>
	<input type="text" onchange="setUpper(document.getElementById('nom'));" id="nom" name="nom" value="<?= isset($item) ? $item->nom : '' ?>" class="form-control" required>

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
</script>

<?= $this->endSection() ?>