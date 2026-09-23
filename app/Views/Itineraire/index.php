<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Liste des Itineraires</h2>
<a href="<?= site_url('Itineraire/create') ?>" class="btn btn-success">Ajouter</a>



<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">

		<!-- Datas name -->
		<thead>
			<tr>
				<th>nom</th>
				<th>Actions</th>
			</tr>
		</thead>

		<tbody>
			<!-- Display datas -->
			<?php foreach ($items as $item): ?>
				<tr>
					<td data-label="nom"><?= esc($item->nom) ?></td>

					<td>
						<!-- Redirection button -->
						<a href="<?= site_url('Itineraire/show/'.$item->id) ?>" class="btn btn-info btn-sm">Voir</a>
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