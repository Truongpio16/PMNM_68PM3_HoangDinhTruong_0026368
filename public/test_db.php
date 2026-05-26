<?php
// public/test_db.php

require_once '../app/core/Database.php';

$db = new Database();

// Kiểm tra kết nối
echo "<h2>Kiểm tra kết nối Database</h2>";

// Lấy danh sách sinh viên
$result = $db->fetchAll("SELECT * FROM sinhvien");

echo "<h3>Danh sách sinh viên:</h3>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>MSSV</th><th>Họ tên</th><th>Email</th><th>Giới tính</th><th>Lớp</th></tr>";

foreach ($result as $row) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['mssv'] . "</td>";
    echo "<td>" . $row['hoten'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['gioitinh'] . "</td>";
    echo "<td>" . $row['lop'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>