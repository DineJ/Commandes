<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
<h2>Détails de Mission</h2>

<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">
		<tbody>

			<!-- Display vehicle -->
			<tr>
				<td class="td-hidden">Véhicule</td>
				<td data-label="Véhicule"><?= esc($vehicule->plaque) ?></td>
			</tr>

			<!-- Display driver -->
			<tr>
				<td class="td-hidden">Conducteur</td>
				<td data-label="Conducteur"><?= esc($utilisateur->prenom) . ' ' . esc($utilisateur->nom) ?></td>
			</tr>

			<!-- Display starting location -->
			<tr>
				<td class="td-hidden">Lieu départ</td>
				<td class="concatenation" data-label="Lieu départ"><?=esc($lieuDepart->numero) . ' ' .  esc($lieuDepart->adresse) . ' ' . esc($lieuDepart->nom_lieu) ?></td>
			</tr>

			<!-- Display ending location -->
			<tr>
				<td class="td-hidden">Lieu arrivé</td>
				<td class="concatenation" data-label="Lieu arrivé"><?= esc($lieuArrive->numero) . ' ' . esc($lieuArrive->adresse) . ' ' . esc($lieuArrive->nom_lieu) ?></td>
			</tr>

			<!-- Display reasons of the travel -->
			<tr>
				<td class="td-hidden">Motif</td>
				<td data-label="Motif"><?= esc($trajet->motif) ?></td>
			</tr>

			<!-- Display starting date -->
			<tr>
				<td class="td-hidden">Date départ</td>
				<td data-label="Date départ"><?= date('d/m/Y H:i', strtotime($trajet->date_debut)) ?></td>
			</tr>

			<!-- Display ending date -->
			<tr>
				<td class="td-hidden">Date arrivée</td>
				<td data-label="Date arrivée"><?= date('d/m/Y H:i', strtotime($trajet->date_arrivee)) ?></td>
			</tr>

			<!-- Display starting Km -->
			<tr>
				<td class="td-hidden">Km de départ</td>
				<td data-label="Km de départ"><?= $trajet->km_depart ?></td>
			</tr>

			<!-- Display ending Km-->
			<tr>
				<td class="td-hidden">Km arrivé</td>
				<td data-label="Km arrivé"><?= $trajet->km_arrive ?></td>
			</tr>
		</tbody>
	</table>
</div>


<div>
	<form method="post" action="<?= site_url('Mission/update/'.$item->id) ?>">

		<!-- Redirection button -->
		<a href="<?= site_url('Mission') ?>" class="btn btn-secondary">Retour</a>

		<!-- Redirection button to edit Misson form -->
		<a href="<?= site_url('Mission/edit/'.$item->id) ?>" class="btn btn-warning">Modifier</a>

	</form>
</div>


<?= createSection($infractions, 'Infraction', 'mission', ['date_infraction' => 'Date infraction', 'commentaire' => 'Commentaire', 'points' => 'Points', 'prix' => 'Prix', 'stationnement' => 'Stationnement'], 1, 1, $item->id);?>

<script src="<?= base_url('js/main.js') ?>"></script>
<script src="<?= base_url('js/validateForm.js') ?>"></script>
<script src="<?= base_url('js/popupModal.js') ?>"></script>
<?= $this->endSection() ?>
