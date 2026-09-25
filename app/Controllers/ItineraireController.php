<?php

namespace App\Controllers;

use App\Models\ItineraireModel;
use App\Entities\Itineraire;
use CodeIgniter\Controller;

class ItineraireController extends Controller
{
	protected $model;

	public function __construct()
	{
		$this->model = new ItineraireModel();
	}

	// SEARCH BAR
	public function index()
	{
		
		$data['items'] = $this->model->paginate(5); // Display 5 results
		$data['pager'] = $this->model->pager; // Add pager

		return view('Itineraire/index', $data);
	}


	// DISPLAY AN ELEMENT
	public function show($id)
	{
		$data['item'] = $this->model->find($id);
		return view('Itineraire/show', $data);
	}


	// CREATION FORM
	public function create()
	{
		$data['title'] = "Créer Itineraire";
		return view('Itineraire/create', $data);
	}


	// INSERT INTO DATABASE
	public function store()
	{
		$data = $this->request->getPost();
		$entity = new Itineraire();
		$entity->fill($data);

		if (!$this->model->insert($entity))
		{
			return redirect()->back()->with('error', 'Erreur lors de l\'ajout.');
		}
		
		return redirect()->to('/Itineraire');
	}


	// MODIFICATION FORM
	public function edit($id)
	{
		$data['item'] = $this->model->find($id);
		$data['title'] = "Modifier Itineraire";
		return view('Itineraire/edit', $data);
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

		return redirect()->to('/Itineraire');
	}


	// DELETE AN ELEMENT
	public function delete($id)
	{
		$this->model->delete($id);
		return redirect()->to('/Itineraire');
	}
}