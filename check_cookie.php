<?php
// 함수: 파일에서 내용 읽기
function readFromFile($filename) {
    $content = file_get_contents($filename);
    return $content !== false ? trim($content) : false;
}

// 함수: 암호화된 값을 쿠키로 설정
function setEncryptedCookie($name, $value, $expiry) {
    // 여기에서는 간단한 암호화를 사용하고 있습니다. 실제로는 보안에 더 신경을 써야 합니다.
    $encryptedValue = base64_encode($value);
    setcookie($name, $encryptedValue, $expiry, '/');
}

// 쿠키에서 "username" 값 가져오기
$usernameCookie = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';

// manager.txt 파일 경로
$managerFilePath = 'path/to/manager.txt'; // 실제 경로로 변경하세요

// manager.txt 파일 내용 읽기
$lines = file($managerFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// 쿠키의 "username" 값이 manager.txt 파일의 내용 중 어느 한 줄과 일치하는지 확인
$isValidUsername = false;
foreach ($lines as $line) {
    if (trim($line) === $usernameCookie) {
        $isValidUsername = true;
        break;
    }
}

// 쿠키의 "username" 값이 manager.txt 파일의 어느 한 줄과 일치할 경우
if ($isValidUsername) {
    // 쿠키로 암호화된 값 "manager"를 저장 (만료일은 1시간 후로 설정)
    $expiry = time() + 3600;
    setEncryptedCookie('manager', 'true', $expiry);
    echo "사용자명이 유효합니다!";
} else {
    // 쿠키의 "username" 값이 manager.txt 파일의 어느 한 줄과도 일치하지 않을 경우
    echo "사용자명이 유효하지 않습니다!";
}
?>
