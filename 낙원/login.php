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
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #fff;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #bbb;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #555;
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>로그인</h2>
        <label for="username">아이디:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">로그인</button>
    </form>
</body>

</html>
