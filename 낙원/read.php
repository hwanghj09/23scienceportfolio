<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 퀴즈 데이터베이스 (사용자 정보)에 대한 데이터베이스 연결
$dbHostQuiz = 'svc.sel4.cloudtype.app:32632';
$dbUserQuiz = 'root';
$dbPasswordQuiz = 'qwaszx77^^';
$dbNameQuiz = 'quiz';

$connQuiz = new mysqli($dbHostQuiz, $dbUserQuiz, $dbPasswordQuiz, $dbNameQuiz);

if ($connQuiz->connect_error) {
    die("Connection failed: " . $connQuiz->connect_error);
}

// 공지사항 데이터베이스 (공지 내용)에 대한 데이터베이스 연결
$dbHostAnnouncements = 'svc.sel4.cloudtype.app:32632';
$dbUserAnnouncements = 'root';
$dbPasswordAnnouncements = 'qwaszx77^^';
$dbNameAnnouncements = 'nagwon';

$connAnnouncements = new mysqli($dbHostAnnouncements, $dbUserAnnouncements, $dbPasswordAnnouncements, $dbNameAnnouncements);

if ($connAnnouncements->connect_error) {
    die("Connection failed: " . $connAnnouncements->connect_error);
}

// 세션 시작
session_start();

// 사용자가 관리자인지 확인
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];

// ID를 기반으로 공지사항 세부 정보 가져오기
if (isset($_GET['id'])) {
    $announcementId = $_GET['id'];

    // 공지사항 내용을 공지사항 데이터베이스에서 가져오기
    $sql = "SELECT * FROM announcements WHERE id = '$announcementId'";
    $result = $connAnnouncements->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row["title"];
        $content = $row["content"];
        $createdAt = $row["created_at"];

        // 퀴즈 데이터베이스에서 사용자 정보 가져오기
        $username = $row["user_name"];
        $sqlUser = "SELECT * FROM users WHERE username = '$username'";
        $resultUser = $connQuiz->query($sqlUser);

        if ($resultUser->num_rows > 0) {
            $rowUser = $resultUser->fetch_assoc();
            $username = $rowUser["user_name"];
        } else {
            $username = "알 수 없음";
        }

        $deleteButton = $isAdmin ? '<button onclick="deleteAnnouncement(' . $announcementId . ')">삭제하기</button>' : '';
    } else {
        $title = "찾을 수 없음";
        $content = "ID가 $announcementId인 공지사항을 찾을 수 없습니다.";
        $createdAt = "";
        $username = "";
        $deleteButton = '';
    }
} else {
    $title = "찾을 수 없음";
    $content = "공지사항 ID가 지정되지 않았습니다.";
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
                    // 공지사항 삭제를 위한 AJAX 요청 보내기
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // 삭제 후 메인 페이지로 리디렉션
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
