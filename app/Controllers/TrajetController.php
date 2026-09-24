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
		$data['lieu_depart'] = $this->lieuModel->find($data['item']->id_lieu_depart);
		$data['lieu_arrive'] = $this->lieuModel->find($data['item']->id_lieu_arrive);

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

		// Get the departure location ID
		$idLieuDepart = $data['id_lieu_depart'];

		// Get all arrival location IDs
		$arrivees = $data['arrivees'];

		// Build an ordered array containing departure + all arrivals
		$lieuxIds = array_merge([$idLieuDepart], $arrivees);

		// Retrieve all locations
		$lieux = $this->lieuModel
			->whereIn('id', $lieuxIds)
			->findAll();

		// Index locations by their ID for easier access
		$lieuxById = [];

		foreach ($lieux as $lieu)
		{
			$lieuxById[$lieu->id] = $lieu;
		}

		// Build the itinerary name in the correct order
		$nomsLieux = [];

		foreach ($lieuxIds as $idLieu)
		{
			// Add the location nickname to the itinerary name
			$nomsLieux[] = $lieuxById[$idLieu]->surnom;
		}

		// Example: Marseille - Lyon - Paris - Caen
		$nomItineraire = implode(' - ', $nomsLieux);

		// Start database transaction
		$this->model->db->transBegin();

		// Create the itinerary
		if (!$this->itineraireModel->insert(['nom' => $nomItineraire]))
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
				'date_debut'     => $data['date_debut'],
				'motif'          => $data['motif'],
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