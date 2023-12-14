<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background-color: #45a049;
        }
        
    </style>
    <title>퀴즈 랭킹</title>
</head>
<body>

<?php
$dbHost = 'svc.sel4.cloudtype.app:32632';
$dbUser = 'root';
$dbPassword = 'qwaszx77^^';
$dbName = 'quiz';

// Create a database connection
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch top 10 user scores from the database
$sql = "SELECT username, score, RANK() OVER (ORDER BY score DESC) AS ranking FROM users ORDER BY score DESC LIMIT 10";
$result = $conn->query($sql);

// Display the ranking
if ($result->num_rows > 0) {
    echo "<h2>퀴즈 랭킹</h2>";
    echo "<table><tr><th>순위</th><th>사용자</th><th>점수</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["ranking"] . "</td><td>" . $row["username"] . "</td><td>" . $row["score"] . "</td></tr>";
    }

    echo "</table>";
} else {
    echo "<p style='text-align: center;'>랭킹 정보를 가져오지 못했습니다.</p>";
}

// Close the database connection
$conn->close();
?>
<center><form method="post" action="index.php">
    <button type="submit">돌아가기</button>
</form></center>
</body>
</html>
