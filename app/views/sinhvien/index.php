<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        h2 {
            text-align: center;
            color: #1a73e8;
            margin-bottom: 25px;
            font-size: 28px;
        }
        
        /* Thông báo */
        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Button group */
        .btn-group {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-add {
            background: #28a745;
        }
        
        .btn-add:hover {
            background: #218838;
        }
        
        .btn-home {
            background: #1a73e8;
        }
        
        .btn-home:hover {
            background: #1557b0;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #333;
            padding: 5px 12px;
            font-size: 13px;
        }
        
        .btn-edit:hover {
            background: #e0a800;
        }
        
        .btn-delete {
            background: #dc3545;
            padding: 5px 12px;
            font-size: 13px;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        /* Bảng dữ liệu */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
            display: block;
        }
        
        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .data-table th {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        .data-table tr:hover {
            background: #f5f5f5;
            transition: background 0.2s ease;
        }
        
        .data-table td {
            color: #333;
        }
        
        .empty-row td {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .data-table th,
            .data-table td {
                padding: 8px 10px;
                font-size: 12px;
            }
            
            .btn {
                padding: 8px 15px;
                font-size: 12px;
            }
        }
        
        /* Thống kê */
        .stats {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            text-align: right;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 DANH SÁCH SINH VIÊN</h2>
        
        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                ✅ <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ❌ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <!-- Button group -->
        <div class="btn-group">
            <a href="<?php echo BASE_URL; ?>sinhvien/dangky" class="btn btn-add">
                ➕ Thêm sinh viên
            </a>
            <a href="<?php echo BASE_URL; ?>home/index" class="btn btn-home">
                🏠 Về trang chủ
            </a>
        </div>
        
        <!-- Bảng dữ liệu -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>MSSV</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Giới tính</th>
                    <th>Lớp</th>
                    <th>Ngày sinh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sinhvienList) && count($sinhvienList) > 0): ?>
                    <?php $stt = 1; ?>
                    <?php foreach ($sinhvienList as $sv): ?>
                        <tr>
                            <td><?php echo $stt++; ?> </td>
                            <td><?php echo htmlspecialchars($sv['mssv']); ?> </td>
                            <td><?php echo htmlspecialchars($sv['hoten']); ?> </td>
                            <td><?php echo htmlspecialchars($sv['email']); ?> </td>
                            <td>
                                <?php 
                                $genderBadge = '';
                                if ($sv['gioitinh'] == 'Nam') {
                                    $genderBadge = '👨 Nam';
                                } elseif ($sv['gioitinh'] == 'Nữ') {
                                    $genderBadge = '👩 Nữ';
                                } else {
                                    $genderBadge = '👤 Khác';
                                }
                                echo $genderBadge;
                                ?>
                             </td>
                            <td><?php echo htmlspecialchars($sv['lop']); ?> </td>
                            <td><?php echo date('d/m/Y', strtotime($sv['ngaysinh'])); ?> </td>
                            <td class="action-buttons">
                                <a href="<?php echo BASE_URL; ?>sinhvien/edit/<?php echo $sv['id']; ?>" class="btn btn-edit">✏️ Sửa</a>
                                <a href="<?php echo BASE_URL; ?>sinhvien/delete/<?php echo $sv['id']; ?>" 
                                   class="btn btn-delete"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên <?php echo htmlspecialchars($sv['hoten']); ?>?')">
                                    🗑️ Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="empty-row">
                        <td colspan="8">
                            📭 Chưa có dữ liệu sinh viên. 
                            <a href="<?php echo BASE_URL; ?>sinhvien/dangky" style="color: #1a73e8;">Thêm sinh viên mới</a>
                         </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Thống kê -->
        <div class="stats">
            📊 Tổng số sinh viên: <strong><?php echo count($sinhvienList ?? []); ?></strong>
        </div>
    </div>
</body>
</html>