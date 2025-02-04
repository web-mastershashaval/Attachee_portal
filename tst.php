<!-- Projects Table (Your Existing Code) -->
 <?php include "./conn.php"; ?>
<div class="table-container">
    <h4>Projects</h4>
    <li><a href="">All projects</a></li>
    <button type="button" class="btn btn-success">Add Record</button>
    <button id="add" type="button" class="btn btn-danger">Delete Record</button>
    <table class="projects-table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Id No</th>
                <th>Attachee Name</th>
                <th>Project Name</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Faculty</th>
                <th>Actions</th> <!-- Add Action column -->
            </tr>
        </thead>
        <tbody>
            <!-- Loop through projects data and display each project -->
            <?php
            // Assuming you have an array or database result for projects
            $projects = [
                // Example projects array, replace with your actual database query
                [
                    'id' => 1,
                    'attachee_name' => 'Samba Ernest',
                    'project_name' => 'Attachee Portal',
                    'id_no' => 'dse-01-4117/2022',
                    'deadline' => '2025-04-21',
                    'status' => 'In progress',
                    'faculty' => 'Software and Networking dpt',
                ],
                [
                    'id' => 2,
                    'attachee_name' => 'John Doe',
                    'project_name' => 'Web Development',
                    'id_no' => 'dse-01-3123/2023',
                    'deadline' => '2025-05-15',
                    'status' => 'Completed',
                    'faculty' => 'Computer Science dpt',
                ],
                // Add more project data here
            ];

            // Loop through each project and display them in the table
            foreach ($projects as $project) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($project['id']) . "</td>";
                echo "<td>" . htmlspecialchars($project['id_no']) . "</td>";
                echo "<td>" . htmlspecialchars($project['attachee_name']) . "</td>";
                echo "<td>" . htmlspecialchars($project['project_name']) . "</td>";
                echo "<td>" . htmlspecialchars($project['deadline']) . "</td>";
                echo "<td>" . htmlspecialchars($project['status']) . "</td>";
                echo "<td>" . htmlspecialchars($project['faculty']) . "</td>";
                echo "<td>
                        <button class='btn btn-primary' onclick='openAssignModal(" . htmlspecialchars($project['id']) . ")'>Assign Intern</button>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Assign Intern Modal -->
<div id="assignModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Intern to Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="assignForm" method="POST" action="assign_intern.php">
                    <input type="hidden" name="project_id" id="project_id">
                    <div class="form-group">
                        <label for="internSelect">Select Intern</label>
                        <select class="form-control" name="intern_id" id="internSelect">
                            <!-- Loop through interns from PHP -->
                            <?php
                            foreach ($internsData as $intern) {
                                echo "<option value='" . $intern['_id'] . "'>" . htmlspecialchars($intern['first_name']) . ' ' . htmlspecialchars($intern['last_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Intern</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Function to open the Assign Intern Modal
    function openAssignModal(projectId) {
        // Set the project ID in the modal
        document.getElementById('project_id').value = projectId;
        // Show the modal
        $('#assignModal').modal('show');
    }
</script>
