<?php

namespace App\Controllers;

use App\Models\IpModel;
use App\Models\UserModel;
use App\Models\VehiculeModel;
use App\Models\LieuModel;
use App\Models\InfractionModel;
use App\Models\MissionModel;
use App\Models\IncidentModel;
use App\Entities\User;
use CodeIgniter\Controller;

class AdminController extends Controller
{
	protected $model;

	public function __construct()
	{
		// Load the model
		$this->ipModel = new IpModel();
		$this->model = new UserModel();
		$this->vehiculeModel = new VehiculeModel();
		$this->lieuModel = new LieuModel();
		$this->infractionModel = new InfractionModel();
		$this->missionModel = new MissionModel();
		$this->incidentModel = new IncidentModel();
	}

	// Display the admin dashboard
	public function administrator()
	{
		// Redirect to user page if not an admin
		if (null == session()->get('user')['admin'])
		{
			return redirect()->to('/Non_admin');
		}

		$data['ip'] = $this->ipModel
			->select('adresse_ip AS IP, nb_echec AS Nombre échecs, id')
			->where('nb_echec >', 2)
			->get()
			->getResult();

		$data['user'] = $this->model
				->select('id, CONCAT(nom, " ", prenom) AS Conducteur, actif')
				->where('actif =', 0)
				->get()
				->getResult();

		$data['vehicule'] = $this->vehiculeModel
			->select('id, plaque AS Plaque, marque AS Marque, modele AS Modèle')
			->where('actif =', 0)
			->get()
			->getResult();

		$data['lieu'] = $this->lieuModel
			->select('id, surnom AS Surnom, CONCAT(numero, " ", adresse, " ", nom_lieu, " ", code_postal) AS Adresse')
			->where('actif =', 0)
			->get()
			->getResult();

		// Request to get datas
		$data['infraction'] = $this->infractionModel
			->select('infraction.id, vehicule.plaque AS Plaque, CONCAT(user.prenom,  " ", user.nom) AS Conducteur, date_infraction AS Date, points as Points, prix as Prix')
			->join('mission', 'mission.id = infraction.id_mission', 'left')
			->join('vehicule', 'vehicule.id = mission.id_vehicule', 'left')
			->join('user', 'user.id = mission.id_user', 'left')
			->orderBy('date_infraction', 'DESC')
			->get()
			->getResult();

		$data['mission'] = $this->missionModel
			  ->select('CONCAT(user.nom, " ", user.prenom) AS Conducteur, vehicule.plaque AS Plaque, trajet.motif AS Motif, l1.surnom AS `Lieu départ`, CONCAT(l1.numero, " ", l1.adresse, " ", l1.nom_lieu, " ", l1.code_postal) AS `Adresse départ`, trajet.date_debut AS Début, l2.surnom AS `Lieu arrivé`, CONCAT(l2.numero, " ", l2.adresse, " ", l2.nom_lieu, " ", l2.code_postal) AS `Adresse arrivé`,
			CASE
				WHEN trajet.date_arrivee = trajet.date_debut
				THEN "En cours"
			ELSE trajet.date_arrivee
			END AS Fin', false)
			->join('user', 'user.id = mission.id_user', 'left')
			->join('vehicule', 'vehicule.id = mission.id_vehicule', 'left')
			->join('trajet', 'trajet.id = mission.id_trajet', 'left')
			->join('lieu l1', 'l1.id = trajet.id_lieu_depart', 'left')
			->join('lieu l2', 'l2.id = trajet.id_lieu_arrive', 'left')
			->orderBy('trajet.date_debut', 'DESC')
			->get()
			->getResult();

		$data['incident'] = $this->incidentModel
			->select('incident.id, vehicule.plaque AS Plaque, CONCAT(user.prenom, " ", user.nom) AS Conducteur, type_incident.nom AS Type,incident.date_incident AS Date')
			->join('vehicule', 'vehicule.id = incident.id_vehicule', 'left')
			->join('user', 'user.id = incident.id_user', 'left')
			->join('type_incident', 'type_incident.id = incident.id_type_incident', 'left')
			->orderBy('date_incident', 'DESC')
			->get()
			->getResult();

		// Load admin view with title
		$data['title'] = "Page d'administration";
		return view('Admin/admin', $data);
	}


	// Redirect to nonAdmin home
	public function nonAdmin()
	{
		//load helper
		helper('section');

		$data['missions'] = $this->missionModel
					 ->select('mission.id, CONCAT(user.nom, " ", user.prenom) AS nom_complet, mission.id_vehicule, vehicule.plaque, CONCAT(l1.numero, " ", l1.adresse, " ", l1.nom_lieu) AS lieu_depart, CONCAT(l2.numero, " ", l2.adresse, " ", l2.nom_lieu) AS lieu_arrive, mission.motif, mission.date_depart, mission.date_arrivee, mission.km_depart, mission.km_arrive, l1.surnom as Surnom')
					 ->join('user', 'user.id = mission.id_user', 'left')
					 ->join('vehicule', 'vehicule.id = mission.id_vehicule', 'left')
					 ->join('lieu l1', 'l1.id = mission.id_lieu_depart', 'left')
					 ->join('lieu l2', 'l2.id = mission.id_lieu_arrive', 'left')
					 ->where('id_user', session()->get('user')['id'])
					 ->where('mission.date_depart = mission.date_arrivee')
					 ->orderBy('date_depart', 'DESC')
					 ->findAll();
		return view('Non_admin/home', $data);
	}


	public function reactivateIp()
	{
		$ip = $this->request->getPost('adresse_ip');

		if ($ip) {
			$db = db_connect();
			$db->table('Ip')
			->where('adresse_ip', $ip)
			->update(['nb_echec' => 0]);
		}

		return redirect()->to('/Admin/administrator');
	}


	public function extraction_view()
	{
		return view('Admin/extraction');
	}

	// Extract datas into a csv file
	public function extraction_datas()
	{
		// Get datas
		$type = $this->request->getGet('type');
		$month = $this->request->getGet('mois');
		$year = $this->request->getGet('annee');

		// Convert date
		$start = $year . '-' . $month . '-01';
		$end = date('Y-m-t', strtotime($start));

		// in case we have multiple buttons
		switch ($type) {
			case 'mission':
				$data['items'] = $this->missionModel
					->select('vehicule.plaque, CONCAT(user.nom, " ", user.prenom) AS nom_complet, mission.motif, mission.date_depart, mission.date_arrivee, l1.surnom AS surnom_depart , l2.surnom AS surnom_arrive, mission.km_depart, mission.km_arrive')
					->join('user', 'user.id = mission.id_user', 'left')
					->join('vehicule', 'vehicule.id = mission.id_vehicule', 'left')
					->join('lieu l1', 'l1.id = mission.id_lieu_depart', 'left')
					->join('lieu l2', 'l2.id = mission.id_lieu_arrive', 'left')
					->where('mission.date_depart >=', $start)
					->where('mission.date_depart <=', $end)
					->orderBy('nom_complet, mission.date_depart', 'DESC')
					->findAll();
				break;

			default:
				return redirect()->back()->with('error', 'Type d’extraction invalide.');
		}

		// Generate a dynamic file name.
		$filename = $type . '_' . $month . '_' . $year . '.csv';

		// Create the CSV header row.
		$csv = "Conducteur;Date départ;Date arrivée;Plaque;Motif;Lieu départ;KM départ;Lieu arrivée;KM arrivé\n";

		// Loop through all records returned by the query.
		foreach ($data['items'] as $item) {
			$csv .= $item->nom_complet . ';'
				. $item->date_depart . ';'
				. $item->date_arrivee . ';'
				. $item->plaque . ';'
				. $item->motif . ';'
				. $item->surnom_depart . ';'
				. $item->km_depart . ';'
				. $item->surnom_arrive . ';'
				. $item->km_arrive
				. "\n";
		}

		// Return the CSV file as a downloadable response.
		return $this->response
			->setHeader('Content-Type', 'text/csv; charset=UTF-8') // Tell the browser that the response is a CSV file.
			->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"') // Force the browser to download the file instead of displaying it.
			->setBody("\xEF\xBB\xBF" . $csv); // Add UTF-8 BOM for Excel compatibility and send the CSV content.
	}

}
