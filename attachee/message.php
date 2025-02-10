<?php 
// Include the database connection
include_once "../conn.php"; 
include_once "../supavisor/header.php";
$user_id = 1; // Example: Replace with actual logged-in user ID
if (isset($_POST['login'])) {
    $updateStatusQuery = "UPDATE users SET status = 'Online' WHERE id = $user_id";
    $conn->query($updateStatusQuery);
}

// Handle User Logout - Update status to Offline when a user logs out
if (isset($_POST['logout'])) {
    $updateStatusQuery = "UPDATE users SET status = 'Offline' WHERE id = $user_id";
    $conn->query($updateStatusQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body.dark-mode {
            background-color: #181818;
            color: white;
        }
        .light-mode {
            background-color: #f9f9f9;
            color: black;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f7;
        }

        .sidebar {
            height: 100vh;
            background: #131520;
            color: white;
            padding: 20px;
            position: fixed;
            width: 20vw;
            transition: all 0.3s ease;
        }

        .sidebar ul li {
            list-style: none;
            padding: 12px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background: white;
            color: black;
            padding-left: 10px;
            border-radius: 5px;
        }

        .profile img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
            border: 4px solid white;
        }

        .active-feeds {
            width: 20vw;
            background-color: #f8f9fa;
            height: 100vh;
            padding: 30px;
            position: fixed;
            left: 20vw;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
        }

        .feed-user {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .feed-user img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid #0d6efd;
        }

        .chat-container {
            margin-left: 40vw;
            padding: 30px;
            width: calc(100vw - 40vw);
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .chat-body {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .message-box {
            border-radius: 20px;
            padding: 12px 20px;
            max-width: 60%;
            display: inline-block;
            margin-bottom: 10px;
        }

        .message-box.received {
            background: #e9ecef;
            align-self: flex-start;
        }

        .message-box.sent {
            background: #0d6efd;
            color: white;
            align-self: flex-end;
        }

        .chat-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 15px;
            border-top: 1px solid #dee2e6;
        }

        .chat-footer input {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #dee2e6;
        }

        .chat-footer button {
            border-radius: 20px;
        }

        .feed-user:active {
            background-color: antiquewhite;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
<div class="profile mb-3">
                    <img id="profile-img" src="../img/back.png" alt="profile">
                    <h4 id="user-name" class="ms-3"><?php echo htmlspecialchars($username); ?></h4>
                    <h6 id="user-email"><?php echo htmlspecialchars($email); ?></h6>
                </div>
                
    <ul>
        <li class="nav-item"><a class="nav-link" href="./dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="./dashboard.php#tasks"><i class="fas fa-tasks"></i> MyTasks</a></li>
        <li class="nav-item"><a class="nav-link" href="./dashboard.php#projects"><i class="fas fa-project-diagram"></i> Projects</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-bell"></i> Notifications</a></li>
        <li class="nav-item"><a class="nav-link" href="message.php"><i class="fas fa-envelope"></i> Messages</a></li>
        <li class="nav-item"><a class="nav-link" href="./settings.php"><i class="fas fa-cogs"></i> Settings</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
    </ul>
</div>

<!-- Active Users -->
<div class="active-feeds">
    <h6>Active</h6>
    <div id="active-users">
        <!-- Active users will be injected here -->
    </div>
</div>

<!-- Chat Container -->
<div class="chat-container">
    <div class="chat-header">
        <div><strong id="chat-user-name">Select a user</strong> <span id="chat-status" class="text-muted">● Offline</span></div>
        <button class="btn btn-outline-primary" id="view-profile-btn" style="display:none;">View Profile</button>
    </div>
    <div class="chat-body d-flex flex-column" id="chat-box">
        <!-- Chat messages go here -->
    </div>
    <div class="chat-footer">
        <form method="POST">
            <input type="text" name="message" placeholder="Type a message..." required>
            <button class="btn btn-primary" type="submit" name="send_message">Send</button>
        </form>
    </div>
</div>

<!-- JavaScript to handle real-time user status and messages -->
<script>
    // Fetch active users every 3 seconds
    function fetchActiveUsers() {
        fetch('../get_active_users.php')
            .then(response => response.json())
            .then(data => {
                let userList = '';
                data.forEach(user => {
                    let statusClass = user.status === 'Online' ? 'text-success' : 'text-warning';
                    let statusText = user.status === 'Online' ? '● Online' : '● Away';
                    userList += `
                        <div class="feed-user" data-id="${user.id}" data-name="${user.username}" data-status="${user.status}" data-profile="${user.profile_picture}">
                            <img src="img/${user.profile_picture}" alt="${user.username}">
                            <div>
                                <h6>${user.username}</h6>
                                <span class="${statusClass}">${statusText}</span>
                            </div>
                        </div>
                    `;
                });
                document.getElementById('active-users').innerHTML = userList;

                // Add click event listener to each user in the list
                const users = document.querySelectorAll('.feed-user');
                users.forEach(user => {
                    user.addEventListener('click', function() {
                        const username = this.getAttribute('data-name');
                        const status = this.getAttribute('data-status');
                        const profile = this.getAttribute('data-profile');
                        const userId = this.getAttribute('data-id');

                        // Update the chat header with the selected user's info
                        document.getElementById('chat-user-name').innerText = username;
                        document.getElementById('chat-status').innerText = status === 'Online' ? '● Online' : '● Away';
                        document.getElementById('view-profile-btn').style.display = 'inline-block';
                        document.getElementById('view-profile-btn').setAttribute('onclick', `viewProfile(${userId})`);
                    });
                });
            });
    }

    function viewProfile(userId) {
        // You can fetch the user profile details from the database or redirect to another page to show the profile
        alert('Viewing profile of user ID: ' + userId);
    }

    setInterval(fetchActiveUsers, 3000); // Fetch active users every 3 seconds
</script>

<?php
// Handling message submission (you can add your logic here)
// Send message via an AJAX request
if (isset($_POST['send_message'])) {
    $sender_id = 1; // Example sender ID, replace with actual
    $receiver_id = 2; // Example receiver ID, replace with actual
    $message = $_POST['message'];
    
    $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($sender_id, $receiver_id, '$message')";
    $conn->query($query);
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
