<?php

namespace App\Models;

use CodeIgniter\Model;

class ItineraireModel extends Model
{
	protected $table = 'itineraire';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Entities\Itineraire';
	protected $allowedFields = ['nom'];
}
