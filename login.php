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

    <?php
    // 데이터베이스 연결 정보
    $host = 'svc.sel4.cloudtype.app:32632';
    $user = 'root';
    $password = 'qwaszx77^^';
    $database = 'quiz';

    // MySQL 데이터베이스에 연결
    $conn = new mysqli($host, $user, $password, $database);

    // 연결 오류가 있는지 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 폼이 제출되었는지 확인
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 사용자가 제출한 폼 데이터 가져오기
        $username = $_POST['username'];
        $password = $_POST['password'];

        // 사용자 인증 로직
        $auth_query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($auth_query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // 로그인 성공 시 쿠키에 사용자 정보 저장
                setcookie("user_id", $row['id'], time() + (86400 * 30), "/"); // 30 days
                setcookie("username", $row['username'], time() + (86400 * 30), "/");

                // 로그인 성공 시 index.php로 이동
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
    }

    // MySQL 연결 종료
    $conn->close();
    ?>

    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>

</body>
</html>
