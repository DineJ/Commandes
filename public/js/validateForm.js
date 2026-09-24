// Check if values are changed or not; returns an error if they are not
function validateFormIncidentEdit()
{

	// Counter
	let compare = 0;
	let row = 0;

	// Get values
	let id_vehicule = document.getElementById('id_vehicule').value;
	let oldid_vehicule = document.getElementById('oldid_vehicule').value;
	row++;

	// Check values
	if (id_vehicule == oldid_vehicule)
	{
		compare++;
	}

	// Get values
	let date_incident = document.getElementById('date_incident').value;
	let olddate_incident = document.getElementById('olddate_incident').value;
	row++;

	// Check values
	if (date_incident == olddate_incident)
	{
		compare++;
	}

	// Get values
	let explication_incident = document.getElementById('explication_incident').value;
	let oldexplication_incident = document.getElementById('oldexplication_incident').value;
	row++;

	// Check values
	if (explication_incident == oldexplication_incident)
	{
		compare++;
	}

	// Get values
	let id_user = document.getElementById('id_user').value;
	let oldid_user = document.getElementById('oldid_user').value;
	row++;

	// Check values
	if (id_user == oldid_user)
	{
		compare++;
	}

	// Get values
	let id_type_incident = document.getElementById('id_type_incident').value;
	let oldid_type_incident = document.getElementById('oldid_type_incident').value;
	row++;

	// Check values
	if (id_type_incident == oldid_type_incident)
	{
		compare++;
	}

	// Check counts
	if (compare == row)
	{
		alert("les valeurs sont identiques");
		return false;
	}
	return true;
}


//////////////////////////////////////////////


function validateFormPermis()
{

	let compare = 0;
	let row = 0;

	let date_permis = document.getElementById('date_permis').value;
	let olddate_permis = document.getElementById('olddate_permis').value;
	row++;

	if (date_permis == olddate_permis)
	{
		compare++;
	}

	let update_permis = document.getElementById('update_permis').value;
	let oldupdate_permis = document.getElementById('oldupdate_permis').value;
	row++;

	if (update_permis == oldupdate_permis)
	{
		compare++;
	}

	let type_permis = document.getElementById('type_permis').value;
	let oldtype_permis = document.getElementById('oldtype_permis').value;
	row++;

	if (type_permis == oldtype_permis)
	{
		compare++;
	}

	// Get values
	let lien_permis = document.getElementById('lien_permis').value;
	let oldlien_permis = document.getElementById('oldtype_permis').value;
	row++;

	// Chek values
	if (lien_permis == oldlien_permis)
	{
		compare++;
	}

	if (compare == row)
	{
		alert("les valeurs sont identiques");
		return false;
	}
	return true;
}

function selectedPermis()
{
	const oldSelect = document.getElementById('oldtype_permis');

	if (oldSelect)
	{
		const oldValue = oldSelect.value;
		const select = document.getElementById('type_permis');
		if (select)
		{
			select.value = oldValue;
		}
	}

}

// function call
selectedPermis();


//////////////////////////////////////////////


function validateFormSuivi()
{

	// Count
	let compare = 0;
	let row = 0;

	// Get values
	let id_incident = document.getElementById('id_incident').value;
	let oldid_incident = document.getElementById('oldid_incident').value;
	row++;

	// Check values 
	if (id_incident == oldid_incident)
	{
		compare++;
	}

	// Get values
	let date_intervention = document.getElementById('date_intervention').value;
	let olddate_intervention = document.getElementById('olddate_intervention').value;
	row++;

	// Check values 
	if (date_intervention == olddate_intervention)
	{
		compare++;
	}

	// Get values
	let descriptionElement = document.getElementById('description');
	let olddescription = document.getElementById('olddescription').value;

	// Check values
	if (descriptionElement) {
		let description = descriptionElement.value;
		row++;

		if (description == olddescription) {
			compare++;
		}
	}

	// Check counts
	if (compare == row)
	{
		alert("les valeurs sont identiques");
		return false;
	}
	return true;
}


//////////////////////////////////////////////


function validateFormTypeIncident()
{

	let compare = 0;
	let row = 0;

	let nom = document.getElementById('nom').value;
	let oldnom = document.getElementById('oldnom').value;
	row++;

	if (nom == oldnom)
	{
		compare++;
	}

	let critique = (document.getElementById('critique').checked ? 1 : 0 );
	let oldcritique = document.getElementById('oldcritique').value;
	row++;

	if (critique == oldcritique)
	{
		compare++;
	}

	if (compare == row)
	{
		alert("les valeurs sont identiques");
		return false;
	}
	return true;
}


//////////////////////////////////////////////

