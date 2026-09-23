<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
<h2>Détails de Itineraire</h2>

<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">
		<tbody>

			<!-- Display nom -->
			<tr>
				<td class="td-hidden">nom</td>
				<td data-label="nom"><?= $item->nom ?></td>
			</tr>
		</tbody>
	</table>
</div>


<div>
	<form method="post" action="<?= site_url('Itineraire/update/'.$item->id) ?>">

		<!-- Redirection button to edit user form -->
		<a href="<?= site_url('Itineraire/edit/'.$item->id) ?>" class="btn btn-warning">Modifier</a>

		<!-- Disabled account button -->
		
	</form>
</div>
</br>

<!-- Redirection button -->
<a href="<?= site_url('Itineraire') ?>" class="btn btn-secondary">Retour</a>
<?= $this->endSection() ?>