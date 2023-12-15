<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }

        h1 {
            color: #333;
            cursor: pointer;
        }

        .main-content {
            text-align: center;
            padding: 20px;
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
            transform: scale(1.5); /* 변경된 부분 */
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .sidebutton:hover {
            transform: scale(1.6); /* 변경된 부분 */
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

        .start-button {
            padding: 250px;
            text-align: center;
            animation: pulse 2s infinite;
            cursor: pointer;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.5);
            }
            100% {
                transform: scale(1);
            }
        }

    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <title>Main</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
                createButton('Sign Out', 'signOut');
                createButton('Delete Account', 'deleteAccount');
            } else {
                createButton('Login', 'login');
                createButton('Sign Up', 'register');
                createButton('Ranking', 'ranking');
            }
        }

        function createButton(text, action) {
            const button = document.createElement('button');
            button.textContent = text;
            button.onclick = function () {
                if (action === 'deleteAccount') {
                    confirmDeleteAccount();
                } else {
                    openPage(action + '.php');
                }
            };
            document.querySelector('.sidebar-content').appendChild(button);
        }

        function openPage(page) {
            if (page == 'signOut.php') {
                document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                window.onload();
            } else {
                document.location.href = page;
            }
        }

        function confirmDeleteAccount() {
            Swal.fire({
                title: '계정 삭제',
                text: '정말로 계정을 삭제하시겠습니까?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '예',
                cancelButtonText: '아니오'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteAccount();
                }
            });
        }

        function deleteAccount() {
            document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            window.onload();
        }

        // 쿠키에서 특정 키의 값을 가져오는 함수
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // 페이지 로드 시 로그인 상태 확인
        window.onload = checkLoginStatus;

        // 퀴즈 시작 함수
        function startQuiz() {
            const userIdCookie = getCookie("user_id");

            if (!userIdCookie) {
                // SweetAlert2을 사용하여 더 이쁘게 표현
                Swal.fire({
                    icon: 'error',
                    title: '로그인 필요',
                    text: '로그인 후 퀴즈를 시작할 수 있습니다.',
                    confirmButtonText: '확인',
                }).then(() => {
                    openPage('login.php');
                });
            } else {
                // 로그인 상태일 때 퀴즈 페이지로 이동
                openPage('quiz.php');
            }
        }

    </script>
</head>
<body>
    <div class="start-button" onclick="startQuiz()"><h1>Click to Start!</h1></div>
    <div class="sidebar-button">
        <button class="sidebutton" onclick="toggleSidebar()">☰</button>
    </div>

    <div class="sidebar">
        <div class="sidebar-content">
        </div>
    </div>
</body>
</html>
