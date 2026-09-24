<?php

namespace App\Models;

use CodeIgniter\Model;

class TrajetModel extends Model
{
	protected $table = 'trajet';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Entities\Trajet';
	protected $allowedFields = ['id_itineraire', 'id_lieu_depart', 'id_lieu_arrive', 'ordre', 'date_debut', 'date_arrivee', 'motif', 'km_depart', 'km_arrive'];

	public function getEnumValues($columnName)
	{

		// Get ENUM values from specified column
		$query = $this->db->query("SHOW COLUMNS FROM {$this->table} LIKE ?",[$columnName]);
		$row = $query->getRow();

		// Extract values of the ENUM
		preg_match("/^enum\((.*)\)$/", $row->Type, $matches);

		// Conversion in a PHP array
		return str_getcsv($matches[1], ',', "'");
	}
}
