
<?= $this->extend('layouts/main') ?> <!-- Extend the base layout -->
<?= $this->section('content') ?> <!-- Start the main content section -->

<h3><strong>Les informations essentielles de l'activité</strong></h3>
</br>
<?php

const COUNT_ITEMS = 3;

function paginateNumber (&$count)
{
	if ($count < COUNT_ITEMS)
	{
		$count++;
		return true;
	}
	return false;
}

# Display usefull datas
function usefullDatas ($entity,$entity_name, $columns_entity, $message, $resetData=null, $valueResetData=null)
{
	if (empty($entity))
		return ?>

	<h4 id="<?= $entity_name ?>hideTitle" class="leftTitle" title="Cliquez pour afficher" onclick="hideDiv(['<?= $entity_name ?>hideTitle', '<?= $entity_name ?>hideDiv'])">▶ <?= $entity_name . ' : ' . $message ?></h4>
	<div id="<?= $entity_name ?>hideDiv" class="table-responsive" style="display:none;">
		<h4 class="leftTitle" title="Cliquez pour fermer" onclick="hideDiv(['<?= $entity_name ?>hideTitle', '<?= $entity_name ?>hideDiv'])">▼ <?= $entity_name . ' : ' . $message ?></h4>
		<!-- Display <?= $entity_name . ' ' . $message ?> -->
			<table class="table table-striped table-bordered mt-3">
				<?php entityColumns($entity,$entity_name, $columns_entity, $message,  $resetData, $valueResetData); ?>
			</table>
		<a href="<?= site_url(''.$entity_name.'') ?>" class="btn btn-secondary">Retour vers <?= $entity_name ?></a>
	</div>
	</br>
<?php
}

# Display datas columns
function entityColumns($entities, $entity_name, $columns_entity, $message, $resetData=null, $valueResetData=null)
{

	array_map(function($item) use ($columns_entity, $entity_name, $message, $resetData, $valueResetData)
	{
		static $count = 0;
		$html = '';
		if (paginateNumber($count))
		{

			$id = 0;

			if ($count == 1)
			{
				$html .= '<thead>'
					.'<tr>';

				foreach ($item as $c => $v) :
					if (in_array($c, $columns_entity)):
						$html .= '<th>'.$c.'</th>';
					endif;
				endforeach;

				if ($resetData)
				{
					$html .= '<th> Action </th>';
				}

				$html .= '</tr>'
					.'</thead>'
					.'<tbody>';
			}

			$html .= '<tr>';

			foreach ($item as $c => $v) :
				if ($c == 'id'):
					$id = $v;
				endif;
				if (in_array($c, $columns_entity)):
					$html .='<td data-label="'.$c.'">'.esc(ucfirst($v)).'</td>';
				endif;
			endforeach;

			if ($resetData)
			{
				$html .= '<td class="admin-button">'
				.'<form method="post" action="'. site_url(''.$entity_name.'/update/'.$id) .'">'
				.'<!-- Enabled account button -->'
				.'<input type="hidden" name="'.$resetData.'" id="'.$resetData.'" value="'.$valueResetData.'">'
				.'<!-- Redirection button -->'
				.'<input type="hidden" name="redirect_url" value="'. current_url() .'">'
				.'<button type="submit" class="btn btn-danger btn-sm"> Rétablir '.$entity_name.' </button>'
				.'</form>'
				.'</td>';
			}

			$html .='</tr>';

			if (COUNT_ITEMS == $count)
			{
				$html .= '</tbody>';
			}

			echo $html;
		}
	}, $entities);
}


usefullDatas($user, 'User', ['Conducteur'], 'Désactivé', 'actif', '1');
usefullDatas($ip, 'Ip', ['IP', 'Nombre échecs'], 'Désactivée', 'nb_echec', '0');
usefullDatas($vehicule, 'Vehicule', ['Plaque', 'Marque', 'Modèle'], 'Désactivé', 'actif', '1');
usefullDatas($lieu, 'Lieu', ['Surnom', 'Adresse'], 'Désactivé', 'actif', '1');
usefullDatas($infraction, 'Infraction', ['Plaque', 'Conducteur', 'Date', 'Points', 'Prix'], 'Récent');
usefullDatas($mission, 'Mission', ['Plaque', 'Conducteur', 'Motif', 'Lieu départ', 'Adresse départ', 'Début', 'Lieu arrivé', 'Adresse arrivé', 'Fin'], 'Récent');
usefullDatas($incident, 'Incident', ['Plaque', 'Conducteur', 'Type', 'Date'], 'Récent');
?>


<script src="<?php echo base_url('js/hideLayout.js'); ?>"></script>
<?= $this->endSection() ?> <!-- End the content section -->

