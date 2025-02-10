
<?php
// Connection variables
$servername = "localhost";  // Your MySQL server
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "portal";         // Your MySQL database name

// Create connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// SQL query to fetch projects
$sql = "SELECT id, name FROM projects"; // Adjust this SQL to match your table structure
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Prepare an array to hold project data
    $projects = [];
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row; // Add project data to the array
    }

    // Output the projects as JSON
    echo json_encode($projects);
} else {
    // No projects found, return an empty array
    echo json_encode([]);
}

// Close the MySQL connection
$conn->close();
?>
<!-- Delete Intern Modal -->
<div class="modal" id="deleteInternModal" tabindex="-1" role="dialog" aria-labelledby="deleteInternModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteInternModalLabel">Delete Intern</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this intern?</p>
                <form id="deleteInternForm" action="delete_intern.php" method="POST">
                    <input type="hidden" name="intern_id" id="internId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

// Open the Assign Project Modal
function openAssignModal(internId) {
    // Set the intern ID in the hidden input field
    document.getElementById('internId').value = internId;

    // Fetch projects from the backend and populate the dropdown
    fetch('get_projects.php')
        .then(response => {
            // Check if the response is okay
            if (!response.ok) {
                throw new Error(`HTTP Error: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched Projects:', data); // Log the data for debugging

            // Ensure the data is an array and contains projects
            if (Array.isArray(data) && data.length > 0) {
                const projectSelect = document.getElementById('projectSelect');
                console.log('Project Select:', projectSelect); // Debugging the dropdown

                projectSelect.innerHTML = '';  // Clear any previous options

                // Add a default "Select Project" option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Project';
                projectSelect.appendChild(defaultOption);

                // Populate the dropdown with project options
                data.forEach(project => {
                    const option = document.createElement('option');
                    option.value = project.id;  // Use project id
                    option.textContent = project.name;  // Use project name
                    projectSelect.appendChild(option);
                });

                // Log the final dropdown contents
                console.log('Updated dropdown options:', projectSelect);
            } else {
                // Handle cases where no projects are returned
                console.log('No projects found.');
                alert('No projects available.');
            }
        })
        .catch(error => {
            console.error('Error fetching projects:', error);  // Log the error for debugging
            alert('Error fetching projects. Please try again later.');
        });

    // Show the modal
    $('#assignProjectModal').modal('show');
}
</script>