<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "svc.sel4.cloudtype.app:31934"; // replace with your actual database host
    $username = "root";
    $password = "nagwon";
    $dbname = "announcements_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the form
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Insert announcement into the database
    $sql = "INSERT INTO announcements (title, content) VALUES ('$title', '$content')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to index.html after successful submission
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Planet: Mango - 공지 작성</title>
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

        .form-container {
            max-width: 600px;
            margin: 20px;
            padding: 20px;
            background-color: #555;
            border-radius: 10px;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.html">
                <h1>엄청난!</h1>
            </a>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>공지 작성</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="title">제목:</label>
                <input type="text" id="title" name="title" required>

                <label for="content">내용:</label>
                <textarea id="content" name="content" rows="4" required></textarea>

                <button type="submit">작성 완료</button>
            </form>
        </div>
    </div>
</body>

</html>
