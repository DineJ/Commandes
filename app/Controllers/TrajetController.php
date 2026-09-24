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
		// Query
		$search = $this->request->getGet('q');

		// Query builder
		$builder = $this->model
			->select('trajet.id, l1.surnom AS surnom_depart, l2.surnom AS surnom_arrive, trajet.date_debut, trajet.date_arrivee, trajet.motif, trajet.km_depart, trajet.km_arrive, itineraire.nom')
			->join('lieu AS l1', 'trajet.id_lieu_depart = l1.id', 'left')
			->join('lieu AS l2', 'trajet.id_lieu_arrive = l2.id', 'left')
			->join('itineraire', 'itineraire.id = trajet.id_itineraire', 'left')
			->orderBy('trajet.date_debut', 'DESC');

		// Search bar for query
		if ($search)
		{
			$builder->like('l1.surnom', $search)
						->orLike('l2.surnom', $search)
						->orLike("DATE_FORMAT(trajet.date_debut, '%d/%m')", $search, 'both')
						->orderBy('trajet.date_debut', 'DESC');
		}

		$data['search'] = $search;
		$data['items'] = $this->model->paginate(20); // Display 20 results
		$data['pager'] = $builder->pager; // Add pager
		$data['page'] = 'index';

		return view('Trajet/index', $data);
	}


	// DISPLAY AN ELEMENT
	public function show($id)
	{
		$data['item'] = $this->model->find($id);
		return view('Trajet/show', $data);
	}


	// CREATION FORM
	public function create()
	{
		$data['title'] = "Créer Trajet";

		// Get all locations
		$data['lieux'] = $this->lieuModel->findAll();

		// Get all available motif values
		$data['motifs'] = $this->model->getEnumValues('motif');

		return view('Trajet/create', $data);
	}


	// INSERT INTO DATABASE
	public function store()
	{
		// Get all submitted form data
		$data = $this->request->getPost();

		// Retrieve the departure location ID and all arrival location IDs
		$idLieuDepart = $data['id_lieu_depart'];
		$arrivees = $data['arrivees'];

		// Start a database transaction
		$this->model->db->transStart();


		// Get the departure location
		$lieuDepart = $this->lieuModel->find($idLieuDepart);

		// Initialize the array containing all location names
		$nomsLieux = [];

		// Add the departure location name
		$nomsLieux[] = $lieuDepart->surnom;

		// Add every arrival location name
		foreach ($arrivees as $idLieuArrive)
		{
			$lieu = $this->lieuModel->find($idLieuArrive);
			$nomsLieux[] = $lieu->surnom;
		}

		// Build the itinerary name
		$nomItineraire = implode(' - ', $nomsLieux);


		//Create the itinerary
		$this->itineraireModel->insert(['nom' => $nomItineraire]);

		// Get the automatically generated itinerary ID
		$idItineraire = $this->itineraireModel->getInsertID();


		// The first trajet starts from the selected departure location
		$currentDepart = $idLieuDepart;

		// Start trajet order at 1
		$ordre = 1;

		foreach ($arrivees as $idLieuArrive)
		{
			// Create a new Trajet entity
			$trajet = new Trajet();

			// Fill the trajet with its data
			$trajet->fill([
				'id_itineraire'  => $idItineraire,
				'ordre'          => $ordre,
				'id_lieu_depart' => $currentDepart,
				'id_lieu_arrive' => $idLieuArrive,
				'date_debut'     => $data['date_debut'],
				'motif'          => $data['motif'],
			]);

			// Insert the trajet into the database
			$this->model->insert($trajet);

			// The current arrival becomes the next departure
			$currentDepart = $idLieuArrive;

			// Increment the trajet order
			$ordre++;
		}

		// Complete the transaction
		$this->model->db->transComplete();

		// Check if the transaction failed
		if ($this->model->db->transStatus() === false)
		{
			return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de l\'itinéraire.');
		}

		// Redirect to the trajet list
		return redirect()->to('/Trajet');
	}


	// MODIFICATION FORM
	public function edit($id)
	{
		// Get the trajet to edit
		$data['item'] = $this->model->find($id);

		// Get all locations
		$data['lieux'] = $this->lieuModel->findAll();

		// Get all available motif values
		$data['motifs'] = $this->model->getEnumValues('motif');

		$data['title'] = "Modifier Trajet";
		return view('Trajet/edit', $data);
	}


	// UPDATE DATABASE
	public function update($id)
	{
		$data = $this->request->getPost();
		$entity = $this->model->find($id);
		$entity->fill($data);

		if (!$this->model->save($entity))
		{
			return redirect()->back()->with('error', 'Erreur lors de la mise à jour.');
		}

		return redirect()->to('/Trajet');
	}


	// DELETE AN ELEMENT
	public function delete($id)
	{
		$this->model->delete($id);
		return redirect()->to('/Trajet');
	}
}