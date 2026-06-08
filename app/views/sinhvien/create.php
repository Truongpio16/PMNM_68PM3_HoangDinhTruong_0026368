<?php
$title = 'Thêm sinh viên mới';
?>

<h2>➕ THÊM SINH VIÊN MỚI</h2>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error" style="background: #fee; color: #c00; padding: 10px; margin-bottom: 20px;">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo BASE_URL; ?>sinhvien/store">
    <div class="form-group">
        <label>MSSV <span style="color:red;">*</span></label>
        <input type="text" name="mssv" required>
        <small>Bắt đầu bằng 0 và kết thúc bằng 68</small>
    </div>
    
    <div class="form-group">
        <label>Họ tên <span style="color:red;">*</span></label>
        <input type="text" name="hoten" required>
    </div>
    
    <div class="form-group">
        <label>Email <span style="color:red;">*</span></label>
        <input type="email" name="email" required>
        <small>Phải có đuôi @st.huce.edu.vn</small>
    </div>
    
    <div class="form-group">
        <label>Giới tính</label>
        <select name="gioitinh">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
            <option value="Khác">Khác</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Địa chỉ</label>
        <textarea name="diachi" rows="3"></textarea>
    </div>
    
    <div class="form-group">
        <label>Ngày sinh</label>
        <input type="date" name="ngaysinh">
    </div>
    
    <div class="form-group">
        <label>Lớp</label>
        <input type="text" name="lop">
    </div>
    
    <button type="submit">💾 Lưu sinh viên</button>
    <a href="<?php echo BASE_URL; ?>sinhvien/index" class="btn-cancel">❌ Hủy bỏ</a>
</form>

<style>
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; font-weight: bold; }
    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
    button { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    .btn-cancel { background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-left: 10px; }
    small { color: #666; font-size: 12px; }
</style>