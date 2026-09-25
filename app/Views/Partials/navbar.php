<?php
use CodeIgniter\HTTP\URI;

// Get the current URi
$currentUri = service('uri')->getPath();
$admin = session()->get('user')['admin'] ?? false;
$name = session()->get('user')['name'] ?? null;
?>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-light border-bottom px-4 py-2 <?= isset($no_navbar) ? 'no_navbar' : '' ?>">
	<div class="container-fluid">

		<div class="d-flex justify-content-start">
			<a class="navbar-brand fw-bold" href="/">
				<img src="https://www.asolidr.fr/wp-content/uploads/2025/05/cropped-ASolidr-256.png" alt="Logo" height="30" class="me-2">
			</a>
		</div>

		<?php if (!($hideUser ?? false)): ?>
			<div class="d-flex justify-content-center h5 mb-0" style="width: inherit;">
				<!-- Display a different message if you are admin or not -->
				<?= ($admin) ? 'Tableau de bord administrateur' : 'Espace ' . ($name ? $name : 'voiture') ?>
			</div>
		<?php endif; ?>

		<!-- Display a navigation menu except in the log page -->
		<?php if ($currentUri !== '/Login/log' && $currentUri !== '/Login'): ?>
			<div class="ms-auto d-flex justify-content-end">
				<div class="dropdown">
					<a class="btn btn-outline-secondary <?= $admin ? 'dropdown-toggle' : '' ?>" href="<?= $admin ? '#' : '/Login/logout' ?>" role="button" id="userDropdown" <?= $admin ? 'data-bs-toggle="dropdown"' : '' ?> aria-expanded="false">
						<?= $admin ?  $name : 'Déconnexion' ?>
					</a>

					<!-- Display the menu only for admin -->
					<?php if ($admin ?? false): ?>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
							<li><a class="dropdown-item" href="/Admin">Home</a></li>
							<li><a class="dropdown-item" href="/Ip">IP</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="/Assurance">Assurance</a></li>
							<li><a class="dropdown-item" href="/Incident">Incident</a></li>
							<li><a class="dropdown-item" href="/Infraction">Infraction</a></li>
							<li><a class="dropdown-item" href="/Lieu">Lieu</a></li>
							<li><a class="dropdown-item" href="/Mission">Mission</a></li>
							<li><a class="dropdown-item" href="/Suivi">Suivi</a></li>
							<li><a class="dropdown-item" href="/Trajet">Trajet</a></li>
							<li><a class="dropdown-item" href="/Type_incident">Type incident</a></li>
							<li><a class="dropdown-item" href="/User">Utilisateur</a></li>
							<li><a class="dropdown-item" href="/Vehicule">Véhicule</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="/Extraction">Extraction</a></li>
							<li><a class="dropdown-item" href="/Login/logout">Déconnexion</a></li>
						</ul>
					<?php endif; ?>

				</div>
			</div>
		<?php endif; ?>
	</div>
</nav>
