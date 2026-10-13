<?php

namespace App\Controllers;

use App\Models\TrajetModel;
use App\Models\LieuModel;
use App\Models\ItineraireModel;
use App\Entities\Trajet;
use CodeIgniter\Controller;

class TrajetController extends Controller
{
	protected $model;
	protected $lieuModel;
	protected $itineraireModel;

	public function __construct()
	{
		$this->model = new TrajetModel();
		$this->lieuModel = new LieuModel();
		$this->itineraireModel = new ItineraireModel();
	}

	// SEARCH BAR
	public function index()
	{
		// Get the search query from the URL
		$search = $this->request->getGet('q');

		// Build the query to retrieve itineraries
		$builder = $this->itineraireModel
			->select('itineraire.id,itineraire.nom,itineraire.motif,l1.surnom AS surnom_depart,l2.surnom AS surnom_arrive')
			// Build the complete itinerary name using all locations
			// Example: Marseille - Lyon - Paris - Caen
			->select("
				CONCAT_WS(' - ',
					l1.surnom,
					(
						SELECT GROUP_CONCAT(
							l.surnom
							ORDER BY t.ordre
							SEPARATOR ' - '
						)
						FROM trajet AS t
						JOIN lieu AS l ON l.id = t.id_lieu_arrive
						WHERE t.id_itineraire = itineraire.id
					)
				) AS nom_itineraire
			", false)

			// Retrieve the first trajet of each itinerary
			->join('trajet AS premier','premier.id_itineraire = itineraire.id AND premier.ordre = (
						SELECT MIN(t1.ordre)
						FROM trajet AS t1
						WHERE t1.id_itineraire = itineraire.id
					)',
					'left',
					false
				)
			// Retrieve the last trajet of each itinerary
			->join('trajet AS dernier','dernier.id_itineraire = itineraire.id AND dernier.ordre = (
						SELECT MAX(t2.ordre)
						FROM trajet AS t2
						WHERE t2.id_itineraire = itineraire.id
					)',
					'left',
					false
				)
			->join('lieu AS l1','l1.id = premier.id_lieu_depart','left')
			->join('lieu AS l2','l2.id = dernier.id_lieu_arrive','left');

		// Filter itineraries when a search query is provided
		if ($search)
		{
			$builder->like('itineraire.nom', $search)
					->orLike('l1.surnom', $search)
					->orLike('l2.surnom', $search);
		}

		// Store the search query for the view
		$data['search'] = $search;
		// Retrieve itineraries with pagination (20 results per page)
		$data['items'] = $builder->paginate(20);
		// Retrieve pagination links
		$data['pager'] = $this->itineraireModel->pager;
		// Define the current page
		$data['page'] = 'index';

		// Load the itinerary list view
		return view('Trajet/index', $data);
	}


	// DISPLAY AN ELEMENT
	public function show($id)
	{
		// Retrieve the itinerary
		$data['item'] = $this->itineraireModel->find($id);
		$data['itineraire'] = $data['item'];


		// Get all trail with names and destinations
		$data['trajets'] = $this->model
			->select('trajet.*, l1.surnom AS depart, l2.surnom AS arrivee')
			->join('lieu AS l1', 'l1.id = trajet.id_lieu_depart')
			->join('lieu AS l2', 'l2.id = trajet.id_lieu_arrive')
			->where('trajet.id_itineraire', $id)
			->orderBy('trajet.ordre', 'ASC')
			->findAll();

		return view('Trajet/show', $data);
	}

	// CREATION FORM
	public function create()
	{
		$data['title'] = "Créer Trajet";

		// Get all locations
		$data['lieux'] = $this->lieuModel->findAll();

		// Get all available motif values
		$data['motifs'] = $this->itineraireModel->getEnumValues('motif');

		return view('Trajet/create', $data);
	}


	// INSERT INTO DATABASE
	public function store()
	{
		// Get all submitted form data
		$data = $this->request->getPost();

		// Get the departure location ID
		$idLieuDepart = $data['id_lieu_depart'];

		// Get all arrival location IDs
		$arrivees = $data['arrivees'];

		// Start database transaction
		$this->model->db->transBegin();

		// Create the itinerary
		if (!$this->itineraireModel->insert(['nom' => $data['nom'], 'motif' => $data['motif']]))
		{
			$this->model->db->transRollback();
			return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de l\'itinéraire.');
		}

		// Get the automatically generated itinerary ID
		$idItineraire = $this->itineraireModel->getInsertID();

		// The first trajet starts from the selected departure location
		$currentDepart = $idLieuDepart;

		// Create all trajet segments
		foreach ($arrivees as $index => $idLieuArrive)
		{
			// Fill the trajet data
			if(!$this->model->insert([
				'id_itineraire'  => $idItineraire,
				'ordre'          => $index + 1,
				'id_lieu_depart' => $currentDepart,
				'id_lieu_arrive' => $idLieuArrive,
			]))
			{
				$this->model->db->transRollback();
				return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du trajet.');
			}

			// The current arrival becomes the departure of the next trajet
			$currentDepart = $idLieuArrive;
		}

		// Commit all database changes
		$this->model->db->transCommit();

		// Redirect to the trajet list
		return redirect()->to('/Trajet');
	}


	// MODIFICATION FORM
	public function edit($id)
	{
		// Get the itinerary to edit
		$data['item'] = $this->itineraireModel->find($id);

		// Get all trajets of the itinerary in the correct order
		$data['trajets'] = $this->model->where('id_itineraire', $id)
									   ->orderBy('ordre', 'ASC')
									   ->findAll();

		// Get all available locations
		$data['lieux'] = $this->lieuModel->findAll();

		// Get all available motif values
		$data['motifs'] = $this->itineraireModel->getEnumValues('motif');

		// Define the form title
		$data['title'] = 'Modifier Trajet';

		// Load the edit form with the itinerary data
		return view('Trajet/edit', $data);
	}

	// UPDATE DATABASE
	public function update($id)
	{
		// Get all submitted form data
		$data = $this->request->getPost();

		// Get the itinerary to update
		$itineraire = $this->itineraireModel->find($id);

		// Get the submitted itinerary information
		$nom = $data['nom'];
		$motif = $data['motif'];
		$depart = $data['id_lieu_depart'];
		$arrivees = $data['arrivees'];

		// Start database transaction
		$this->model->db->transBegin();

		// Update the itinerary name and motif
		if (!$this->itineraireModel->update($id, ['nom' => $nom,'motif' => $motif]))
		{
			$this->model->db->transRollback();
			return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'itinéraire.');
		}

		// Delete all existing trajets of the itinerary
		$this->model->where('id_itineraire', $id)->delete();

		// Set the first departure location
		$currentDepart = $depart;

		// Create the new trajets in the correct order
		foreach ($arrivees as $index => $arrivee)
		{
			// Insert the current trajet into the database
			if (!$this->model->insert([
				'id_itineraire'  => $id,
				'id_lieu_depart' => $currentDepart,
				'id_lieu_arrive' => $arrivee,
				'ordre'          => $index + 1
			]))
			{
				// Cancel all changes if an insertion fails
				$this->model->db->transRollback();
				return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification des trajets.');
			}

			// The current arrival becomes the departure of the next trajet
			$currentDepart = $arrivee;
		}

		// Save all database changes
		$this->model->db->transCommit();

		// Redirect
		return redirect()->to(site_url('Trajet'));
	}

	// DELETE AN ELEMENT
	public function delete($id)
	{
		$this->model->delete($id);
		return redirect()->to('/Trajet');
	}
}