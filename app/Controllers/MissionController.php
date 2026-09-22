<?php

namespace App\Controllers;

use App\Models\MissionModel;
use App\Models\VehiculeModel;
use App\Models\UserModel;
use App\Models\LieuModel;
use App\Models\InfractionModel;
use App\Models\IncidentModel;
use App\Models\TrajetModel;
use App\Entities\Mission;
use CodeIgniter\Controller;

class MissionController extends Controller
{
	protected $model;

	public function __construct()
	{
		$this->model = new MissionModel();
		$this->vehiculeModel = new VehiculeModel();
		$this->userModel = new UserModel();
		$this->lieuModel = new LieuModel();
		$this->infractionModel = new InfractionModel();
		$this->incidentModel = new IncidentModel();
		$this->trajetModel = new TrajetModel();
	}

	// SEARCH BAR
	public function index()
	{
		$search = $this->request->getGet('q');

		// Query to get datas from other table
		$builder = $this->model->select('mission.id, vehicule.plaque, CONCAT(user.nom, " ", user.prenom) AS conducteur, l1.nom_lieu AS nom_lieu_depart, l1.numero AS numero_depart, l1.adresse AS adresse_depart, l2.numero AS numero_arrive, l2.adresse AS adresse_arrivee, l2.nom_lieu AS nom_lieu_arrive, trajet.motif, trajet.date_debut, trajet.date_arrivee, trajet.km_depart, trajet.km_arrive')
			 ->join('vehicule', 'vehicule.id = mission.id_vehicule', 'left')
			 ->join('user', 'user.id = mission.id_user', 'left')
			 ->join('trajet', 'trajet.id = mission.id_trajet', 'left')
			 ->join('lieu l1', 'l1.id = trajet.id_lieu_depart', 'left')
			 ->join('lieu l2', 'l2.id = trajet.id_lieu_arrive', 'left')
			 ->orderBy('trajet.date_debut', 'DESC');

		if ($search)
		{
			$builder->groupStart()
				->like('vehicule.plaque', $search)
				->orLike('CONCAT(user.nom, " ", user.prenom)', $search)
				->orLike('DATE_FORMAT(trajet.date_debut, "%d/%m/%Y")', $search)
				->groupEnd();

			$builder->orderBy('trajet.date_debut', 'DESC');
		}
		else
		{
			$this->model->orderBy('id_vehicule');
		}
		$data['search'] = $search;
		$data['items'] = $builder->paginate(20); // Display 20 results
		$data['pager'] = $builder->pager; // Add pager

		return view('Mission/index', $data);
	}


	// DISPLAY AN ELEMENT
	public function show($id)
	{
		//load helper
		helper('section');

		// Get Datas
		$data['item'] = $this->model->find($id);
		$data['infractions'] = $this->infractionModel->where('infraction.id_mission', $id)->find($data['item']->id_mission);
		$data['vehicule'] = $this->vehiculeModel->find($data['item']->id_vehicule);
		$data['utilisateur'] = $this->userModel->find($data['item']->id_user);
		$data['trajet'] = $this->trajetModel->find($data['item']->id_trajet);
		$data['lieuDepart'] = $this->lieuModel->find($data['trajet']->id_lieu_depart);
		$data['lieuArrive'] = $this->lieuModel->find($data['trajet']->id_lieu_arrive);

		return view('Mission/show', $data);
	}

	// INSERT INTO DATABASE
	public function store()
	{
		$data = $this->request->getPost();
		$entity = new Mission();
		$entity->fill($data);

		if (!$this->model->insert($entity))
		{
			return redirect()->back()->with('error', 'Erreur lors de l\'ajout.');
		}
		
		if (session()->get('user')['admin'])
		{
			return redirect()->to('/Mission');
		}
		else
		{
			return redirect()->to('/Non_admin');
		}
	}


	// MODIFICATION FORM
	public function edit($id)
	{
		$data['item'] = $this->model->find($id);
		$data['utilisateurs'] = $this->userModel->findAll();
		$data['vehicules'] = $this->vehiculeModel->findAll();
		$data['lieuxDepart'] = $this->lieuModel->findAll();
		$data['lieuxArrive'] = $this->lieuModel->findAll();
		$data['trajet'] = $this->trajetModel->find($data['item']->id_trajet);
		$data['motifs'] = $this->trajetModel->getMotifEnum();
		$data['title'] = "Modifier Mission";
		return view('Mission/edit', $data);
	}


	// UPDATE DATABASE
	public function update($id)
	{
		// Retrieve submitted form data
		$data = $this->request->getPost();

		// Get the mission
		$mission = $this->model->find($id);

		// List of mission fields that can be updated
		$missionFields = ['id_user','id_vehicule'];

		// Flag
		$missionUpdated = false;

		foreach ($missionFields as $field)
		{
			// Update the field only if the new value is different
			if (isset($data[$field]) && $mission->$field != $data[$field])
			{
				$mission->$field = $data[$field];
				$missionUpdated = true;
			}
		}

		// Save the mission only if at least one field has changed
		if ($missionUpdated)
		{
			$this->model->save($mission);
		}

		// Get the journey
		$trajet = $this->trajetModel->find($mission->id_trajet);

		// List of trajet fields that can be updated
		$trajetFields = ['id_lieu_depart','id_lieu_arrive','motif','km_depart','km_arrive'];

		// Flag
		$trajetUpdated = false;

		foreach ($trajetFields as $field)
		{
			// Update the field only if the new value is different
			if (isset($data[$field]) && $trajet->$field != $data[$field])
			{
				$trajet->$field = $data[$field];
				$trajetUpdated = true;
			}
		}

		// Save the trajet only if at least one field has changed
		if ($trajetUpdated)
		{
			$this->trajetModel->save($trajet);
		}

		// Redirect back to the mission list
		return redirect()->to('/Mission');
	}

