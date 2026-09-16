<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Liste des Trajets</h2>
<a href="<?= site_url('Trajet/create') ?>" class="btn btn-success">Ajouter</a>



<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">

		<!-- Datas name -->
		<thead>
			<tr>
				<th>id_lieu_depart</th>
				<th>id_lieu_arrive</th>
				<th>date_debut</th>
				<th>date_arrivee</th>
				<th>motif</th>
				<th>km_depart</th>
				<th>km_arrive</th>
				<th>Actions</th>
			</tr>
		</thead>

		<tbody>
			<!-- Display datas -->
			<?php foreach ($items as $item): ?>
				<tr>
					<td data-label="id_lieu_depart"><?= esc($item->id_lieu_depart) ?></td>
					<td data-label="id_lieu_arrive"><?= esc($item->id_lieu_arrive) ?></td>
					<td data-label="date_debut"><?= esc($item->date_debut) ?></td>
					<td data-label="date_arrivee"><?= esc($item->date_arrivee) ?></td>
					<td data-label="motif"><?= esc($item->motif) ?></td>
					<td data-label="km_depart"><?= esc($item->km_depart) ?></td>
					<td data-label="km_arrive"><?= esc($item->km_arrive) ?></td>

					<td>
						<!-- Redirection button -->
						<a href="<?= site_url('Trajet/show/'.$item->id) ?>" class="btn btn-info btn-sm">Voir</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>


<!-- Pager -->
<?php if ($pager->getPageCount() > 1)
	 { ?>
	<nav aria-label="Page navigation example">
		<ul class="pagination">

			<!-- Button for previous page -->
			<li class="page-item <?= $pager->getCurrentPage() != 1 ? '' : 'disabled' ?>"><a class="page-link" href="<?= $pager->getPreviousPageURI() ?>">Précédent</a></li>

			<?php
				// $count = total number of pages, $cur = current page, $nb_page = pages shown around current, $v1 = before, $v2 = after
				$count = $pager->getPageCount();
				$cur = $pager->getCurrentPage();
				$nb_page = 1;
				$v1 = $cur - $nb_page;
				$v2 = $cur + $nb_page;

				if ($v1 < 1)
				{
					$v1 = 1;
				}

				if ($v2 > $count)
				{
					$v2 = $count;
				}

				// Display the correct number of pages
				for ($value = $v1 ; $value <= $v2; $value++ )
				{
					echo '<li '.($cur == $value ? 'class="active"' : 'class="page-item"' ).'><a class="page-link" href="'.$pager->getPageURI($value).'">'.$value.'</a></li>';
				}
				?>

			<!-- Button for next page -->
			<li class="page-item <?= $pager->hasMore() ? '' : 'disabled' ?>"><a class="page-link" href="<?= $pager->getNextPageURI() ?>">Suivant</a></li>
		  </ul>
	</nav>
<?php } ?>

<?= $this->endSection() ?>