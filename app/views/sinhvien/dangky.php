<!-- Trong form, thay trường Lớp cũ bằng dropdown chọn malop -->
<div class="form-group">
    <label>Lớp</label>
    <select name="malop" class="form-control">
        <option value="">-- Chọn lớp --</option>
        <?php foreach ($lophocList as $lh): ?>
            <option value="<?php echo $lh['malop']; ?>" 
                <?php echo (isset($data['malop']) && $data['malop'] == $lh['malop']) ? 'selected' : ''; ?>>
                <?php echo $lh['malop'] . ' - ' . $lh['tenlop']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>