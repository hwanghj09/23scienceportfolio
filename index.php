<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: goldenrod;
        }

        .main-content {
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .sidebutton
        {
            display: block;
            width: 30px;
            height: 30px;
            margin-bottom: 45px;
            text-align: center;
            color: black;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0;
            animation: fadeIn 1.3s ease-in-out forwards;
            transform: scale(2);
            transition: transform 0.3s, box-shadow 0.3s;
          }
      .sidebutton:hover {
        transform: scale(2.05);
        box-shadow: 0 0 1px 2px rgb(0, 0, 0);
      }
      
      .sidebar-button {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 999;
      }
      
      .sidebar {
        position: fixed;
        top: 0;
        right: -300px;
        width: 300px;
        height: 100%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        transition: right 0.3s;
      }
      
      .sidebar.open {
        right: 0;
      }
      
      .sidebar-content {
        padding: 20px;
      }
      
      @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
      }
    </style>
    <title>Your Website</title>
    <script>
    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('open');
    }
  </script>
</head>
<body>
    <h1>Click to Start!</h1>
    <div class="sidebar-button">
      <button class="sidebutton" onclick="toggleSidebar()">≡</button>
    </div>

    <div class="sidebar">
      <div class="sidebar-content">
        <button onclick="openPage('login')">Login</button>
        <button onclick="openPage('signup')">Sign Up</button>
        <button onclick="openPage('settings')">Settings</button>
        <button onclick="openPage('ranking')">Ranking</button>
        <button onclick="openPage('delete')">Delete Account</button>
      </div>
    </div>
</body>
</html>
