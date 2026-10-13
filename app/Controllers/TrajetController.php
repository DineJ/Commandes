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
		// Get all submitted form data
		$data = $this->request->getPost();

		// Get the trajet to update
		$entity = $this->model->find($id);

		// Save old location IDs before updating
		$oldLieuDepart = $entity->id_lieu_depart;
		$oldLieuArrive = $entity->id_lieu_arrive;

		// Keep itinerary information
		$idItineraire = $entity->id_itineraire;
		$ordre = $entity->ordre;

		// Update trajet data
		$entity->fill($data);

		if (!$this->model->save($entity))
		{
			return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour.');
		}

		// Check if departure or arrival location has changed
		$departChanged = $oldLieuDepart != $entity->id_lieu_depart;
		$arriveChanged = $oldLieuArrive != $entity->id_lieu_arrive;

		if ($departChanged && $ordre > 1)
		{
			// Get the previous trial
			$previousTrajet = $this->model->where('id_itineraire', $idItineraire)
										  ->where('ordre', $ordre - 1)
										  ->first();

			// Update the ending location of the previous trial
			$previousTrajet->id_lieu_arrive = $entity->id_lieu_depart;

			// Save it into the DB
			$this->model->save($previousTrajet);
		}

		if ($arriveChanged)
		{
			// Get the next trial (return null if doenst exist)
			$nextTrajet = $this->model->where('id_itineraire', $idItineraire)
									  ->where('ordre', $ordre + 1)
									  ->first();

			if ($nextTrajet)
			{
				// Update the starting location of the next trial
				$nextTrajet->id_lieu_depart = $entity->id_lieu_arrive;

				// Save it into the DB
				$this->model->save($nextTrajet);
			}
		}

		// Rebuild itinerary name only if a location has changed
		if ($departChanged || $arriveChanged)
		{
			// Get every trajet of the itinerary in the correct order
			$trajets = $this->model->where('id_itineraire', $idItineraire)
								   ->orderBy('ordre', 'ASC')
								   ->findAll();

			$nomsLieux = [];

			foreach ($trajets as $index => $trajet)
			{
				// Add the departure location only for the first trajet
				if ($index === 0)
				{
					$lieuDepart = $this->lieuModel->find($trajet->id_lieu_depart);
					$nomsLieux[] = $lieuDepart->surnom;
				}

				// Add each arrival location
				$lieuArrive = $this->lieuModel->find($trajet->id_lieu_arrive);
				$nomsLieux[] = $lieuArrive->surnom;
			}

			// Build the new itinerary name
			$nomItineraire = implode(' - ', $nomsLieux);

			// Update itinerary name
			$this->itineraireModel->update($idItineraire,['nom' => $nomItineraire]);
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