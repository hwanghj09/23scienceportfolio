<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbHost = 'svc.sel4.cloudtype.app:32632';
$dbUser = 'root';
$dbPassword = 'qwaszx77^^';
$dbName = 'quiz';

// Create connection
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the current user's information
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentName = $row['username'];
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateName'])) {
        // Update user's name
        $newName = $_POST['newName'];
        $updateNameSql = "UPDATE users SET username = '$newName' WHERE username = '$username'";
        $conn->query($updateNameSql);
        $currentName = $newName;
        echo '<script>alert("이름이 성공적으로 변경되었습니다.");</script>';
    } else if (isset($_POST['updatePassword'])) {
        // Update user's password
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];

        // Check current password
        $checkPasswordSql = "SELECT password FROM users WHERE username = '$username'";
        $checkResult = $conn->query($checkPasswordSql);

        if ($checkResult->num_rows > 0) {
            $row = $checkResult->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($currentPassword, $hashedPassword)) {
                // Current password is correct, update the password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updatePasswordSql = "UPDATE users SET password = '$hashedNewPassword' WHERE username = '$username'";
                $conn->query($updatePasswordSql);
                echo '<script>alert("비밀번호가 성공적으로 변경되었습니다.");</script>';
            } else {
                echo '<script>alert("현재 비밀번호가 올바르지 않습니다.");</script>';
            }
        }
    } elseif (isset($_POST['deleteAccount'])) {
        // Delete user account
        $deleteAccountSql = "DELETE FROM users WHERE username = '$username'";
        $conn->query($deleteAccountSql);
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- (이하 생략) -->
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

        /* 추가된 스타일 */
        .settings-section {
            max-width: 400px;
            margin: 20px auto;
            background-color: #555;
            padding: 20px;
            border-radius: 10px;
        }

        .settings-section label {
            display: block;
            margin-bottom: 10px;
        }

        .settings-section input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .settings-section button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-account-button {
            background-color: #ff5252;
            margin-top: 10px;
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

    <div class="container">
        <div class="card">
            <div class="content-section settings-section">
                <h2>사용자 설정</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="newName">새로운 이름:</label>
                    <input type="text" id="newName" name="newName" value="<?php echo $currentName; ?>" required>

                    <button type="submit" name="updateName">이름 변경</button>
                </form>

                <hr>

                <h2>비밀번호 변경</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="currentPassword">현재 비밀번호:</label>
                    <input type="password" id="currentPassword" name="currentPassword" required>

                    <label for="newPassword">새로운 비밀번호:</label>
                    <input type="password" id="newPassword" name="newPassword" required>

                    <button type="submit" name="updatePassword">비밀번호 변경</button>
                </form>

                <hr>

                <h2>계정 삭제</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <p>계정을 삭제하면 모든 데이터가 손실됩니다. 정말 삭제하시겠습니까?</p>
                    <button type="submit" name="deleteAccount" class="delete-account-button">계정 삭제</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
