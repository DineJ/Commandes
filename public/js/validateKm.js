const kmDepart = document.getElementById('km_depart');
const kmArrive = document.getElementById('km_arrive');

// Check if the kilometer values are valid
function validateKm()
{
	kmArrive.setCustomValidity('');
	if (kmDepart.value !== '' && kmArrive.value !== '' && (Number(kmArrive.value) <= Number(kmDepart.value)))
	{
		kmArrive.setCustomValidity("Le kilométrage d'arrivée doit être supérieur au kilométrage de départ");
	}
}
kmDepart.addEventListener('input', validateKm);
kmArrive.addEventListener('input', validateKm);
