<?php

namespace App\Models;

use CodeIgniter\Model;

class TrajetModel extends Model
{
	protected $table = 'trajet';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Entities\Trajet';
	protected $allowedFields = ['id_lieu_depart', 'id_lieu_arrive', 'date_debut', 'date_arrivee', 'motif', 'km_depart', 'km_arrive'];
}
