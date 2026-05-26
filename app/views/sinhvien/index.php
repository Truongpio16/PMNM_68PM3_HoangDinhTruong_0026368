<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px; }
        .container { max-width: 1200px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        h2 { text-align: center; color: #1a73e8; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1a73e8; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn { display: inline-block; padding: 10px 20px; background: #1a73e8; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        .btn-add { background: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 DANH SÁCH SINH VIÊN</h2>
        
        <a href="<?php echo BASE_URL; ?>sinhviencontroller/dangky" class="btn btn-add">➕ Thêm sinh viên</a>
        <a href="<?php echo BASE_URL; ?>homecontroller/index" class="btn">🏠 Về trang chủ</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>MSSV</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Giới tính</th>
                    <th>Lớp</th>
                    <th>Ngày sinh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sinhvienList)): ?>
                    <?php foreach ($sinhvienList as $sv): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sv['id']); ?></td>
                        <td><?php echo htmlspecialchars($sv['mssv']); ?></td>
                        <td><?php echo htmlspecialchars($sv['hoten']); ?></td>
                        <td><?php echo htmlspecialchars($sv['email']); ?></td>
                        <td><?php echo htmlspecialchars($sv['gioitinh']); ?></td>
                        <td><?php echo htmlspecialchars($sv['lop']); ?></td>
                        <td><?php echo htmlspecialchars($sv['ngaysinh']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Chưa có dữ liệu sinh viên</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>