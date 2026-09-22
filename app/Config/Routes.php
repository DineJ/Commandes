<?php

use CodeIgniter\Router\RouteCollection;
// Auto-generated routes

$routes->group('', ['filter' => 'Redirection:admin'], function($routes)
{

	// Routes for Trajet
	$routes->get('Trajet', 'TrajetController::index'); // Route that leads to the display of all data
	$routes->get('Trajet/show/(:num)', 'TrajetController::show/$1'); // Route that leads to the display of one specific data
	$routes->get('Trajet/create', 'TrajetController::create'); // Route that leads to the display of creating a specific data
	$routes->post('Trajet/store', 'TrajetController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Trajet/edit/(:num)', 'TrajetController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Trajet/update/(:num)', 'TrajetController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Infraction
	$routes->get('Infraction', 'InfractionController::index'); // Route that leads to the display of all data
	$routes->get('Infraction/show/(:num)', 'InfractionController::show/$1'); // Route that leads to the display of one specific data
	$routes->match(['post', 'get'], 'Infraction/create', 'InfractionController::create'); // Route that leads to the display of creating a specific data
	$routes->post('Infraction/store', 'InfractionController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Infraction/edit/(:num)', 'InfractionController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Infraction/update/(:num)', 'InfractionController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Lieu
	$routes->get('Lieu', 'LieuController::index'); // Route that leads to the display of all data
	$routes->get('Lieu/show/(:num)', 'LieuController::show/$1'); // Route that leads to the display of one specific data
	$routes->get('Lieu/create', 'LieuController::create'); // Route that leads to the display of creating a specific data
	$routes->post('Lieu/store', 'LieuController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Lieu/edit/(:num)', 'LieuController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Lieu/update/(:num)', 'LieuController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Mission
	$routes->get('Mission', 'MissionController::index'); // Route that leads to the display of all data
	$routes->get('Mission/show/(:num)', 'MissionController::show/$1'); // Route that leads to the display of one specific data
	$routes->get('Mission/edit/(:num)', 'MissionController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Mission/update/(:num)', 'MissionController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Assurance
	$routes->get('Assurance', 'AssuranceController::index'); // Route that leads to the display of all data
	$routes->get('Assurance/show/(:num)', 'AssuranceController::show/$1'); // Route that leads to the display of one specific data
	$routes->match(['post', 'get'],'Assurance/create', 'AssuranceController::create'); // Route that leads to the display of creating a specific data
	$routes->post('Assurance/store', 'AssuranceController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Assurance/edit/(:num)', 'AssuranceController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Assurance/update/(:num)', 'AssuranceController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Suivi
	$routes->get('Suivi', 'SuiviController::index'); // Route that leads to the display of all data
	$routes->get('Suivi/show/(:num)', 'SuiviController::show/$1'); // Route that leads to the display of one specific data
	$routes->match(['post', 'get'], 'Suivi/create', 'SuiviController::create'); // Route that leads to the display of creating a specific data
	$routes->post('Suivi/store', 'SuiviController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Suivi/edit/(:num)', 'SuiviController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Suivi/update/(:num)', 'SuiviController::update/$1'); // Route that leads to the update fuction of the DB
	$routes->get('Suivi/pdf/(:num)', 'SuiviController::pdf/$1'); // Route that display the PDF


	// Routes for Ip
	$routes->get('Ip', 'IpController::index');  // Route that leads to the display of all data
	$routes->post('Ip/update/(:num)', 'IpController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Type_incident
	$routes->get('Type_incident', 'Type_incidentController::index'); // Route that leads to the display of all data
	$routes->get('Type_incident/show/(:num)', 'Type_incidentController::show/$1'); // Route that leads to the display of one specific data
	$routes->match(['post', 'get'], 'Type_incident/create', 'Type_incidentController::create'); // Route that leads to the display of creating a specific data
	$routes->post('Type_incident/store', 'Type_incidentController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Type_incident/edit/(:num)', 'Type_incidentController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Type_incident/update/(:num)', 'Type_incidentController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Vehicule
	$routes->get('Vehicule', 'VehiculeController::index'); // Route that leads to the display of all data
	$routes->get('Vehicule/show/(:num)', 'VehiculeController::show/$1'); // Route that leads to the display of one specific data
	$routes->get('Vehicule/create', 'VehiculeController::create'); // Route that leads to the display of creating a specific data
	$routes->post('Vehicule/store', 'VehiculeController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Vehicule/edit/(:num)', 'VehiculeController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Vehicule/update/(:num)', 'VehiculeController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Incident
	$routes->get('Incident', 'IncidentController::index'); // Route that leads to the display of all data
	$routes->get('Incident/show/(:num)', 'IncidentController::show/$1'); // Route that leads to the display of one specific data
	$routes->get('Incident/create', 'IncidentController::create'); // Route that leads to the display of creating a specific data
	$routes->post('Incident/store', 'IncidentController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Incident/edit/(:num)', 'IncidentController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Incident/update/(:num)', 'IncidentController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Permis
	$routes->match(['post', 'get'], 'Permis/create/', 'PermisController::create/'); // Route that leads to the display of creating a specific data
	$routes->post('Permis/store/', 'PermisController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('Permis/edit/(:segment)', 'PermisController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('Permis/update/(:segment)', 'PermisController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for User
	$routes->get('User', 'UserController::index'); // Route that leads to the display of all data
	$routes->get('User/show/(:num)', 'UserController::show/$1'); // Route that leads to the display of one specific data
	$routes->get('User/create', 'UserController::create'); // Route that leads to the display of creating a specific data
	$routes->post('User/store', 'UserController::store'); // Route that leads to the insert fuction of the DB
	$routes->get('User/edit/(:num)', 'UserController::edit/$1'); // Route that leads to the display of editing a specific data
	$routes->post('User/update/(:num)', 'UserController::update/$1'); // Route that leads to the update fuction of the DB


	// Routes for Admin
	$routes->get('Admin', 'AdminController::administrator'); // Route that leads to admin view
	$routes->get('Extraction', 'AdminController::extraction_view'); // Route that leads to extraction view
	$routes->get('Extraction/datas', 'AdminController::extraction_datas'); // Route that allow to download datas into a csv file
});


$routes->group('', ['filter' => 'Redirection:nonadmin'], function($routes)
{

	//Routes for Non Admin
	$routes->get('Non_admin', 'AdminController::nonAdmin'); // Route that lead to non admin view
	$routes->get('Mission/debut', 'MissionController::debut'); // Route that lead to a new mission
	$routes->post('Mission/new', 'MissionController::store'); // Route that leads to the insert function of the DB
	$routes->get('Mission/renew/(:num)', 'MissionController::renew/$1'); // Route that leads to comeback to your previous site
	$routes->post('Mission/end/(:num)', 'MissionController::update/$1'); // Route that leads to the update function of the DB
	$routes->get('Incident/declarer', 'IncidentController::debut'); //Route that lead to a new incident
	$routes->post('Incident/start_end', 'IncidentController::store'); // Route that leads to the insert function of the DB
	$routes->get('Mission/checkEntretien/(:num)', 'MissionController::checkEntretien/$1');
	$routes->get('Mission/checking/(:num)', 'MissionController::checking/$1');
	$routes->post('Incident/saveChecking/(:num)', 'IncidentController::saveChecking/$1');
});


// Routes for Login
$routes->get('Login', 'LoginController::login'); // Route that leads to the display of login view
$routes->post('Login/log', 'LoginController::log'); // Route that leads you to connect
$routes->get('Login/logout', 'LoginController::logout'); // Route that leads you to disconnect

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::login'); // Default Route
