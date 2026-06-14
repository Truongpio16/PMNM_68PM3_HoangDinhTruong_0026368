<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên - Card View</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px;
        }
        
        .container {
            max-width: 1400px;
            margin: auto;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 36px;
            color: white;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }
        
        .header p {
            color: rgba(255,255,255,0.9);
            margin-top: 10px;
        }
        
        /* Stats cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }
        
        .stat-card .label {
            color: #666;
            margin-top: 5px;
        }
        
        /* Button group */
        .btn-group {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        /* Card grid */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .student-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        
        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 20px;
            color: white;
            position: relative;
        }
        
        .card-header .mssv {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .card-header .name {
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-label {
            font-weight: 600;
            color: #666;
        }
        
        .info-value {
            color: #333;
        }
        
        .gender-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
        
        .gender-male {
            background: #d4f1f9;
            color: #007bff;
        }
        
        .gender-female {
            background: #fce4ec;
            color: #e91e63;
        }
        
        .card-footer {
            padding: 15px 20px;
            background: #f8f9fa;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .action-btn {
            padding: 6px 15px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .action-edit {
            background: #ffc107;
            color: #333;
        }
        
        .action-delete {
            background: #dc3545;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: 20px;
        }
        
        .empty-state .icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .page-link {
            padding: 10px 16px;
            background: white;
            border-radius: 10px;
            text-decoration: none;
            color: #667eea;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .page-link:hover, .page-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        /* Alert */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: slideDown 0.3s;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 Quản lý Sinh viên</h1>
            <p>Hệ thống quản lý sinh viên hiện đại</p>
        </div>
        
        <!-- Thông báo -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">✅ <?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">❌ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <!-- Thống kê -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="number"><?php echo $total ?? 0; ?></div>
                <div class="label">Tổng số sinh viên</div>
            </div>
            <div class="stat-card">
                <div class="number"><?php echo $totalPages ?? 1; ?></div>
                <div class="label">Tổng số trang</div>
            </div>
            <div class="stat-card">
                <div class="number"><?php echo $limit ?? 5; ?></div>
                <div class="label">Sinh viên/trang</div>
            </div>
        </div>
        
        <!-- Button group -->
        <div class="btn-group">
            <a href="<?php echo BASE_URL; ?>sinhvien/dangky" class="btn btn-success">➕ Thêm sinh viên</a>
            <a href="<?php echo BASE_URL; ?>home/index" class="btn btn-primary">🏠 Về trang chủ</a>
        </div>
        
        <!-- Card grid -->
        <?php if (!empty($sinhvienList)): ?>
            <div class="card-grid">
                <?php foreach ($sinhvienList as $sv): ?>
                    <div class="student-card">
                        <div class="card-header">
                            <div class="mssv">📝 <?php echo htmlspecialchars($sv['mssv']); ?></div>
                            <div class="name"><?php echo htmlspecialchars($sv['hoten']); ?></div>
                        </div>
                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">📧 Email</span>
                                <span class="info-value"><?php echo htmlspecialchars($sv['email']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">⚥ Giới tính</span>
                                <span class="info-value">
                                    <span class="gender-badge <?php echo $sv['gioitinh'] == 'Nam' ? 'gender-male' : 'gender-female'; ?>">
                                        <?php echo $sv['gioitinh'] == 'Nam' ? '👨 Nam' : ($sv['gioitinh'] == 'Nữ' ? '👩 Nữ' : '👤 Khác'); ?>
                                    </span>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">📚 Lớp</span>
                                <span class="info-value">
                                    <?php 
                                    // SỬA: Hiển thị tên lớp (tenlop) thay vì mã lớp
                                    if (!empty($sv['tenlop'])) {
                                        echo htmlspecialchars($sv['malop'] . ' - ' . $sv['tenlop']);
                                    } else {
                                        echo htmlspecialchars($sv['malop'] ?? 'Chưa có lớp');
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">🎂 Ngày sinh</span>
                                <span class="info-value"><?php echo date('d/m/Y', strtotime($sv['ngaysinh'])); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">📍 Địa chỉ</span>
                                <span class="info-value"><?php echo htmlspecialchars($sv['diachi']); ?></span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo BASE_URL; ?>sinhvien/edit/<?php echo $sv['id']; ?>" class="action-btn action-edit">✏️ Sửa</a>
                            <a href="<?php echo BASE_URL; ?>sinhvien/delete/<?php echo $sv['id']; ?>" 
                               class="action-btn action-delete"
                               onclick="return confirm('Xóa <?php echo htmlspecialchars($sv['hoten']); ?>?')">🗑️ Xóa</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="icon">📭</div>
                <h3>Chưa có dữ liệu sinh viên</h3>
                <p>Hãy thêm sinh viên đầu tiên!</p>
                <a href="<?php echo BASE_URL; ?>sinhvien/dangky" class="btn btn-success" style="margin-top: 20px;">➕ Thêm sinh viên</a>
            </div>
        <?php endif; ?>
        
        <!-- Pagination -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="<?php echo BASE_URL; ?>sinhvien/index?page=<?php echo $currentPage - 1; ?>" class="page-link">«</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="<?php echo BASE_URL; ?>sinhvien/index?page=<?php echo $i; ?>" 
                       class="page-link <?php echo $i == $currentPage ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($currentPage < $totalPages): ?>
                    <a href="<?php echo BASE_URL; ?>sinhvien/index?page=<?php echo $currentPage + 1; ?>" class="page-link">»</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>