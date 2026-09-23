<?php

namespace App\Controllers;

use App\Models\TrajetModel;
use App\Models\LieuModel;
use App\Entities\Trajet;
use CodeIgniter\Controller;

class TrajetController extends Controller
{
	protected $model;
	protected $lieuModel;

	public function __construct()
	{
		$this->model = new TrajetModel();
		$this->lieuModel = new LieuModel();
	}

	// SEARCH BAR
	public function index()
	{
		// Query
		$search = $this->request->getGet('q');

		// Query builder
		$builder = $this->model
			->select('trajet.id, l1.surnom AS surnom_depart, l2.surnom AS surnom_arrive, trajet.date_debut, trajet.date_arrivee, trajet.motif, trajet.km_depart, trajet.km_arrive')
			->join('lieu AS l1', 'trajet.id_lieu_depart = l1.id', 'left')
			->join('lieu AS l2', 'trajet.id_lieu_arrive = l2.id', 'left')
			->orderBy('trajet.date_debut');

		// Search bar for query
		if ($search)
		{
			$builder->like('l1.surnom', $search)
						->orLike('l2.surnom', $search)
						->orLike("DATE_FORMAT(trajet.date_debut, '%d/%m')", $search, 'both')
						->orderBy('trajet.id');
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
		$data['lieux'] = $this->lieuModel->findAll();
		return view('Trajet/create', $data);
	}


	// INSERT INTO DATABASE
	public function store()
	{
		$data = $this->request->getPost();
		$entity = new Trajet();
		$entity->fill($data);

		if (!$this->model->insert($entity))
		{
			return redirect()->back()->with('error', 'Erreur lors de l\'ajout.');
		}
		
		return redirect()->to('/Trajet');
	}


	// MODIFICATION FORM
	public function edit($id)
	{
		$data['item'] = $this->model->find($id);
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