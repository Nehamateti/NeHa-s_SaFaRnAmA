document.addEventListener('DOMContentLoaded', function () {
    // Get the category from the URL query string
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category');

    if (category) {
        // Call the function to filter the destinations based on the category
        filterDestinationsByCategory(category);
    }
});

// Function to filter destinations by category
function filterDestinationsByCategory(category) {
    // Make an AJAX request to fetch the filtered destinations based on the category
    fetch('destinations.php?category=' + category)
        .then(response => response.json())
        .then(data => {
            // Get the destinations container
            const destinationsTableBody = document.querySelector('.destinations-table tbody');
            
            // Clear any existing rows
            destinationsTableBody.innerHTML = '';

            // Check if there are no destinations found
            if (data.length === 0) {
                destinationsTableBody.innerHTML = `<tr><td colspan="5">No destinations found for ${category} activities.</td></tr>`;
            } else {
                // Populate the table with the filtered destinations
                data.forEach(destination => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${destination.name}</td>
                        <td>${destination.suggested_type}</td>
                        <td>${destination.description}</td>
                        <td>${destination.budget}</td>
                        <td>${destination.activity_category}</td>
                    `;
                    destinationsTableBody.appendChild(row);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching destinations:', error);
        });
}
