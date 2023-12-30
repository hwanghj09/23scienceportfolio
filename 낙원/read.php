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
    $sql = "SELECT * FROM announcements WHERE id = $announcementId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row["title"];
        $content = $row["content"];
        $createdAt = $row["created_at"];

        // Check if the user is an admin to show the delete button
        $deleteButton = $isAdmin ? '<button onclick="deleteAnnouncement(' . $announcementId . ')">삭제하기</button>' : '';
    } else {
        $title = "Not Found";
        $content = "The announcement with ID $announcementId was not found.";
        $createdAt = "";
        $deleteButton = '';
    }
} else {
    $title = "Not Found";
    $content = "No announcement ID specified.";
    $createdAt = "";
    $deleteButton = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- (이하 생략) -->
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

    <div class="container">
        <div class="card">
            <div class="content-section">
                <div class="announcement">
                    <h2><?= $title ?></h2>
                    <p><?= $content ?></p>
                    <p>올라간 날짜: <?= $createdAt ?></p>
                    <?= $deleteButton ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
