<?php
$host = "localhost";
$user = "root";
$pass = "qwer1234";
$dbname = "sql_injection_lab";

// 데이터베이스 연결
$conn = new mysqli($host, $user, $pass, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

// 사용자가 입력한 로그인 정보 받기
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // SQL Injection에 취약한 쿼리
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<h3>로그인 성공! 환영합니다, " . htmlspecialchars($username) . "님!</h3>";
    } else {
        echo "<h3>로그인 실패: 잘못된 사용자명 또는 비밀번호</h3>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>SQL Injection 실습 - 로그인</title>
</head>

<body>
    <h2>로그인 페이지</h2>
    <form method="POST">
        <label>사용자명:</label>
        <input type="text" name="username" required><br>
        <label>비밀번호:</label>
        <input type="password" name="password" required><br>
        <button type="submit">로그인</button>
    </form>
</body>

</html>