<?php
session_start();
// lấy mã băm nhanh
// if (isset($_POST['password'])) {
//     echo "Mật khẩu thô: " . $_POST['password'] . "<br>";
//     echo "Mã băm tương ứng: " . password_hash($_POST['password'], PASSWORD_DEFAULT);
//     exit; 
// }
include '../includes/connect.php';

if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
    $success = "Đăng ký thành công! Vui lòng đăng nhập.";
}

if (isset($_POST['login'])) {
    // lam sach data input 
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];

    $sql = "SELECT * FROM account WHERE ACC_NAME = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // --- ĐOẠN KIỂM TRA LỖI (CHỈ ĐỂ TEST) ---
            // echo "Mật khẩu ông gõ: " . $password . "<br>";
            // echo "Mã băm trong DB: " . $row['PASSWORD'] . "<br>";
            // echo "Độ dài mã băm: " . strlen($row['PASSWORD']) . "<br>";
            // if (password_verify($password, $row['PASSWORD'])) { echo "KẾT QUẢ: KHỚP!"; } else { echo "KẾT QUẢ: KHÔNG KHỚP!"; }
            // exit; 
// --------------------------------------
        // kiem tra mat khau da bam(hash)
        if (password_verify($password, $row['PASSWORD'])) {
            
            // change ID moi, bao mat phien lam viec 
            session_regenerate_id(true);

            $_SESSION['acc_id'] = $row['ACC_ID'];
            $_SESSION['user_id'] = $row['USER_ID'];
            $_SESSION['username'] = $row['ACC_NAME'];
            $_SESSION['role'] = $row['ROLE'];

            if ($row['ROLE'] == 'Admin') {
                header("Location: admin.php");
            } else {
                header("Location: Trang_chu.php");
            }
            exit;
        } else {
            $error = "Sai mật khẩu!";
        }
    } else {
        $error = "Tài khoản không tồn tại!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Báo Mới</title>
    <link rel="stylesheet" href="../css/auth.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .password-wrapper { position: relative; }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
        /* Style cho thong bao loi/thanh cong */
        .alert-error { color: #d9534f; background: #f2dede; padding: 10px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ebccd1; }
        .alert-success { color: #3c763d; background: #dff0d8; padding: 10px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #d6e9c6; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h2>ĐĂNG NHẬP</h2>
            <p>Chào mừng bạn quay trở lại Báo Mới</p>
        </div>

        <?php if(isset($error)) echo "<div class='alert-error'>$error</div>"; ?>
        <?php if(isset($success)) echo "<div class='alert-success'>$success</div>"; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" placeholder="Nhập tài khoản của bạn" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" required>
                    <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                </div>
            </div>
            <button type="submit" name="login" class="btn-auth">ĐĂNG NHẬP</button>
        </form>

        <div class="auth-footer">
            Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Thay doi thuoc tinh type cua input (DOM)
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Thay doi icon con mắt
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>