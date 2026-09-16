<?php

namespace App\Models;

use CodeIgniter\Model;

class MissionModel extends Model
{
	protected $table = 'mission';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Entities\Mission';
	protected $allowedFields = ['id_vehicule', 'id_user', 'id_trajet'];

	public function getMotifEnum()
	{

		// Get ENUM values
		$query = $this->db->query("SHOW COLUMNS FROM {$this->table} LIKE 'motif'");
		$row = $query->getRow();

		// Extract values of the ENUM
		preg_match("/^enum\((.*)\)$/", $row->Type, $matches);

		// Conversion in a PHP array
		return str_getcsv($matches[1], ',', "'");
	}
}
