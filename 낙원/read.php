<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbHost = 'svc.sel4.cloudtype.app:32632';
$dbUser = 'root';
$dbPassword = 'qwaszx77^^';
$dbName = 'nagwon';

// Create connection
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session
session_start();

// Check if the user is an admin
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];

// Fetch announcement details based on ID
if (isset($_GET['id'])) {
    $announcementId = $_GET['id'];
    $sql = "SELECT announcements.*, users.username
            FROM announcements
            INNER JOIN users ON announcements.user_id = users.id
            WHERE announcements.id = $announcementId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row["title"];
        $content = $row["content"];
        $createdAt = $row["created_at"];
        $username = $row["username"];
        $deleteButton = $isAdmin ? '<button onclick="deleteAnnouncement(' . $announcementId . ')">삭제하기</button>' : '';
    } else {
        $title = "Not Found";
        $content = "The announcement with ID $announcementId was not found.";
        $createdAt = "";
        $username = "";
        $deleteButton = '';
    }
} else {
    $title = "Not Found";
    $content = "No announcement ID specified.";
    $createdAt = "";
    $username = "";
    $deleteButton = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Planet: Mango</title>
    <link rel="icon" href="https://i.ibb.co/FgydS5v/mango-icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&family=Jua&display=swap" rel="stylesheet">
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

        .content-section {
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            background-color: #555;
            border-radius: 10px;
        }

        .announcement h3 {
            margin-bottom: 10px;
        }

        .announcement p {
            color: #ccc;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function deleteAnnouncement(announcementId) {
            Swal.fire({
                title: '정말로 삭제하시겠습니까?',
                text: "삭제된 공지는 복구할 수 없습니다!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '삭제하기'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete the announcement
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Redirect to the main page after deletion
                            window.location.href = 'index.php';
                        }
                    };
                    xhr.open("GET", "delete_announcement.php?id=" + announcementId, true);
                    xhr.send();
                }
            });
        }
    </script>
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <h1>엄청난!</h1>
            </a>
        </div>
    </header>
    <div class="announcement">
        <h2><?= $title ?></h2>
        <p><?= $content ?></p>
        <p>올라간 날짜: <?= $createdAt ?></p>
        <p>작성자: <?= $username ?></p>
        <?= $deleteButton ?>
    </div>
</body>

</html>
