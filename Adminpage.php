<?php
// การเชื่อมต่อฐานข้อมูล
$servername = "127.0.0.1";
$username = "root";
$password = "v_8K6oo1tE-6UCXa";
$dbname = "IS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT id, member_names, project_title, main_content, pages, price, contact_info, created_at FROM is_projects";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Admin - รายการ IS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
        }
        h1 {
            text-align: center;
            padding: 20px;
            color: #004080;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #004080;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #004080;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0066cc;
        }
    </style>
</head>
<body>
    <h1>รายการ IS</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อสมาชิก</th>
                <th>ชื่อเรื่อง</th>
                <th>เนื้อหาหลัก</th>
                <th>จำนวนแผ่น</th>
                <th>ราคา</th>
                <th>ช่องทางติดต่อ</th>
                <th>วันที่สร้าง</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['member_names']) ?></td>
                        <td><?= htmlspecialchars($row['project_title']) ?></td>
                        <td><?= htmlspecialchars($row['main_content']) ?></td>
                        <td><?= $row['pages'] ?></td>
                        <td><?= number_format($row['price'], 2) ?></td>
                        <td><?= htmlspecialchars($row['contact_info']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">ไม่มีข้อมูลในฐานข้อมูล</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <button onclick="window.print()">พิมพ์รายชื่อ</button>
</body>
</html>

<?php
$conn->close();
?>