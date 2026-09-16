<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
<h2>Détails de Trajet</h2>

<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">
		<tbody>

			<!-- Display id_lieu_depart -->
			<tr>
				<td class="td-hidden">id_lieu_depart</td>
				<td data-label="id_lieu_depart"><?= $item->id_lieu_depart ?></td>
			</tr>

			<!-- Display id_lieu_arrive -->
			<tr>
				<td class="td-hidden">id_lieu_arrive</td>
				<td data-label="id_lieu_arrive"><?= $item->id_lieu_arrive ?></td>
			</tr>

			<!-- Display date_debut -->
			<tr>
				<td class="td-hidden">date_debut</td>
				<td data-label="date_debut"><?= $item->date_debut ?></td>
			</tr>

			<!-- Display date_arrivee -->
			<tr>
				<td class="td-hidden">date_arrivee</td>
				<td data-label="date_arrivee"><?= $item->date_arrivee ?></td>
			</tr>

			<!-- Display motif -->
			<tr>
				<td class="td-hidden">motif</td>
				<td data-label="motif"><?= $item->motif ?></td>
			</tr>

			<!-- Display km_depart -->
			<tr>
				<td class="td-hidden">km_depart</td>
				<td data-label="km_depart"><?= $item->km_depart ?></td>
			</tr>

			<!-- Display km_arrive -->
			<tr>
				<td class="td-hidden">km_arrive</td>
				<td data-label="km_arrive"><?= $item->km_arrive ?></td>
			</tr>
		</tbody>
	</table>
</div>


<div>
	<form method="post" action="<?= site_url('Trajet/update/'.$item->id) ?>">

		<!-- Redirection button to edit user form -->
		<a href="<?= site_url('Trajet/edit/'.$item->id) ?>" class="btn btn-warning">Modifier</a>

		<!-- Disabled account button -->
		
	</form>
</div>
</br>

<!-- Redirection button -->
<a href="<?= site_url('Trajet') ?>" class="btn btn-secondary">Retour</a>
<?= $this->endSection() ?>