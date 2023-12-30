<?php
session_start();

$host = 'svc.sel4.cloudtype.app:32632';
$user = 'root';
$password = 'qwaszx77^^';
$database = 'quiz';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // 보안 향상: 세션 및 쿠키 보안 적용
            session_start();
            $_SESSION['user_id'] = $row['id'];
            setcookie("user_id", base64_encode($row['id']), time() + (86400 * 30), "/");
            setcookie("username", base64_encode($row['username']), time() + (86400 * 30), "/");

            // CSRF 토큰 생성 및 세션에 저장
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            header("Location: index.php");
            exit();
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: '비밀번호가 일치하지 않습니다.',
                        text: '다시 비밀번호를 입력해주세요.',
                        confirmButtonText: '확인'
                    });
                </script>";
        }
    } else {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: '존재하지 않는 아이디입니다.',
                        text: '다른 아이디를 사용해주세요.',
                        confirmButtonText: '확인'
                    });
                </script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 300px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

    <h2>Login</h2>

    <form action="" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
        <a href="register.php">Sign up</a>
    </form>

</body>
</html>
