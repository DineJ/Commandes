<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\Validation\ValidationException;

/**
 * Class Trajet
 *
 * @property $id
 * @property $id_lieu_depart
 * @property $id_lieu_arrive
 * @property $date_debut
 * @property $date_arrivee
 * @property $motif
 * @property $km_depart
 * @property $km_arrive
 */
class Trajet extends Entity
{
	protected $casts = [
		'id' => 'integer',
		'id_lieu_depart' => 'integer',
		'id_lieu_arrive' => 'integer',
		'date_debut' => 'string',
		'date_arrivee' => 'string',
		'motif' => 'string',
		'km_depart' => 'integer',
		'km_arrive' => 'integer',
	];

	protected $validationRules = [
		'id' => 'integer|max_length[11]',
		'id_lieu_depart' => 'integer|max_length[11]',
		'id_lieu_arrive' => 'integer|max_length[11]',
		'date_debut' => 'string',
		'date_arrivee' => 'string',
		'motif' => 'string',
		'km_depart' => 'integer|max_length[11]',
		'km_arrive' => 'integer|max_length[11]',
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


	public function getidLieuDepart()
	{
		return $this->attributes['id_lieu_depart'] ?? null;
	}


	public function setidLieuDepart($idLieuDepart)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['id_lieu_depart' => 'integer']);

		if (!$validation->run(['id_lieu_depart' => $idLieuDepart])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'id_lieu_depart': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['id_lieu_depart'] = $idLieuDepart;
		return $this;
	}


	public function getidLieuArrive()
	{
		return $this->attributes['id_lieu_arrive'] ?? null;
	}


	public function setidLieuArrive($idLieuArrive)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['id_lieu_arrive' => 'integer']);

		if (!$validation->run(['id_lieu_arrive' => $idLieuArrive])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'id_lieu_arrive': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['id_lieu_arrive'] = $idLieuArrive;
		return $this;
	}


	public function getdateDebut()
	{
		return $this->attributes['date_debut'] ?? null;
	}


	public function setdateDebut($dateDebut)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['date_debut' => 'string']);

		if (!$validation->run(['date_debut' => $dateDebut])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'date_debut': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['date_debut'] = $dateDebut;
		return $this;
	}


	public function getdateArrivee()
	{
		return $this->attributes['date_arrivee'] ?? null;
	}


	public function setdateArrivee($dateArrivee)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['date_arrivee' => 'string']);

		if (!$validation->run(['date_arrivee' => $dateArrivee])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'date_arrivee': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['date_arrivee'] = $dateArrivee;
		return $this;
	}


	public function getmotif()
	{
		return $this->attributes['motif'] ?? null;
	}


	public function setmotif($motif)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['motif' => 'string']);

		if (!$validation->run(['motif' => $motif])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'motif': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['motif'] = $motif;
		return $this;
	}


	public function getkmDepart()
	{
		return $this->attributes['km_depart'] ?? null;
	}


	public function setkmDepart($kmDepart)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['km_depart' => 'integer']);

		if (!$validation->run(['km_depart' => $kmDepart])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'km_depart': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['km_depart'] = $kmDepart;
		return $this;
	}


	public function getkmArrive()
	{
		return $this->attributes['km_arrive'] ?? null;
	}


	public function setkmArrive($kmArrive)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(['km_arrive' => 'integer']);

		if (!$validation->run(['km_arrive' => $kmArrive])) {
			throw new \InvalidArgumentException("❌ Valeur invalide pour 'km_arrive': " . implode(', ', $validation->getErrors()));
		}

		$this->attributes['km_arrive'] = $kmArrive;
		return $this;
	}

}