// Check if values are changed or not; returns an error if they are not
function validateFormUser()
{

	// Count
	let compare = 0;
	let row = 0;

	// Get values
	let nom = document.getElementById('nom').value;
	let oldnom = document.getElementById('oldnom').value;
	row++;

	// Check values
	if (nom == oldnom)
	{
		compare++;
	}

	// Get values
	let prenom = document.getElementById('prenom').value;
	let oldprenom = document.getElementById('oldprenom').value;
	row++;

	// Check values
	if (prenom == oldprenom)
	{
		compare++;
	}

	// Get values
	let password = document.getElementById('clef_connexion').value;
	row++;

	// Check values
	if (password.length === 0)
	{
		compare++;
	}

	// Get values
	let admin = (document.getElementById('admin').checked ? 1 : 0 );
	let oldadmin = document.getElementById('oldadmin').value;
	row++;

	// Check values
	if (admin == oldadmin)
	{
		compare++;
	}

	// Get values
	let telephone = document.getElementById('telephone').value;
	let oldtelephone = document.getElementById('oldtelephone').value;
	row++;

	// Check values
	if (telephone == oldtelephone)
	{
		compare++;
	}

	// Get values
	let mail = document.getElementById('mail').value;
	let oldmail = document.getElementById('oldmail').value;
	row++;

	// Check values
	if (mail == oldmail)
	{
		compare++;
	}

	// Check counts
	if (compare == row)
	{
		alert("les valeurs sont identiques");
		return false;
	}
	return true;
}


//////////////////////////////////////////////


function validateFormVehicule()
	{

		// Count
		let compare = 0;
		let row = 0;

		// Get values
		let plaque = document.getElementById('plaque').value;
		let oldplaque = document.getElementById('oldplaque').value;
		row++;

		// Check values 
		if (plaque == oldplaque)
		{
			compare++;
		}

		// Get values
		let marque = document.getElementById('marque').value;
		let oldmarque = document.getElementById('oldmarque').value;
		row++;

		// Check values 
		if (marque == oldmarque)
		{
			compare++;
		}

		// Get values
		let modele = document.getElementById('modele').value;
		let oldmodele = document.getElementById('oldmodele').value;
		row++;

		// Check values 
		if (modele == oldmodele)
		{
			compare++;
		}

		// Get values
		let date_achat = document.getElementById('date_achat').value;
		let olddate_achat = document.getElementById('olddate_achat').value;
		row++;

		// Check values 
		if (date_achat == olddate_achat)
		{
			compare++;
		}

		// Get values
		let date_immat = document.getElementById('date_immat').value;
		let olddate_immat = document.getElementById('olddate_immat').value;
		row++;

		// Check values 
		if (date_immat == olddate_immat)
		{
			compare++;
		}

		// Get values
		let ct = document.getElementById('ct').value;
		let oldct = document.getElementById('oldct').value;
		row++;

		// Check values 
		if (ct == oldct)
		{
			compare++;
		}

		// Get values
		let cg = document.getElementById('cg').value;
		let oldcg = document.getElementById('oldcg').value;
		row++;

		// Check values
		if (cg == oldcg)
		{
			compare++;
		}

		// Get values
		let cv = document.getElementById('cv').value;
		let oldcv = document.getElementById('cv').value
		row++;

		// Check values
		if (cv == oldcv)
		{
			compare++;
		}

		// Check counts
		if (compare == row)
		{
			alert("les valeurs sont identiques");
			return false;
		}
		return true;
	}


//////////////////////////////////////////////


function validateFormAssurance()
	{
		// Count
		let compare = 0;
		let row = 0;

		// Get values
		let nom_assurance = document.getElementById('nom_assurance').value;
		let oldnom_assurance = document.getElementById('oldnom_assurance').value;
		row++;

		// Check values
		if (nom_assurance == oldnom_assurance)
		{
			compare++;
		}

		// Get values
		let date_contrat = document.getElementById('date_contrat').value;
		let olddate_contrat = document.getElementById('olddate_contrat').value;
		row++;

		// Check values
		if (date_contrat == olddate_contrat)
		{
			compare++;
		}

		// Check counts
		if (compare == row)
		{
			alert("les valeurs sont identiques");
			return false;
		}
		return true;
	}


//////////////////////////////////////////////


	function validateFormMissionEdit()
	{

		// Count
		let compare = 0;
		let row = 0;

		// Get values
		let id_vehicule = document.getElementById('id_vehicule').value;
		let oldid_vehicule = document.getElementById('oldid_vehicule').value;
		row++;

		// Check values
		if (id_vehicule == oldid_vehicule)
		{
			compare++;
		}

		// Get values
		let id_user = document.getElementById('id_user').value;
		let oldid_user = document.getElementById('oldid_user').value;
		row++;

		// Check values
		if (id_user == oldid_user)
		{
			compare++;
		}

		// Get values
		let id_lieu_depart = document.getElementById('id_lieu_depart').value;
		let oldid_lieu_depart = document.getElementById('oldid_lieu_depart').value;
		row++;

		// Check values
		if (id_lieu_depart == oldid_lieu_depart)
		{
			compare++;
		}

		// Get values
		let id_lieu_arrive = document.getElementById('id_lieu_arrive').value;
		let oldid_lieu_arrive = document.getElementById('oldid_lieu_arrive').value;
		row++;

		// Check values
		if (id_lieu_arrive == oldid_lieu_arrive)
		{
			compare++;
		}

		// Get values
		let motif = document.getElementById('motif').value;
		let oldmotif = document.getElementById('oldmotif').value;
		row++;

		// Check values
		if (motif == oldmotif)
		{
			compare++;
		}

		// Get values
		let km_depart = document.getElementById('km_depart').value;
		let oldkm_depart = document.getElementById('oldkm_depart').value;
		row++;

		// Check values
		if (km_depart == oldkm_depart)
		{
			compare++;
		}

		// Get values
		let km_arrive = document.getElementById('km_arrive').value;
		let oldkm_arrive = document.getElementById('oldkm_arrive').value;
		row++;

		// Check values
		if (km_arrive == oldkm_arrive)
		{
			compare++;
		}

		// Check counts
		if (compare == row)
		{
			alert("les valeurs sont identiques");
			return false;
		}
		return true;
	}


