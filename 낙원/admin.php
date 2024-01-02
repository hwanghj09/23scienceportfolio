<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbHost = 'svc.sel4.cloudtype.app:32632';
$dbUser = 'root';
$dbPassword = 'qwaszx77^^';
$dbName = 'quiz';

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// users 테이블의 모든 데이터를 가져오는 쿼리
$sqlAllUsers = "SELECT * FROM users";
$resultAllUsers = $conn->query($sqlAllUsers);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
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

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .user-table {
            width: 80%;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #555;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #555;
        }

        tr:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <header>
        <h1>관리자 페이지</h1>
    </header>
    <div class="container">
        <button onclick="toggleUserTable()">Toggle User Table</button>
        <div class="user-table" id="userTable" style="display: none;">
            <h2>User Information</h2>
            <table> 
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Admin</th>
                </tr>
                <?php
                if ($resultAllUsers->num_rows > 0) {
                    while ($rowUser = $resultAllUsers->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $rowUser['id'] . '</td>';
                        echo '<td>' . $rowUser['username'] . '</td>';
                        echo '<td>' . $rowUser['password'] . '</td>';
                        echo '<td>' . $rowUser['admin'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No users found</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        function toggleUserTable() {
            var userTable = document.getElementById('userTable');
            userTable.style.display = (userTable.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>

</html>