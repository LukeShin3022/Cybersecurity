<?php
session_start();
$servername = "localhost"; // MySQL 서버 주소 (컨테이너 내부에서 접근 시 `db` 가능)
$username = "root"; // MySQL 계정
$password = "qwer1234"; // MySQL 비밀번호 (기본값이 없을 수도 있음)
$database = "onestar"; // 사용할 데이터베이스 이름
// MySQL 연결
$conn = new mysqli($servername, $username, $password, $database);
// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'insert') {
            $name = $_POST['name'];
            $age = $_POST['age'];
            $class = $_POST['class'];
            $grade = $_POST['grade'];

            $stmt = $conn->prepare("INSERT INTO students (name, age, class, grade) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sisd", $name, $age, $class, $grade);

            if ($stmt->execute()) {
                $message = "✅ 학생 등록 완료!";
            } else {
                $message = "❌ 등록 실패: " . $stmt->error;
            }
            $stmt->close();

        } elseif ($_POST['action'] === 'delete') {
            $id = $_POST['id'];

            $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $message = "🗑️ 학생 ID {$id} 삭제 완료!";
            } else {
                $message = "❌ 삭제 실패: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    // ✅ 단 한 번의 리디렉션
    header("Location: http://3.35.236.128:8000/table.php");
    exit;
}

?>
<?php
$sql = "SELECT id, name, age, class, grade FROM students";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }

        th,
        td {
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
            <th>Age</th>
            <th>Class</th>
            <th>Grade</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['class']}</td>
                        <td>{$row['grade']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No students found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <div>
        <h2>🎓 학생 등록</h2>
        <form method="post" action="">
            <input type="hidden" name="action" value="insert">
            이름: <input type="text" name="name" required><br><br>
            나이: <input type="number" name="age" required><br><br>
            반: <input type="text" name="class" required><br><br>
            성적: <input type="number" step="0.01" name="grade" required><br><br>
            <input type="submit" value="등록">
        </form>

        <hr>

        <h2>🗑️ 학생 삭제</h2>
        <form method="post" action="">
            <input type="hidden" name="action" value="delete">
            삭제할 학생 ID: <input type="number" name="id" required><br><br>
            <input type="submit" value="삭제">
        </form>      

    </div>

</body>

</html>