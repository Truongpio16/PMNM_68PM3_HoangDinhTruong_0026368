<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa lớp học</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 15px; }
        h2 { color: #ffc107; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #ffc107; color: #333; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .btn-cancel { background: #6c757d; text-decoration: none; color: white; padding: 10px 20px; border-radius: 5px; display: inline-block; }
        .btn-group { margin-top: 20px; display: flex; gap: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>✏️ SỬA LỚP HỌC</h2>
        <form method="POST" action="<?php echo BASE_URL; ?>lophoc/update/<?php echo $lophoc['id']; ?>">
            <div class="form-group">
                <label>Mã lớp *</label>
                <input type="text" name="malop" value="<?php echo htmlspecialchars($lophoc['malop']); ?>" required>
            </div>
            <div class="form-group">
                <label>Tên lớp *</label>
                <input type="text" name="tenlop" value="<?php echo htmlspecialchars($lophoc['tenlop']); ?>" required>
            </div>
            <div class="form-group">
                <label>Khóa học</label>
                <input type="text" name="khoahoc" value="<?php echo htmlspecialchars($lophoc['khoahoc']); ?>">
            </div>
            <div class="form-group">
                <label>Sĩ số</label>
                <input type="number" name="siso" value="<?php echo $lophoc['siso']; ?>">
            </div>
            <div class="btn-group">
                <button type="submit">💾 Cập nhật</button>
                <a href="<?php echo BASE_URL; ?>lophoc/index" class="btn-cancel">❌ Hủy</a>
            </div>
        </form>
    </div>
</body>
</html>
