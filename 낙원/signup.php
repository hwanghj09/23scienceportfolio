<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Get data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username is already taken
    $checkQuery = "SELECT * FROM users WHERE username='$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "Error: Username already taken.";
    } else {
        // Insert user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planet: Mango - 회원가입</title>
    <!-- Add your CSS styles or link to external stylesheet here -->
</head>

<body>
    <h2>회원가입</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">아이디:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">가입하기</button>
    </form>
</body>

</html>
