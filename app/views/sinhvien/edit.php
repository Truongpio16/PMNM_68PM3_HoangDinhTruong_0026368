<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sinh viên</title>
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
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        h2 {
            text-align: center;
            color: #ffc107;
            margin-bottom: 25px;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #ffc107;
            box-shadow: 0 0 0 3px rgba(255,193,7,0.1);
        }
        
        textarea {
            resize: vertical;
        }
        
        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        
        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-update {
            background: #ffc107;
            color: #333;
        }
        
        .btn-update:hover {
            background: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-cancel {
            background: #6c757d;
            color: white;
        }
        
        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .required {
            color: #dc3545;
        }
        
        small {
            color: #666;
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>✏️ SỬA SINH VIÊN</h2>
        
        <form method="POST" action="<?php echo BASE_URL; ?>sinhvien/update/<?php echo $sinhvien['id']; ?>">
            <div class="form-group">
                <label>MSSV <span class="required">*</span></label>
                <input type="text" name="mssv" value="<?php echo htmlspecialchars($sinhvien['mssv']); ?>" required>
                <small>MSSV phải bắt đầu bằng 0 và kết thúc bằng 68</small>
            </div>
            
            <div class="form-group">
                <label>Họ tên <span class="required">*</span></label>
                <input type="text" name="hoten" value="<?php echo htmlspecialchars($sinhvien['hoten']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($sinhvien['email']); ?>" required>
                <small>Email phải có đuôi @st.huce.edu.vn</small>
            </div>
            
            <div class="form-group">
                <label>Giới tính</label>
                <select name="gioitinh">
                    <option value="Nam" <?php echo $sinhvien['gioitinh'] == 'Nam' ? 'selected' : ''; ?>>👨 Nam</option>
                    <option value="Nữ" <?php echo $sinhvien['gioitinh'] == 'Nữ' ? 'selected' : ''; ?>>👩 Nữ</option>
                    <option value="Khác" <?php echo $sinhvien['gioitinh'] == 'Khác' ? 'selected' : ''; ?>>👤 Khác</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Địa chỉ</label>
                <textarea name="diachi" rows="3"><?php echo htmlspecialchars($sinhvien['diachi']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Ngày sinh</label>
                <input type="date" name="ngaysinh" value="<?php echo $sinhvien['ngaysinh']; ?>">
            </div>
            
            <div class="form-group">
                <label>Lớp</label>
                <input type="text" name="lop" value="<?php echo htmlspecialchars($sinhvien['lop']); ?>">
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-update">💾 LƯU CẬP NHẬT</button>
                <a href="<?php echo BASE_URL; ?>sinhvien/index" class="btn btn-cancel">❌ HỦY BỎ</a>
            </div>
        </form>
    </div>
</body>
</html>