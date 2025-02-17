<?php 
include "../conn.php";

// Check if the connection is open
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error()); // This will show an error if the connection isn't open
}

// Query to fetch notifications
$query = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    // Debugging: If the prepare statement fails, output the error.
    die('Error preparing the statement: ' . $conn->error);
}

$stmt->bind_param("i", $_SESSION['user_id']);  // Using the correct user_id directly from session
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $notification_id = $data['notification_id'];

    // Update query to mark notification as read
    $update_query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);

    if ($update_stmt === false) {
        // Debugging: If the prepare statement for update fails, output the error.
        die('Error preparing the update statement: ' . $conn->error);
    }

    $update_stmt->bind_param("i", $notification_id);
    $update_stmt->execute();

    echo json_encode(['status' => 'success']);
}

?>