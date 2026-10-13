// Manage destination rows in both create and edit forms
const container = document.getElementById('trajets-container');
const addButton = document.getElementById('add-trajet');

// Update the title, name and remove button of each trajet
function updateTrajetIndexes()
{

	// Get all trajet rows
	const rows = container.querySelectorAll('.trajet-row');

	// Loop through each trajet row
	rows.forEach((row, index) => {

		// Update the arrival location number
		row.querySelector('.trajet-title').textContent = "Lieu d'arrivée " + (index + 1);

		// Update the select name with the correct index
		row.querySelector('select').name = `arrivees[${index}]`;

		// Get the remove button of the current trajet
		const removeButton = row.querySelector('.remove-trajet');

		// Hide the remove button for the first trajet
		if (removeButton) removeButton.hidden = index === 0;
	});
}

// Check if the form elements exist
if (container && addButton)
{

	// Add a new trajet when clicking the add button
	addButton.addEventListener('click', () => {

		// Get the first trajet row
		const firstRow = container.querySelector('.trajet-row');

		// Stop if no trajet row exists
		if (!firstRow) return;

		// Clone the first trajet row
		const newRow = firstRow.cloneNode(true);

		// Reset the selected arrival location
		newRow.querySelector('select').selectedIndex = 0;

		// Remove the existing remove button from the cloned row
		const oldButton = newRow.querySelector('.remove-trajet');
		if (oldButton) oldButton.remove();

		// Create a separator between trajets
		const separator = document.createElement('hr');
		separator.className = 'border border-dark opacity-75';

		// Add the separator at the beginning of the new row
		newRow.prepend(separator);

		// Create a button to remove the new trajet
		const removeButton = document.createElement('button');
		removeButton.type = 'button';
		removeButton.className = 'btn btn-danger mt-3 remove-trajet';
		removeButton.textContent = 'Supprimer trajet';

		// Add the remove button to the new row
		newRow.appendChild(removeButton);

		// Add the new trajet row to the form
		container.appendChild(newRow);

		// Update all trajet indexes
		updateTrajetIndexes();
	});

	// Handle clicks on remove buttons
	container.addEventListener('click', event => {

		// Find the remove button that was clicked
		const button = event.target.closest('.remove-trajet');

		// Stop if the click was not on a remove button
		if (!button) return;

		// Find the trajet row containing the button
		const row = button.closest('.trajet-row');

		// Remove the row only if it is not the first trajet
		if (row && row !== container.querySelector('.trajet-row'))
		{

			// Remove the selected trajet row
			row.remove();

			// Update all remaining trajet indexes
			updateTrajetIndexes();
		}
	});

	// Initialize trajet indexes when the page loads
	updateTrajetIndexes();
}