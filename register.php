<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
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
</head>
<body>

    <h2>User Registration</h2>

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

        // 중복 아이디 체크
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            echo "이미 사용 중인 아이디입니다.";
        } else {
            // 아이디가 중복되지 않으면 회원가입 정보를 데이터베이스에 저장
            $hash_password = password_hash($password, PASSWORD_DEFAULT); // 비밀번호를 해싱
            $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hash_password')";
            
            if ($conn->query($insert_query) === TRUE) {
                echo "회원가입이 성공적으로 완료되었습니다.";
                
                // 회원가입 성공 시 index.php로 이동
                header("Location: login.php");
                exit(); // 페이지 이동 후에는 종료 필요
            } else {
                echo "Error: " . $insert_query . "<br>" . $conn->error;
            }
        }
    }

    // MySQL 연결 종료
    $conn->close();
    ?>

    <form action="" method="post">
        <label for="username">Id:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>

</body>
</html>
