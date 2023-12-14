<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }

        .main-content {
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .sidebar-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 999;
        }

        .sidebutton {
            display: block;
            width: 30px;
            height: 30px;
            margin-bottom: 45px;
            text-align: center;
            color: #333;
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
            box-shadow: 0 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: #333;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: right 0.3s;
        }

        .sidebar.open {
            right: 0;
        }

        .sidebar-content {
            padding: 20px;
            color: #fff;
            font-size: 18px;  
        }

        .sidebar-content button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .sidebar-content button:hover {
            background: rgba(255, 255, 255, 0.1);
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

        function checkLoginStatus() {
            // 쿠키에서 사용자 아이디 가져오기
            const userIdCookie = getCookie("user_id");
            
            // 버튼 생성
            const sidebarContent = document.querySelector('.sidebar-content');
            sidebarContent.innerHTML = ''; // 기존 내용 초기화

            if (userIdCookie) {
                createButton('Ranking', 'ranking');
                createButton('Settings', 'settings');
                createButton('Sign Out', 'signOut');
                createButton('Delete Account', 'delete');
            } else {
                createButton('Login', 'login');
                createButton('Sign Up', 'register');
                createButton('Ranking', 'ranking');
            }
        }

        function createButton(text, action) {
            const button = document.createElement('button');
            button.textContent = text;
            button.onclick = function() {
                openPage(action + '.php');
            };
            document.querySelector('.sidebar-content').appendChild(button);
        }

        function openPage(page) {
          if(page=='signOut.php')
          {
              document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              window.onload();
          }
          else
          {
            document.location.href = page;
          }
        }

        // 쿠키에서 특정 키의 값을 가져오는 함수
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // 페이지 로드 시 로그인 상태 확인
        window.onload = checkLoginStatus;
    </script>
</head>
<body>
    <a href="quiz.php"><h1>Click to Start!</h1></a>
    <div class="sidebar-button">
        <button class="sidebutton" onclick="toggleSidebar()">☰</button>
    </div>

    <div class="sidebar">
        <div class="sidebar-content">
        </div>
    </div>
</body>
</html>
