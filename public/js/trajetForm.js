let trajetIndex = 1;

// Get the container that will hold all trajet rows
const container = document.getElementById('trajets-container');

// Listen for a click on the "Add trajet" button
document.getElementById('add-trajet').addEventListener('click', function ()
{
	// Get the first trajet row
	const firstRow = container.querySelector('.trajet-row');

	// Clone the first trajet row, including its children
	const newRow = firstRow.cloneNode(true);

	// Create a visual separator between trajet rows
	const separator = document.createElement('hr');

	// Add Bootstrap classes to make the separator darker
	separator.className = 'border border-dark opacity-75';

	// Insert the separator at the beginning of the cloned row
	newRow.prepend(separator);

	// Get the trajet title inside the cloned row
	const title = newRow.querySelector('.trajet-title');

	// Update the title with the correct trajet number
	title.textContent = 'Lieu d\'arrivé ' + (trajetIndex + 1);

	// Loop through all select elements inside the cloned row
	newRow.querySelectorAll('select').forEach(function (select)
	{

		// Replace the old array index with the new one
		select.name = select.name.replace(/\[\d+\]/,`[${trajetIndex}]`);

		// Reset the selected value
		select.selectedIndex = 0;
	});

	// Create remove button
	const removeButton = document.createElement('button');

	// Prevent the button from submitting the form
	removeButton.type = 'button';

	// Add Bootstrap classes and a custom class
	removeButton.classList.add('btn','btn-danger', 'mt-3', 'remove-trajet');

	// Set the button text
	removeButton.textContent = 'Supprimer trajet';

	// Add the remove button to the cloned row
	newRow.appendChild(removeButton);

	// Add the new trajet row to the container
	container.appendChild(newRow);

	// Increment the index for the next trajet
	updateTrajetIndexes();
});


// Listen for clicks inside the trajet container
container.addEventListener('click', function (event)
{
	// Check if the clicked element is a remove button
	if (event.target.classList.contains('remove-trajet'))
	{
		// Find the closest trajet row and remove it
		event.target.closest('.trajet-row').remove();

		// Deincrement the index for the next trajet
		updateTrajetIndexes();
	}
});


function updateTrajetIndexes()
{
	// Get all trajet rows currently displayed in the form
	const rows = container.querySelectorAll('.trajet-row');

	// Loop through each trajet row and get its current position
	rows.forEach(function (row, index)
	{
		// Get the title of the current trajet row
		const title = row.querySelector('.trajet-title');

		// Update the visible trajet number
		title.textContent = 'Lieu d\'arrivé ' + (index + 1);

		// Get all select elements inside the current trajet row
		row.querySelectorAll('select').forEach(function (select)
		{
			// Replace the old array index in the name with the current index
			select.name = select.name.replace(/\[\d+\]/,`[${index}]`);
		});
	});

	// Set the next trajet index according to the number of existing rows
	trajetIndex = rows.length;
}