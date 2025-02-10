<?php
include"../conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form inputs
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $id_no = $conn->real_escape_string($_POST['id_no']);
    $role = $conn->real_escape_string($_POST['role']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $faculty = $conn->real_escape_string($_POST['faculty']);
    $contact_start = $conn->real_escape_string($_POST['contact_start']);
    $contact_end = $conn->real_escape_string($_POST['contact_end']);

    // SQL query to insert data into the interns table
    $sql = "INSERT INTO interns (first_name, last_name, id_no, role, gender, faculty, contact_start, contact_end)
            VALUES ('$first_name', '$last_name', '$id_no', '$role', '$gender', '$faculty', '$contact_start', '$contact_end')";

    // Execute the query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "New intern added successfully!";
        // Optionally redirect to a page to avoid re-submission if the page is refreshed
        // header('Location: success_page.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
