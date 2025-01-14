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

// ตรวจสอบว่ามีข้อมูลส่งมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม (ตรวจสอบว่าแต่ละค่ามีการส่งมาหรือไม่)
    $member_names = isset($_POST['member_names']) ? $conn->real_escape_string($_POST['member_names']) : '';
    $project_title = isset($_POST['project_title']) ? $conn->real_escape_string($_POST['project_title']) : '';
    $main_content = isset($_POST['main_content']) ? $conn->real_escape_string($_POST['main_content']) : '';
    $pages = isset($_POST['pages']) && is_numeric($_POST['pages']) ? intval($_POST['pages']) : 0;
    $contact_info = isset($_POST['contact_info']) ? $conn->real_escape_string($_POST['contact_info']) : '';

    // ตรวจสอบว่าค่าที่จำเป็นทั้งหมดมีข้อมูลครบถ้วน
    if (empty($member_names) || empty($project_title) || empty($main_content) || empty($contact_info) || $pages <= 0) {
        die("กรุณากรอกข้อมูลให้ครบถ้วน");
    }

    // คำนวณราคา
    $price = $pages * 10;

    // บันทึกข้อมูลลงฐานข้อมูล
    $sql = "INSERT INTO is_projects (member_names, project_title, main_content, pages, price, contact_info) 
            VALUES ('$member_names', '$project_title', '$main_content', $pages, $price, '$contact_info')";

    if ($conn->query($sql) === TRUE) {
        echo "บันทึกข้อมูลเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- เพิ่มลิงก์ไปยัง Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>IS Form</title>
    <style>
        /* ตั้งค่าพื้นฐาน */
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #eaf6ff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #007BFF;
            margin: 20px 0;
            font-size: 2rem;
        }

        form {
            background: #ffffff;
            max-width: 500px;
            margin: 20px auto;
            padding: 30px 20px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.2);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* เอฟเฟกต์เมื่อคลิก */
        button:active {
            transform: scale(0.98);
        }

        /* เงาสำหรับหน้า */
        body::before {
            content: '';
            display: block;
            height: 20px;
        }
    </style>
</head>
<body>
    <h1> IS</h1>
    <form action="index.php" method="POST">
        <label>ชื่อสมาชิก (แยกด้วยเครื่องหมายคอมมา):</label>
        <textarea name="member_names" rows="2" required></textarea>

        <label>ชื่อเรื่อง:</label>
        <input type="text" name="project_title" required>

        <label>เนื้อหาหลัก:</label>
        <textarea name="main_content" rows="4" required></textarea>

        <label>จำนวนแผ่น:</label>
        <label>เรท:1แผ่น 10 บาท</label>
        <input type="number" name="pages" min="1" required>

        <label>ช่องทางติดต่อ (เช่น IG):</label>
        <input type="text" name="contact_info" placeholder="กรุณากรอกข้อมูลการติดต่อ" required>

        <button type="submit">บันทึก</button>
        <label>*ปล.คลิปไปอัดกันเอาเอง*</label>
        <label>*จ่ายตอนรับงาน*</label>
    </form>
</body>
</html>