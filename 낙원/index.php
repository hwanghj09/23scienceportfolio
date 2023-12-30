<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "svc.sel4.cloudtype.app:31934"; // replace with your actual database host
$username = "root";
$password = "nagwon";
$dbname = "announcements_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch announcements from the database
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planet: Mango</title>
    <link rel="icon" href="https://i.ibb.co/FgydS5v/mango-icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&family=Jua&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        body {
            font-family: 'Comfortaa', 'Jua', cursive;
            font-weight: 600;
            color: white;
            background-color: #1a1a1a;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #333;
            padding: 1rem;
            text-align: center;
            color: white;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            font-size: 1.2rem;
            margin: 0 15px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        nav a:hover {
            background-color: #555;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #2c2c2c;
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* New styles for content sections */
        .content-section {
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            background-color: #555;
            border-radius: 10px;
        }

        .announcement {
            cursor: pointer;
            margin-bottom: 10px;
            transition: background-color 0.3s ease-in-out;
        }

        .announcement:hover {
            background-color: #444;
        }

        .announcement h3 {
            margin-bottom: 0;
        }

        /* Added styles for the button */
        #addAnnouncementBtn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <h1>엄청난!</h1>
            </a>
        </div>
    </header>

    <nav>
        <a onclick="showNotice()">공지사항</a>
        <a onclick="showStudy()">Study</a>
        <a onclick="showPlay()">Play</a>
        <a href="http://xn--s39aj90b0nb2xw6xh.kr/">시간표</a>

        <!-- 공지 작성 버튼 -->
        <button id="addAnnouncementBtn" onclick="addAnnouncement()">공지 작성</button>

        <!-- 로그인 및 회원가입 버튼 -->
        <button onclick="redirectToLogin()">로그인</button>
        <button onclick="redirectToSignup()">회원가입</button>
    </nav>
    <div id="studySection" class="content-section" style="display: none;">
        <h2>Study</h2>
        <p>여기에 Study 관련 내용을 넣어주세요.</p>
    </div>

    <div id="playSection" class="content-section" style="display: none;">
        <h2>Play</h2>
        <p>여기에 Play 관련 내용을 넣어주세요.</p>
    </div>

    <script>
        function showNotice() {
            document.getElementById('noticeSection').style.display = 'block';
            document.getElementById('studySection').style.display = 'none';
            document.getElementById('playSection').style.display = 'none';
        }

        function showStudy() {
            document.getElementById('studySection').style.display = 'block';
            document.getElementById('noticeSection').style.display = 'none';
            document.getElementById('playSection').style.display = 'none';
        }

        function showPlay() {
            document.getElementById('playSection').style.display = 'block';
            document.getElementById('noticeSection').style.display = 'none';
            document.getElementById('studySection').style.display = 'none';
        }

        function readAnnouncement(id) {
            window.location.href = 'read.php?id=' + id;
        }

        // Function to add announcement
        function addAnnouncement() {
            window.location.href = 'announcements_write.php';
        }
        function addAnnouncement() {
        window.location.href = 'announcements_write.php';
        }

        // Function to redirect to login page
        function redirectToLogin() {
            window.location.href = 'login.php';
        }

        // Function to redirect to signup page
        function redirectToSignup() {
            window.location.href = 'signup.php';
        }
    </script>
</body>

</html>