//////////////////////////////////////////////



function validateFormLieuEdit()
{

	// Count
	let compare = 0;
	let row = 0;

	// Get values
	let surnom = document.getElementById('surnom').value;
	let oldsurnom = document.getElementById('oldsurnom').value;
	row++;

	// Check values
	if (surnom == oldsurnom)
	{
		compare++;
	}

	// Get values
	let nom_lieu = document.getElementById('nom_lieu').value;
	let oldnom_lieu = document.getElementById('oldnom_lieu').value;
	row++;

	// Check values 
	if (nom_lieu == oldnom_lieu)
	{
		compare++;
	}

	// Get values
	let code_postal = document.getElementById('code_postal').value;
	let oldcode_postal = document.getElementById('oldcode_postal').value;
	row++;

	// Check values 
	if (code_postal == oldcode_postal)
	{
		compare++;
	}

	// Get values
	let numero = document.getElementById('numero').value;
	let oldnumero = document.getElementById('oldnumero').value;
	row++;

	// Check values 
	if (numero == oldnumero)
	{
		compare++;
	}

	// Get values
	let adresse = document.getElementById('adresse').value;
	let oldadresse = document.getElementById('oldadresse').value;
	row++;

	// Check values 
	if (adresse == oldadresse)
	{
		compare++;
	}

	// Check counts
	if (compare == row)
	{
		alert("les valeurs sont identiques");
		return false;
	}
	return true;
}


//////////////////////////////////////////////


function validateFormInfractionEdit()
{

	// Count
	let compare = 0;
	let row = 0;

	// Get values
	let id_mission = document.getElementById('id_mission').value;
	let oldid_mission = document.getElementById('oldid_mission').value;
	row++;

	// Check values 
	if (id_mission == oldid_mission)
	{
		compare++;
	}

	// Get values
	let date_infraction = document.getElementById('date_infraction').value;
	let olddate_infraction = document.getElementById('olddate_infraction').value;
	row++;

	// Check values 
	if (date_infraction == olddate_infraction)
	{
		compare++;
	}

	// Get values
	let commentaire = document.getElementById('commentaire').value;
	let oldcommentaire = document.getElementById('oldcommentaire').value;
	row++;

	// Check values 
	if (commentaire == oldcommentaire)
	{
		compare++;
	}

	// Get values
	let points = document.getElementById('points').value;
	let oldpoints = document.getElementById('oldpoints').value;
	row++;

	// Check values 
	if (points == oldpoints)
	{
		compare++;
	}
	// Get values
	let prix = document.getElementById('prix').value;
	let oldprix = document.getElementById('oldprix').value;
	row++;

	// Check values 
	if (prix == oldprix)
	{
		compare++;
	}

	// Get values
	let stationnement = (document.getElementById('stationnement').checked ? 1 : 0 );
	let oldstationnement = document.getElementById('oldstationnement').value;
	row++;

	// Check values 
	if (stationnement == oldstationnement)
	{
		compare++;
	}
	// Check counts
	if (compare == row)
	{
		alert("les valeurs sont identiques");
		return false;
	}
	return true;
}


//////////////////////////////////////////////


function validateFormTrajetEdit()
{

	// Count
	let compare = 0;
	let row = 0;

	// Get values
	let lieu_depart = document.getElementById('id_lieu_depart').value;
	let old_lieu_depart = document.getElementById('oldid_lieu_depart');
	row++;

	// Check values
	if (lieu_depart == old_lieu_depart)
	{
		compare++;
	}

	// Get values
	let lieu_arrive = document.getElementById('id_lieu_arrive').value;
	let old_lieu_arrive = document.getElementById('oldid_lieu_arrive');
	row++;

	// Check values
	if (lieu_arrive == old_lieu_arrive)
	{
		compare++;
	}

	// Get values
	let motif = document.getElementById('motif').value;
	let oldmotif = document.getElementById('oldmotif').value;
	row++;

	// Check values
	if (motif == oldmotif)
	{
		compare++;
	}

	// Get values
	let date_debut = document.getElementById('date_debut').value;
	let olddate_debut = document.getElementById('olddate_debut').value;
	row++;

	// Check values
	if (date_debut == olddate_debut)
	{
		compare++;
	}

	// Check counts
	if (compare == row)
	{
		alert("les valeurs sont identiques");
		return false;
	}
	return true;
}