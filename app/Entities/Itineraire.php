<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\Validation\ValidationException;

/**
 * Class Itineraire
 *
 * @property $id
 * @property $nom
 */
class Itineraire extends Entity
{
	protected $casts = [
		'id' => 'integer',
		'nom' => 'string',
	];

	protected $validationRules = [
		'id' => 'integer|max_length[11]',
		'nom' => 'string|max_length[100]',
	];


	public function getid()
	{
		return $this->attributes['id'] ?? null;
	}


	public function setid($id)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['id' => 'integer']);

		if (!$validation->run(['id' => $id])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'id': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['id'] = $id;
		return $this;
	}


	public function getnom()
	{
		return $this->attributes['nom'] ?? null;
	}


	public function setnom($nom)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['nom' => 'string']);

		if (!$validation->run(['nom' => $nom])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'nom': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['nom'] = $nom;
		return $this;
	}

}
