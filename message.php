<?php include_once "./conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
             body.dark-mode {
            background-color: #181818;
            color: white;
        }

        .dark-mode .container {
            background-color: #222222;
        }

        .dark-mode .btn {
            background-color: #007bff;
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

        .profile h4, .profile h6 {
            text-align: center;
            margin-top: 10px;
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

        .active-feeds h6 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .feed-user {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
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
        .feed-user:active{
            background-color: antiquewhite;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="img/back.png" alt="Profile">
            <h4>Username</h4>
            <h6>usermail@gmail.com</h6>
        </div>
        <ul>
            <li class="nav-item" ><a class="nav-link" href="./supavisor/sp_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="nav-item" ><a class="nav-link" href="./supavisor/sp_dashboard.php#reports"><i class="fas fa-chart-line"></i> Reports</a></li>
            <li class="nav-item" ><a class="nav-link" href="./supavisor/sp_dashboard.php#projects"><i class="fas fa-project-diagram"></i> Projects</a></li>
            <li class="nav-item" ><a class="nav-link" href="./supavisor/sp_dashboard.php#users"><i class="fas fa-user"></i> Users</a></li>
            <li class="nav-item" ><a class="nav-link" href="#"><i class="fas fa-bell"></i> Notifications</a></li>
            <li class="nav-item" ><a class="nav-link" href="message.php"><i class="fas fa-envelope"></i> Messages</a></li>
            <li class="nav-item" ><a class="nav-link" href="/settings.php"><i class="fas fa-cogs"></i> Settings</a></li>
            <li class="nav-item" ><a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
        </ul>
    </div>

    <div class="active-feeds">
        <h6>Active</h6>
        <div class="feed-user">
            <img src="img/back.png" alt="User">
            <div>
                <h6>Mia Johnson</h6>
                <span class="text-success">● Online</span>
            </div>
        </div>
        <div class="feed-user">
            <img src="img/back.png" alt="User">
            <div>
                <h6>Phoenix Baker</h6>
                <span class="text-danger">● Offline</span>
            </div>
        </div>
        <div class="feed-user">
            <img src="img/back.png" alt="User">
            <div>
                <h6>Mollie Hall</h6>
                <span class="text-warning">● Away</span>
            </div>
        </div>
    </div>

    <div class="chat-container">
        <div class="chat-header">
            <div><strong>Mia Johnson</strong> <span class="text-success">● Online</span></div>
            <button class="btn btn-outline-primary">View Profile</button>
        </div>
        <div class="chat-body d-flex flex-column">
            <div class="message-box received">Hey Olivia, I've finished with the requirements doc!</div>
            <div class="message-box sent">Awesome! Thanks. I'll check it today.</div>
        </div>
        <div class="chat-footer">
            <input type="text" placeholder="Type a message...">
            <button class="btn btn-primary">Send</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
