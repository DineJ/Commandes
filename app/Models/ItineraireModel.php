<?php

namespace App\Models;

use CodeIgniter\Model;

class ItineraireModel extends Model
{
	protected $table = 'itineraire';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Entities\Itineraire';
	protected $allowedFields = ['nom', 'motif'];

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
