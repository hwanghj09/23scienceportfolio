<?php
error_reporting( E_ALL );
ini_set( "display_errors", 1 );
$servername = "svc.sel4.cloudtype.app:32632";
$username = "root";
$password = "qwaszx77^^";
$dbname = "ip";

// 사용자가 입력한 데이터 받아오기
if(isset($_POST['login']) && isset($_POST['password'])){
    $username = $_POST['login'];    
    $password = $_POST['password'];

    // 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 사용자 정보 데이터베이스에 저장 (비밀번호는 암호화하지 않고 저장)
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "User successfully registered!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 연결 닫기
    $conn->close();
} else {
    echo "Username or password not provided.";
}
?>
