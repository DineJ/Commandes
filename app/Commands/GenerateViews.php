<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class GenerateViews extends BaseCommand
{
	protected $primaryKey = '';
	protected $group       = 'custom';
	protected $name        = 'generate:views';
	protected $description = 'Génère automatiquement les vues CRUD avec validation JS dynamique.';
	protected $searchs = array();
	protected $enum_values = array();
	protected $db = null;

	public function run(array $params)
	{
		if (empty($params))
		{
			CLI::error("❌ Veuillez spécifier le nom de l'entité.");
			return;
		}

		$entityName = ucfirst($params[0]);
		if (isset($params[1]))
		{
			$this->searchs = explode(',',$params[1]);
		}

		$modelName = "App\\Models\\" . $entityName . "Model";
		$folderPath = "../app/Views/{$entityName}";
        $layoutsPath = "../app/Views/layouts";
	    $cssPath = "../public/css";

		// Vérifier si l'entité existe
		if (!file_exists("../app/Entities/$entityName.php"))
		{
			CLI::error("❌ L'entité '$entityName' n'existe pas.");
			return;
		}

		// Vérifier si le modèle existe
		if (!class_exists($modelName))
		{
			CLI::error("❌ Le modèle '$modelName' n'existe pas.");
			return;
		}

		// Instancier dynamiquement le modèle
		$model = new $modelName();
		$this->db = Database::connect();
		//$query = $this->db->query("SHOW COLUMNS FROM permis WHERE Field LIKE 'permis_type';");
		$table = $model->table;
		$fields = $this->db->getFieldData($table);

		if (!$fields)
		{
			CLI::error("❌ Impossible de récupérer les champs de la table '$table'.");
			return;
		}

		// Get primarykey's name
		foreach ($fields as $field)
		{
			if ($field->primary_key)
				$this->primaryKey = $field->name;
		}

		// Créer le dossier des vues s'il n'existe pas
		if (!is_dir($folderPath))
		{
			mkdir($folderPath, 0777, true);
		}


		// Générer les fichiers de vues
		if (!file_exists($layoutsPath))
		{

			if (!is_dir($layoutsPath))
			{
				mkdir($layoutsPath, 0777, true);
			}

			if (!is_dir($cssPath))
			{
				mkdir($cssPath, 0777, true);
			}

			file_put_contents("$cssPath/main.css", $this->generateCss());
			file_put_contents("$layoutsPath/main.php", $this->generateLayout());
		}

		file_put_contents("$folderPath/index.php", $this->generateIndexView($entityName, $fields));
		file_put_contents("$folderPath/show.php", $this->generateShowView($entityName, $fields));
		file_put_contents("$folderPath/create.php", $this->generateFormView($entityName, $fields, 'create'));
		file_put_contents("$folderPath/edit.php", $this->generateFormView($entityName, $fields, 'edit'));

		CLI::write("✅ Vues générées dans : app/Views/$entityName", 'green');
	}
	
	private function isPrimaryKey($f)
	{
		return ($f->primary_key == 1);
	}

	private function allForm ($f, $type)
	{
		if ($this->isPrimaryKey($f))
			return "";

		switch ($type) 
		{
			case $f->primary_key == 1:
				$r = $this->deleteId($f->primary_key);
				break;

			case 'columns':
				$r = "	<th>$f->name</th>\n			";
				break;

			case 'rows':
				$r = "					<td data-label=\"{$f->name}\"><?= esc(\$item->{$f->name}) ?></td>\n";
				break;

			case 'details':
				{
				if ($f->type == 'tinyint')
					$r = "\n			<!-- Display $f->name -->\n			<tr>\n				<td class=\"td-hidden\">$f->name</td>\n				<td data-label=\"{$f->name}\"><?= \$item->{$f->name} ? 'Oui' : 'Non' ?></td>\n			</tr>\n";
				else
					$r = "\n			<!-- Display $f->name -->\n			<tr>\n				<td class=\"td-hidden\">$f->name</td>\n				<td data-label=\"{$f->name}\"><?= \$item->{$f->name} ?></td>\n			</tr>\n";
				}
				break;
		}
		return $r;
	}

	private function makeSearchBar($searchs, $entityName)
	{
		$searchBar = "";
		if (count($searchs) == 0)
			return "";
		else
		{
			$seachBar = '<!-- Search bar -->'."\n".
						'<form method="get" action="<?= site_url("'.$entityName.'") ?>" class="mb-3">'."\n".
						'	<div class="input-group">'."\n".
						'		<input type="text" name="q" class="form-control" placeholder="Rechercher..." value="<?= isset($search) ?  esc($search) : \'\' ?>">'."\n".
						'		<button type="submit" class="btn btn-primary">Rechercher</button>'."\n\n".
						'		<!-- Reset search bar -->'."\n".
						'		<?php if (!empty($search)) : ?>'."\n".
						'			<a href="<?= site_url(\'' . $entityName . '\') ?>" class="btn btn-outline-secondary">Réinitialiser</a>'."\n".
						'		<?php endif; ?>'."\n".
						'	</div>'."\n".
						'</form>'."\n";
		}
		return $seachBar;
	}

	private function generateIndexView($entityName, $fields)
	{
		$columns = implode(array_map(fn($f) => $this->allForm($f,'columns'), $fields));
		$rows = implode(array_map(fn($f) => $this->allForm($f,'rows'), $fields));
		$searchBar = $this->makeSearchBar($this->searchs, $entityName);

		return <<<EOD
<?= \$this->extend('layouts/main') ?>
<?= \$this->section('content') ?>

<h2>Liste des {$entityName}s</h2>
<a href="<?= site_url('$entityName/create') ?>" class="btn btn-success">Ajouter</a>

$searchBar

<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">

		<!-- Datas name -->
		<thead>
			<tr>
			$columns	<th>Actions</th>
			</tr>
		</thead>

		<tbody>
			<!-- Display datas -->
			<?php foreach (\$items as \$item): ?>
				<tr>
$rows
					<td>
						<!-- Redirection button -->
						<a href="<?= site_url('$entityName/show/'.\$item->{$this->primaryKey}) ?>" class="btn btn-info btn-sm">Voir</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>


<!-- Pager -->
<?php if (\$pager->getPageCount() > 1)\n	 { ?>
	<nav aria-label="Page navigation example">
		<ul class="pagination">

			<!-- Button for previous page -->
			<li class="page-item <?= \$pager->getCurrentPage() != 1 ? '' : 'disabled' ?>"><a class="page-link" href="<?= \$pager->getPreviousPageURI() ?>">Précédent</a></li>

			<?php
				// \$count = total number of pages, \$cur = current page, \$nb_page = pages shown around current, \$v1 = before, \$v2 = after
				\$count = \$pager->getPageCount();
				\$cur = \$pager->getCurrentPage();
				\$nb_page = 1;
				\$v1 = \$cur - \$nb_page;
				\$v2 = \$cur + \$nb_page;

				if (\$v1 < 1)
				{
					\$v1 = 1;
				}

				if (\$v2 > \$count)
				{
					\$v2 = \$count;
				}

				// Display the correct number of pages
				for (\$value = \$v1 ; \$value <= \$v2; \$value++ )
				{
					echo '<li '.(\$cur == \$value ? 'class="active"' : 'class="page-item"' ).'><a class="page-link" href="'.\$pager->getPageURI(\$value).'">'.\$value.'</a></li>';
				}
				?>

			<!-- Button for next page -->
			<li class="page-item <?= \$pager->hasMore() ? '' : 'disabled' ?>"><a class="page-link" href="<?= \$pager->getNextPageURI() ?>">Suivant</a></li>
		  </ul>
	</nav>
<?php } ?>

<?= \$this->endSection() ?>
EOD;
	}

	private function generateShowView($entityName, $fields)
	{
		$details = '';
		$bouton = '';
		foreach ($fields as $field)
		{
			$details .= $this->allForm($field,'details');
			if ($field->name == 'actif')
			{
				$bouton = '<input type="hidden" name="actif" id="actif" value="<?= $item->actif ? 0 : 1 ?>">'. "\n		"
						.'<button type="submit" class="btn <?= $item->actif ? \'btn-danger\' : \'btn-success\' ?>"> '
						.'<?= $item->actif ? \'Rendre inactif\' : \'Rendre actif\' ?></button>';
			}
		}

		return <<<EOD
<?= \$this->extend('layouts/main') ?>
<?= \$this->section('content') ?>

<div class="container mt-5">
<h2>Détails de {$entityName}</h2>

<div class="table-responsive">
	<table class="table table-striped table-bordered mt-3">
		<tbody>
$details		</tbody>
	</table>
</div>


<div>
	<form method="post" action="<?= site_url('$entityName/update/'.\$item->{$this->primaryKey}) ?>">

		<!-- Redirection button to edit user form -->
		<a href="<?= site_url('$entityName/edit/'.\$item->{$this->primaryKey}) ?>" class="btn btn-warning">Modifier</a>

		<!-- Disabled account button -->
		$bouton
	</form>
</div>
</br>

<!-- Redirection button -->
<a href="<?= site_url('$entityName') ?>" class="btn btn-secondary">Retour</a>
<?= \$this->endSection() ?>
EOD;
	}

	private function getOptions($field, $entityName)
	{
		$options = "";

		// Convert entity name to database table name
		$tableName = strtolower($entityName);

		$query = $this->db->query("SHOW COLUMNS FROM {$tableName} WHERE Field = ?",[$field->name]);
		$row = $query->getRow();
		preg_match("/^enum\(\'(.*)\'\)$/", $row->Type, $matches);
		$enum_values = $this->enum_values = explode("','", $matches[1]);

		foreach ($enum_values as $value) {
			$options .= "			<option value={$value}>$value</option>\n";
		}
		return $options;
	}

	private function messageArray($field, $entityName)
	{
		return match($field->type)
		{
			'text' 		=> "\n	<!-- Type a short explication -->\n	<label>{$field->name}</label>\n	<textarea onchange=\"setUpper(document.getElementById('{$field->name}'));\" id=\"{$field->name}\" name=\"{$field->name}\" class=\"form-control\"><?= isset(\$item) ? \$item->{$field->name} : '' ?></textarea>\n",
			'enum' 		=> "\n	<!-- Select value -->\n	<label>{$field->name}</label>\n	<div>\n		<select id=\"{$field->name}\" name=\"{$field->name}\" class=\"form-control\" required>\n			<option value=\"\" disabled selected hidden> Choississez une option </option>\n".$this->getOptions($field, $entityName)."		</select>\n	</div>\n",
			'date' 		=> "\n	<!-- Type date -->\n	<label>{$field->name}</label>\n	<input type=\"date\" id=\"{$field->name}\" name=\"{$field->name}\" value=\"<?= isset(\$item) ? \$item->{$field->name} : '' ?>\" class=\"form-control\" required>\n",
			'datetime' 	=> "\n	<!-- Type date -->\n	<label>{$field->name}</label>\n	<input type=\"date\" id=\"{$field->name}\" name=\"{$field->name}\" value=\"<?= isset(\$item) ? \$item->{$field->name} : '' ?>\" class=\"form-control\" required>\n",
			'int' 		=> "\n	<!-- Type number -->\n	<label>{$field->name}</label>\n	<input type=\"number\" id=\"{$field->name}\" name=\"{$field->name}\" value=\"<?= isset(\$item) ? \$item->{$field->name} : '' ?>\" class=\"form-control\" required>\n",
			'tinyint' 	=> "\n	<!-- Check your $field->name -->\n	<label>{$field->name}</label>\n	<div>\n		<input type=\"checkbox\" id=\"{$field->name}\" name=\"{$field->name}\" value=\"1\" <?= (isset(\$item) && \$item->{$field->name}) ? 'checked' : '' ?>>\n	</div>\n",
			'password'	=> "\n	<!-- Type password -->\n	<label>{$field->name}</label>\n	<input type=\"password\" id=\"{field->name}\" name=\"{field->name}\" class=\"form-control\" minlength=\"16\" maxlength=\"32\" placeholder=\"Mot de passe requi entre 16 et 32 caractères\" required>\n",
			default 	=> "\n	<!-- Type $field->name -->\n	<label>{$field->name}</label>\n	<input type=\"text\" onchange=\"setUpper(document.getElementById('{$field->name}'));\" id=\"{$field->name}\" name=\"{$field->name}\" value=\"<?= isset(\$item) ? \$item->{$field->name} : '' ?>\" class=\"form-control\" required>\n",
		};
	}

	private function generateFormView($entityName, $fields, $type)
	{
		$action = $type === 'create' ? "'$entityName/store/'" : "'$entityName/update/'.\$item->{$this->primaryKey}";
		$inputs = "";
		$validationJS = "";
		$row = 0;
		$onsubmit = '';
		$startfunction = '';
		foreach ($fields as $field) 
		{
			 // Ignore la clé primaire
			if ($field->name == $this->primaryKey)
			{
				continue;
			}

			// Génération des inputs HTML
			$inputs .= $this->messageArray($field, $entityName);
			if ($type != 'create')
			{
				$inputs .= "	<input type=\"hidden\" id=\"old{$field->name}\" name=\"old{$field->name}\" value=\"<?= isset(\$item) ? \$item->$field->name : '' ?>\">\n";
				if ($field->type == 'tinyint')
					$validationJS .= 	"		// Get values\n		let {$field->name} = (document.getElementById('{$field->name}').checked ? 1 : 0 );\n";
				else
					$validationJS .=	"		// Get values\n		let {$field->name} = document.getElementById('{$field->name}').value;\n";

				$validationJS .= 	"		let old{$field->name} = document.getElementById('old{$field->name}').value;\n".
									"		row++;\n\n".
									"		// Check values \n".
									"		if ({$field->name} == old{$field->name})\n		{\n".
									"			compare++;\n".
									"		}\n\n";
			}
		}
		if ($type != 'create') {
			$onsubmit = ' onsubmit="return validateForm()"';
			$startfunction =	''."\n\n".
								'	function validateForm()'."\n".
								'	{'."\n\n".
								'		// Count'."\n".
								'		let compare = 0;'."\n".
								'		let row = 0;'."\n\n".
								$validationJS.
								'		// Check counts'."\n".
								'		if (compare == row)'."\n".
								'		{'."\n".
								'			alert("les valeurs sont identiques");'."\n".
								'			return false;'."\n".
								'		}'."\n".
								'		return true;'."\n".
								'	}';
		}
		return <<<EOD
<?= \$this->extend('layouts/main') ?>
<?= \$this->section('content') ?>

<h2>{$entityName} - <?= \$title ?></h2>

<form method="post" action="<?= site_url($action) ?>"{$onsubmit}>
$inputs
	<!-- Redirection button -->
	<a href="<?= site_url('$entityName') ?>" class="btn btn-secondary mt-3">Retour</a>
	<button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>


<script>
	// Caps text
	function setUpper(element)
	{
		element.value=element.value.toUpperCase();
	}$startfunction
</script>

<?= \$this->endSection() ?>
EOD;
	}


	private function generateLayout()
	{
		return <<<EOD
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= \$title ?? 'Mon Site' ?></title> <!-- Page title (fallback to "Mon Site" if \$title is not set) -->

	<!-- Bootstrap CSS for styling -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url('css/main.css') ?>">

</head>
<body class="<?= \$page ?? '' ?>">

	<!-- Main page content container -->
	<div class="container mt-5">
		<?= \$this->renderSection('content') ?> <!-- Content from each specific page -->
	</div>

	<!-- Bootstrap JS bundle for interactivity -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
EOD;
	}

	private function generateCss()
	{
		return <<<EOD
/* Responsive table layout: display rows as cards on small screens */
@media only screen and (max-width: 700px) {

	/* Transform all table elements into block layout to stack vertically */
	.table-responsive table,
	.table-responsive thead,
	.table-responsive tbody,
	.table-responsive tr,
	.table-responsive th,
	.table-responsive td {
		display: block;
		width: 100%;
	}

	/* Optional: reduce default spacing to make cards more compact */
	.table-responsive tr {
		padding: 0;                      /* Less padding to keep it compact */
	}

	/* Hide the table header (labels will be shown via ::before) */
	.table-responsive thead {
		display: none;
	}

	/* Style individual table cells for card layout */
	.table-responsive td {
		position: relative;                         /* Needed for positioning ::before */
		padding: 0.75rem 0.75rem 0.25rem 140px;     /* Padding with space on the left for label */
		border: none;
		background: white;
		line-height: 1.2;                           /* Reduce line spacing */
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;                        /* Optional: force text to stay on one line */
	}

	/* Display the data-label as a label on the left side */
	.table-responsive td::before {
		content: attr(data-label);             /* Use the data-label attribute for the label */
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;                         /* Match the height of the cell */
		width: 120px;                         /* Label column width */
		color: rgb(0, 0, 0);
		padding: 0.75rem;
		font-size: 0.9rem;
		font-weight: bold;
		display: flex;
		align-items: center;                  /* Vertically center the text */
		justify-content: flex-start;
		border-top-left-radius: 0.25rem;
		border-bottom-left-radius: 0.25rem;
		line-height: 1.1;
	}

	.table-bordered > :not(caption) > * {
		border-width: 0;
	}

	.td-hidden {
		display: none !important;
	}
}
EOD;

	}
}

