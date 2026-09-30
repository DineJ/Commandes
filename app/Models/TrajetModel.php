<?php

namespace App\Models;

use CodeIgniter\Model;

class TrajetModel extends Model
{
	protected $table = 'trajet';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Entities\Trajet';
	protected $allowedFields = ['id_itineraire', 'id_lieu_depart', 'id_lieu_arrive', 'ordre'];
}
