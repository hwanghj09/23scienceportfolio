<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbHost = 'svc.sel4.cloudtype.app:32632';
$dbUser = 'root';
$dbPassword = 'qwaszx77^^';
$dbName = 'nagwon';

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = $isLoggedIn && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];

$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($isLoggedIn) {
    $username = $_SESSION['username'];
}
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
        #addAnnouncementBtn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .user-info {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .user-info a {
            margin-left: 10px;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .user-info a:hover {
            color: #ccc;
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
        <div class="user-info">
            <?php
            if ($isLoggedIn) {
                echo '<div>' . $username . '</div>';
                echo '<a href="settings.php">설정</a>';
                echo '<a href="logout.php">로그아웃</a>';
            } else {
                echo '<a onclick="redirectToLogin()">로그인</a>';
                echo '<a onclick="redirectToSignup()">회원가입</a>';
            }
            ?>
        </div>
    </header>

    <nav>
        <a onclick="showNotice()">공지사항</a>
        <a onclick="showStudy()">Study</a>
        <a onclick="showPlay()">Play</a>
        
        <a href="http://xn--s39aj90b0nb2xw6xh.kr/">시간표</a>
        <?php
        if ($isLoggedIn && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            echo '<a id="addAnnouncementBtn" onclick="addAnnouncement()">공지 작성</a>';
            echo '';
        }
        ?>
    </nav>

    <div id="noticeSection" class="content-section">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card announcement" onclick="readAnnouncement(' . $row['id'] . ')">';
            echo '<h3>' . $row['title'] . '</h3>';
            echo '</div>';
        }
        ?>
    </div>

    <div id="studySection" class="content-section" style="display: none;">
        <h2>Study</h2>
        <p></p>
    </div>

    <div id="playSection" class="content-section" style="display: none;">
        <h2>Play</h2>
        <p></p>
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

        function redirectToLogin() {
            window.location.href = 'login.php';
        }

        function redirectToSignup() {
            window.location.href = 'signup.php';
        }
    </script>
</body>

</html>
