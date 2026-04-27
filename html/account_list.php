<?php
session_start();
include '../includes/connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // BƯỚC 1: Tắt kiểm tra khóa ngoại (Chiêu cuối)
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
    
    // BƯỚC 2: Xóa sạch ở tất cả các bảng liên quan
    mysqli_query($conn, "DELETE FROM userr WHERE ACC_ID = '$id'");
    mysqli_query($conn, "DELETE FROM author WHERE ACC_ID = '$id'");
    mysqli_query($conn, "DELETE FROM account WHERE ACC_ID = '$id'");
    
    // BƯỚC 3: Bật lại kiểm tra khóa ngoại để bảo vệ hệ thống
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
    
    header("Location: account_list.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM account ORDER BY ROLE DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Tài khoản</title>
    <link rel="stylesheet" href="../css/Admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>ADMIN PANEL</h2>
        <a href="Admin.php">Quản lý Tin tức</a>
        <a href="category_list.php">Quản lý Danh mục</a>
        <a href="account_list.php" class="active">Quản lý Tài khoản</a>
        <a href="Trang_chu.php">Trở về Trang chủ</a>
    </div>
    <div class="content">
        <h2>Danh sách Tài khoản</h2>
        <table>
            <thead>
                <tr>
                    <th>MÃ TK</th>
                    <th>TÊN ĐĂNG NHẬP</th>
                    <th>HỌ TÊN</th>
                    <th>QUYỀN</th>
                    <th>THAO TÁC</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['ACC_ID']; ?></td>
                    <td><?php echo $row['ACC_NAME']; ?></td>
                    <td><?php echo $row['FULL_NAME']; ?></td>
                    <td><strong><?php echo $row['ROLE']; ?></strong></td>
                    <td>
                        <a href="account_list.php?delete_id=<?php echo $row['ACC_ID']; ?>" class="btn btn-delete" onclick="return confirm('Xác nhận xóa tài khoản này?')">Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>