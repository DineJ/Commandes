<?php

namespace App\Controllers;

use App\Models\MissionModel;
use App\Models\VehiculeModel;
use App\Models\UserModel;
use App\Models\LieuModel;
use App\Models\InfractionModel;
use App\Models\IncidentModel;
use App\Models\TrajetModel;
use App\Models\ItineraireModel;
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
		$this->itineraireModel = new ItineraireModel();
	}

	// SEARCH BAR
	public function index()
	{
		// Get the search query from the URL
		$search = $this->request->getGet('q');

		// Build the query to retrieve missions
		$builder = $this->model->select('mission.id,premier.id AS id_trajet,vehicule.plaque,CONCAT(user.nom, " ", user.prenom) AS conducteur,l1.nom_lieu AS nom_lieu_depart,l1.numero AS numero_depart,l1.adresse AS adresse_depart,l2.nom_lieu AS nom_lieu_arrive,l2.numero AS numero_arrive,l2.adresse AS adresse_arrivee,itineraire.motif,mission.date_debut,mission.date_arrivee,mission.km_depart,mission.km_arrive')
			->join('vehicule', 'vehicule.id = mission.id_vehicule', 'left')
			->join('user', 'user.id = mission.id_user', 'left')
			->join('itineraire', 'itineraire.id = mission.id_itineraire', 'left')

			// Retrieve the first trajet of each itinerary
			->join(
				'trajet AS premier',
				'premier.id_itineraire = itineraire.id AND premier.ordre = (
					SELECT MIN(t1.ordre)
					FROM trajet AS t1
					WHERE t1.id_itineraire = itineraire.id
				)',
				'left',
				false
			)
			// Retrieve the last trajet of each itinerary
			->join(
				'trajet AS dernier',
				'dernier.id_itineraire = itineraire.id AND dernier.ordre = (
					SELECT MAX(t2.ordre)
					FROM trajet AS t2
					WHERE t2.id_itineraire = itineraire.id
				)',
				'left',
				false
			)
			// Retrieve the departure location of the first trajet
			->join('lieu AS l1', 'l1.id = premier.id_lieu_depart', 'left')
			// Retrieve the arrival location of the last trajet
			->join('lieu AS l2', 'l2.id = dernier.id_lieu_arrive', 'left')
			// Sort missions by departure date
			->orderBy('mission.date_debut', 'DESC');

		if ($search)
		{
			$builder->groupStart()
				->like('vehicule.plaque', $search)
				->orLike('CONCAT(user.nom, " ", user.prenom)', $search)
				->orLike('DATE_FORMAT(mission.date_debut, "%d/%m/%Y")', $search)
				->groupEnd();
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

		// Get all trajets with departure and arrival locations
		$data['trajets'] = $this->trajetModel
			->select('trajet.*, l1.surnom AS depart, l2.surnom AS arrivee')
			->join('lieu AS l1', 'l1.id = trajet.id_lieu_depart')
			->join('lieu AS l2', 'l2.id = trajet.id_lieu_arrive')
			->where('trajet.id_itineraire', $data['item']->id_itineraire)
			->orderBy('trajet.ordre', 'ASC')
			->findAll();

		$data['infractions'] = $this->infractionModel->where('infraction.id_mission', $id)->findAll();
		$data['itineraire'] = $this->itineraireModel->find($data['item']->id_itineraire);
		$data['vehicule'] = $this->vehiculeModel->find($data['item']->id_vehicule);
		$data['utilisateur'] = $this->userModel->find($data['item']->id_user);
		$data['lieuDepart'] = $this->lieuModel->find($data['trajets'][0]->id_lieu_depart);
		$data['lieuArrive'] = $this->lieuModel->find(end($data['trajets'])->id_lieu_arrive);

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
		// Get datas
		$data['item'] = $this->model->find($id);
		$data['utilisateurs'] = $this->userModel->findAll();
		$data['vehicules'] = $this->vehiculeModel->findAll();
		$data['itineraires'] = $this->itineraireModel->findAll();
		$data['motifs'] = $this->itineraireModel->getEnumValues('motif');
		$data['itineraire'] = $this->itineraireModel->find($data['item']->id_itineraire);
		$data['lieux'] = $this->lieuModel->findAll();
		$data['title'] = 'Modifier Mission';

		// Get all trajets in the correct order
		$data['trajets'] = $this->trajetModel
			->where('id_itineraire', $data['item']->id_itineraire)
			->orderBy('ordre', 'ASC')
			->findAll();

		return view('Mission/edit', $data);
	}


// UPDATE DATABASE
public function update($id)
{
	// Get datas
	$data = $this->request->getPost();
	$mission = $this->model->find($id);
	$itineraire = $this->itineraireModel->find($mission->id_itineraire);

	// Get the submitted departure and arrival locations
	$depart = $data['id_lieu_depart'] ?? null;
	$arrivees = $data['arrivees'] ?? [];

	// Start database transaction
	$this->model->db->transBegin();

	// Update the mission information
	$missionFields = [
		'id_user',
		'id_vehicule',
		'km_depart',
		'km_arrive'
	];

	// Check whether mission information has changed
	$missionUpdated = false;

	foreach ($missionFields as $field)
	{
		// Update the field only if the submitted value is different
		if (isset($data[$field]) && $mission->$field != $data[$field])
		{
			$mission->$field = $data[$field];
			$missionUpdated = true;
		}
	}

	// Save the mission only if information has changed
	if ($missionUpdated && !$this->model->save($mission))
	{
		$this->model->db->transRollback();
		return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de la mission.');
	}

	// Update the itinerary reason
	if (isset($data['motif']) && $itineraire->motif != $data['motif'])
	{
		if (!$this->itineraireModel->update($itineraire->id,['motif' => $data['motif']]))
		{
			$this->model->db->transRollback();
			return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification du motif.');
		}
	}

	// Delete all existing trajets of the itinerary
	if ($this->trajetModel->where('id_itineraire', $itineraire->id)->delete() === false)
	{
		$this->model->db->transRollback();
		return redirect()->back()->withInput()->with('error', 'Erreur lors de la suppression des anciens trajets.');
	}

	// Set the first departure location
	$currentDepart = $depart;

	// Create all trajets in the correct order
	foreach (array_values($arrivees) as $index => $idLieuArrive)
	{
		// Insert the current trajet
		if (!$this->trajetModel->insert([
			'id_itineraire'  => $itineraire->id,
			'id_lieu_depart' => $currentDepart,
			'id_lieu_arrive' => $idLieuArrive,
			'ordre'          => $index + 1
		]))
		{
			// Cancel all changes if an insertion fails
			$this->model->db->transRollback();
			return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification des trajets.');
		}

		// The current arrival becomes the next departure
		$currentDepart = $idLieuArrive;
	}

	// Check whether the database transaction was successful
	if ($this->model->db->transStatus() === false)
	{
		$this->model->db->transRollback();
		return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de la mission.');
	}

	// Commit all database changes
	$this->model->db->transCommit();

	// Redirect to the mission details
	return redirect()->to(site_url('Mission'));
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
		$data['motifs'] = $this->trajetModel->getEnumValues('motifs');
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
