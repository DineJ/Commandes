<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
<h2>Détails de Trajet</h2>

<div class="table-responsive fw-bold">
	<table class="table table-striped table-bordered mt-3">
		<tbody>

			<!-- Name of your trail -->
			<tr>
				<td class="td-hidden">Nom</td>
				<td data-label="Nom"><?= esc($item->nom) ?></td>
			</tr>

			<?php
				// Initialize an empty array to store location names
				$noms = [];

				// Loop through each trajet in the itinerary
				foreach ($trajets as $index => $trajet)
				{
					// Add the departure location only for the first trajet
					if ($index === 0)
					{
						$noms[] = $trajet->depart;
					}

					// Add the arrival location of each trajet
					$noms[] = $trajet->arrivee;
				}
			?>

			<!-- All destinations -->
			<tr>
				<td class="td-hidden">Destinations</td>
				<td data-label="Destinations"><?= esc(implode(' → ', $noms)) ?></td>
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