<?php
$servername = "localhost"; // MySQL 서버 주소 (컨테이너 내부에서 접근 시 `db` 가능)
$username = "root"; // MySQL 계정
$password = "qwer1234"; // MySQL 비밀번호 (기본값이 없을 수도 있음)
$database = "CompanyDB2"; // 사용할 데이터베이스 이름

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $database);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL 실행
$sql = "SELECT id, name, department, job_title, salary, hire_date FROM employee";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Students List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Title</th>
            <th>Salary</th>
            <th>Hire_date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['job_title']}</td>
                    <td>{$row['salary']}</td>
                    <td>{$row['hire_date']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No students found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
