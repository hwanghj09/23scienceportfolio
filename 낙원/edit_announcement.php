<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 데이터베이스 연결 코드 또는 필요한 기능을 포함하세요.

// 세션 시작
session_start();

// 사용자가 로그인하고 관리자인지 확인
if (!(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'])) {
    header("Location: index.php"); // 관리자가 아닌 사용자는 메인 페이지로 리디렉션
    exit();
}

// 수정할 공지사항 세부 정보 가져오기
if (isset($_GET['id'])) {
    $announcementId = $_GET['id'];

    $dbHost = 'svc.sel4.cloudtype.app:32632';
    $dbUser = 'root';
    $dbPassword = 'qwaszx77^^';
    $dbName = 'nagwon';

    // 연결 생성
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 공지사항 세부 정보를 데이터베이스에서 가져오기
    $sql = "SELECT * FROM announcements WHERE id = '$announcementId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $announcementDetails = $result->fetch_assoc();
        $title = $announcementDetails['title'];
        $content = $announcementDetails['content'];
    } else {
        // 공지사항이 존재하지 않을 경우 리디렉션
        header("Location: index.php");
        exit();
    }

    // 데이터베이스 연결 닫기
    $conn->close();
} else {
    // 공지사항 ID가 제공되지 않은 경우 리디렉션
    header("Location: index.php");
    exit();
}

// 공지사항 수정 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbHost = 'svc.sel4.cloudtype.app:32632';
    $dbUser = 'root';
    $dbPassword = 'qwaszx77^^';
    $dbName = 'nagwon';

    // 연결 생성
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // POST 데이터에서 제목과 내용 가져오기
    $updatedTitle = $_POST['title'];
    $updatedContent = $_POST['content'];

    // 공지사항 업데이트 쿼리 실행
    $updateSql = "UPDATE announcements SET title='$updatedTitle', content='$updatedContent' WHERE id='$announcementId'";

    if ($conn->query($updateSql) === TRUE) {
        // 업데이트 후 메인 페이지로 리디렉션
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // 데이터베이스 연결 닫기
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항 수정 - Planet: Mango</title>
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

        h2 {
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #555;
            padding: 20px;
            border-radius: 10px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #ccc;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #444;
            color: white;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>


<body>
    <h2>공지사항 수정</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="announcement_id" value="<?php echo $announcementId; ?>">
        <label for="title">제목:</label>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>

        <label for="content">내용:</label>
        <textarea id="content" name="content" rows="4" required><?php echo $content; ?></textarea>

        <button type="submit">공지사항 업데이트</button>
    </form>
</body>

</html>
