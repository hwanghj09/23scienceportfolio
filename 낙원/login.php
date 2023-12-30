<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

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
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Check if the username exists
    $checkQuery = "SELECT * FROM users WHERE username='$inputUsername'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Verify the password
        $row = $checkResult->fetch_assoc();
        $hashedPassword = $row['password'];
        $isAdmin = $row['admin'];

        if (password_verify($inputPassword, $hashedPassword)) {
            // Password is correct, start a session

            // Store data in session variables
            $_SESSION['username'] = $inputUsername;

            // Check if the user is an admin and store the info in the session
            if ($isAdmin) {
                $_SESSION['isAdmin'] = 1;
            }

            // Redirect to the main page or any other secured page
            header("Location: index.php");
            exit();
        } else {
            echo "Error: Incorrect password.";
        }
    } else {
        echo "Error: User not found.";
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
    <title>Planet: Mango - 로그인</title>
    <!-- Add your CSS styles or link to an external stylesheet here -->
</head>

<body>
    <h2>로그인</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">아이디:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">로그인</button>
    </form>
</body>

</html>
