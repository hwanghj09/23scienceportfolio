<?php
// 데이터베이스 연결 정보 설정
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

// 가져온 데이터를 출력
if ($resultAllUsers->num_rows > 0) {
    echo '<h2>User Information</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Username</th><th>Admin</th></tr>';

    while ($rowUser = $resultAllUsers->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $rowUser['id'] . '</td>';
        echo '<td>' . $rowUser['username'] . '</td>';
        echo '<td>' . $rowUser['admin'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No users found';
}

$conn->close();
?>
