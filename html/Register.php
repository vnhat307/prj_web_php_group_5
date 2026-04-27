<?php
include '../includes/connect.php';

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';

    if (!preg_match($password_pattern, $password)) {
        $error = "Mật khẩu phải ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số!";
    } elseif ($password !== $repassword) {
        $error = "Mật khẩu nhập lại không khớp!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $acc_id = 'A' . rand(10000, 99999);
        $user_id = 'U' . rand(10000, 99999);
        $role = 'User';

        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

        $sql_user = "INSERT INTO userr (USER_ID, ACC_ID, USER_NAME, FULL_NAME, GIOITINH) 
                     VALUES ('$user_id', '$acc_id', '$username', '$fullname', 1)";
        
        $sql_acc = "INSERT INTO account (ACC_ID, USER_ID, ACC_NAME, PASSWORD, ROLE) 
                    VALUES ('$acc_id', '$user_id', '$username', '$hashed_password', '$role')";

        if (mysqli_query($conn, $sql_user) && mysqli_query($conn, $sql_acc)) {
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
            header("Location: login.php?msg=success");
            exit;
        } else {
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
            $error = "Lỗi hệ thống: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Báo Mới</title>
    <link rel="stylesheet" href="../css/auth.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .password-wrapper { position: relative; }
        .toggle-password { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #666; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h2>TẠO TÀI KHOẢN</h2>
            <p>Mật khẩu cần ít nhất 8 ký tự (A-z và 0-9)</p>
        </div>
        <?php if(isset($error)) echo "<div class='alert-error'>$error</div>"; ?>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="fullname" required>
            </div>
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Ví dụ: Abc12345" required>
                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass('password', this)"></i>
                </div>
            </div>
            <div class="form-group">
                <label>Nhập lại mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" name="repassword" id="repassword" required>
                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass('repassword', this)"></i>
                </div>
            </div>
            <button type="submit" name="register" class="btn-auth">ĐĂNG KÝ MỚI</button>
        </form>
        <div class="auth-footer">
            Đã có tài khoản? <a href="login.php">Đăng nhập</a>
        </div>
    </div>

    <script>
        function togglePass(id, el) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                el.classList.remove('bi-eye-slash');
                el.classList.add('bi-eye');
            } else {
                input.type = "password";
                el.classList.remove('bi-eye');
                el.classList.add('bi-eye-slash');
            }
        }
    </script>
</body>
</html>