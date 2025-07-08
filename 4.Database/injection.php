<?php
$host = "localhost";
$user = "root";
$pass = "qwer1234";
$dbname = "sql_injection_lab";

// 데이터베이스 연결
$conn = new mysqli($host, $user, $pass, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// 사용자가 입력한 로그인 정보 받기
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // SQL Injection에 취약한 쿼리
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<h3>Welcome!, " . htmlspecialchars($username) . "님!</h3>";
    } else {
        echo "<h3>Login Failed: Please check Username and password</h3>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>SQL Injection Practice - Login</title>
</head>
<body>
    <h2>Login Page</h2>
    <form method="POST">
        <label>User Name:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>

