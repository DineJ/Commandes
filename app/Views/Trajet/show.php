<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
<h2>Détails de Trajet</h2>

<div class="table-responsive fw-bold">
	<table class="table table-striped table-bordered mt-3">
		<tbody>

			<!-- Display starting location -->
			<tr>
				<td class="td-hidden">Lieu départ</td>
				<td data-label="Lieu départ"><?= $lieu_depart->surnom ?></td>
			</tr>

			<!-- Display ending location -->
			<tr>
				<td class="td-hidden">Lieu arrivé</td>
				<td data-label="Lieu arrivé"><?= $lieu_arrive->surnom ?></td>
			</tr>

			<!-- Display the date of the trial -->
			<tr>
				<td class="td-hidden">Date début</td>
				<td data-label="Date début"><?= esc(date('d/m/Y', strtotime($item->date_debut))) ?></td>
			</tr>

			<!-- Display reason of the trial -->
			<tr>
				<td class="td-hidden">Motif</td>
				<td data-label="Motif"><?= ucfirst($item->motif) ?></td>
			</tr>

		</tbody>
	</table>
</div>


<div>
	<form method="post" action="<?= site_url('Trajet/update/'.$item->id) ?>">
		<!-- Redirection button -->
		<a href="<?= site_url('Trajet') ?>" class="btn btn-secondary">Retour</a>

		<!-- Redirection button to edit user form -->
		<a href="<?= site_url('Trajet/edit/'.$item->id) ?>" class="btn btn-warning">Modifier</a>
	</form>
</div>

<?= $this->endSection() ?>