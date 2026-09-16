<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\Validation\ValidationException;

/**
 * Class Mission
 *
 * @property $id
 * @property $id_vehicule
 * @property $id_user
 * @property $id_trajet
 */
class Mission extends Entity
{
	protected $casts = [
		'id' => 'integer',
		'id_vehicule' => 'integer',
		'id_user' => 'integer',
		'id_trajet' => 'integer',
	];

	protected $validationRules = [
		'id' => 'integer|max_length[11]',
		'id_vehicule' => 'integer|max_length[11]',
		'id_user' => 'integer|max_length[11]',
		'id_trajet' => 'integer|max_length[11]',
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


	public function getidVehicule()
	{
		return $this->attributes['id_vehicule'] ?? null;
	}


	public function setidVehicule($idVehicule)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['id_vehicule' => 'integer']);

		if (!$validation->run(['id_vehicule' => $idVehicule])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'id_vehicule': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['id_vehicule'] = $idVehicule;
		return $this;
	}


	public function getidUser()
	{
		return $this->attributes['id_user'] ?? null;
	}


	public function setidUser($idUser)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['id_user' => 'integer']);

		if (!$validation->run(['id_user' => $idUser])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'id_user': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['id_user'] = $idUser;
		return $this;
	}


	public function getidTrajet()
	{
		return $this->attributes['id_trajet'] ?? null;
	}


	public function setidTrajet($idTrajet)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['id_trajet' => 'integer']);

		if (!$validation->run(['id_trajet' => $idTrajet])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'id_trajet': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['id_trajet'] = $idTrajet;
		return $this;
	}

}