	// DELETE AN ELEMENT
	public function delete($id)
	{
		$this->model->delete($id);
		return redirect()->to('/Mission');
	}

	// START A MISSION AS USER
	public function debut()
	{
		// Get lastest mission for EACH vehicles
		$data['vehicules'] = $this->vehiculeModel
					  ->select('vehicule.plaque, vehicule.id, COALESCE(trajet.km_arrive,0) AS km_depart')
					  ->join('mission', 'mission.id = (
														SELECT MAX(m2.id)
														FROM mission m2
														WHERE m2.id_vehicule = vehicule.id)',
														'left',false)
					  ->join('trajet', 'trajet.id = mission.id_trajet', 'left')
					  ->findAll();

		$data['lieux'] = $this->lieuModel->findAll();
		$data['motifs'] = $this->trajetModel->getMotifEnum();
		$data['item'] = $this->model;

		$missionsPending = $this->model
			->select('mission.id_user, mission.id_vehicule, CONCAT(user.nom, " ", user.prenom) AS conducteur')
			->join('user', 'user.id = mission.id_user', 'left')
			->join('trajet', 'trajet.id = mission.id_trajet', 'left')
			->where('trajet.date_debut = trajet.date_arrivee', null, false)
			->findAll();

		$vehiclesUsed = [];

		foreach ($missionsPending as $mission) {
			$vehiclesUsed[$mission->id_vehicule] = $mission->conducteur;
		}

		$data['vehiclesUsed'] = $vehiclesUsed;

		$redirection = $this->model
			->select('trajet.date_debut, trajet.date_arrivee')
			->join('trajet', 'trajet.id = mission.id_trajet', 'left')
			->where('mission.id_user', session()->get('user')['id'])
			->where('trajet.date_debut = trajet.date_arrivee', null, false)
			->findAll();

		if($redirection)
		{
			return redirect()->to('/Non_admin');
		}

		return view('Mission/start', $data);
	}

	// End current mission and start a new mission to go the starting point
	public function renew($id)
	{
		// Catch the date
		$date = date('Y-m-d H:i:s');
		$entity = $this->model->find($id);

		// Duplicate object
		$entityClone = clone $entity;
		// Unset ID, it's auto increment in the DB
		unset($entityClone->id);

		// Use getter and setter
		$km = $entity->getkmArrive();
		# $entity->setkmArrive($km);
		$entity->setdateArrivee($date);

		// Use getter and setter
		$entityClone->setkmDepart($km);
		$entityClone->setkmArrive(($km+1));
		$entityClone->setdateDepart($date);
		$entityClone->setdateArrivee($date);

		// Get previsous and next location
		$laClone = $entityClone->getidLieuArrive();
		$leClone = $entityClone->getidLieuDepart();

		// Swap location
		$entityClone->setidLieuArrive($leClone);
		$entityClone->setidLieuDepart($laClone);

		if (!$this->model->save($entity))
		{
			return redirect()->back()->with('error', 'Erreur lors de la mise à jour.');
		}

		if (!$this->model->insert($entityClone))
		{
			return redirect()->back()->with('error', 'Erreur lors de l\'ajout.');
		}

		if (session()->get('user')['admin'])
		{
			return redirect()->to('/Mission');
		}
		else
		{
			return redirect()->to('/Non_admin');
		}

		return redirect()->to('/Mission');
	}

	public function checkEntretien($idVehicule)
	{
		// Request to get lastest checking
		$incident = $this->incidentModel
			->where('id_vehicule', $idVehicule)
			->where('id_type_incident', 1)
			->orderBy('date_incident', 'DESC')
			->first();

		// No incident found
		if (!$incident) {
			return $this->response->setJSON([
				'warning' => true
			]);
		}

		$dateIncident = is_array($incident)
			? $incident['date_incident']
			: $incident->date_incident;

		// Conversion date to DateTime
		$dateEntretien = new \DateTime($dateIncident);
		$today = new \DateTime();

		// Compare current date and the date of the lastest checking
		$diff = $today->diff($dateEntretien)->days;

		// Return for JS
		return $this->response->setJSON([
			'warning' => $diff > 7,
			'date_entretien' => $dateEntretien->format('d/m/Y'),
			'days' => $diff
		]);
	}


	public function checking($idVehicule)
	{
		//load helper
		helper('checking_form');
		$data['vehicule'] = $this->vehiculeModel->find($idVehicule);

		return view('Mission/checking', $data);
	}
}
