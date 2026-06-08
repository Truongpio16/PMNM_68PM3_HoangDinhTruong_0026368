<header style="background: #1a73e8; color: white; padding: 15px 0;">
    <div style="max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center;">
        <h1>📚 Quản lý Sinh viên</h1>
        <nav>
            <a href="<?php echo BASE_URL; ?>home/index" style="color: white; margin: 0 10px; text-decoration: none;">Trang chủ</a>
            <a href="<?php echo BASE_URL; ?>sinhvien/index" style="color: white; margin: 0 10px; text-decoration: none;">Danh sách</a>
            <a href="<?php echo BASE_URL; ?>sinhvien/create" style="color: white; margin: 0 10px; text-decoration: none;">Thêm mới</a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?php echo BASE_URL; ?>auth/logout" style="color: white; margin: 0 10px; text-decoration: none;">Đăng xuất (<?php echo $_SESSION['user']['name']; ?>)</a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>auth/login" style="color: white; margin: 0 10px; text-decoration: none;">Đăng nhập</a>
            <?php endif; ?>
        </nav>
    </div>
</header>