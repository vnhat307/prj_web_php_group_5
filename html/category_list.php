<?php
session_start();
include '../includes/connect.php';
// kiểm tra quyền truy cập, chỉ Admin mới được phép vào trang này
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') { 
    header("Location: login.php");
    exit;
}
// Xử lý thêm mới danh mục
if (isset($_POST['add_cate'])) {
    $name = mysqli_real_escape_string($conn, $_POST['cate_name']);
    $check_id = mysqli_query($conn, "SELECT CATE_ID FROM category ORDER BY CATE_ID DESC LIMIT 1");
    $last_id = mysqli_fetch_assoc($check_id);
    $num = $last_id ? (int)substr($last_id['CATE_ID'], 1) + 1 : 1;
    $new_id = "C" . str_pad($num, 11, '0', STR_PAD_LEFT);
    
    mysqli_query($conn, "INSERT INTO category (CATE_ID, CATE_NAME, TRANGTHAI) VALUES ('$new_id', '$name', 1)");
    header("Location: category_list.php");
}
// Xử lý xóa danh mục
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM category WHERE CATE_ID = '$id'");
    header("Location: category_list.php");
}

$result = mysqli_query($conn, "SELECT * FROM category");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Danh mục</title>
    <link rel="stylesheet" href="../css/Admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>ADMIN PANEL</h2>
        <a href="Admin.php">Quản lý Tin tức</a>
        <a href="category_list.php" class="active">Quản lý Danh mục</a>
        <a href="account_list.php">Quản lý Tài khoản</a>
        <a href="Trang_chu.php">Trở về Trang chủ</a>
    </div>
    <div class="content">
        <h2>Quản lý Danh mục</h2>
        <form method="POST" class="mb-4" style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
            <input type="text" name="cate_name" placeholder="Tên danh mục mới" required style="padding: 10px; width: 250px;">
            <button type="submit" name="add_cate" class="btn btn-add">Thêm mới</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>MÃ DM</th>
                    <th>TÊN DANH MỤC</th>
                    <th>THAO TÁC</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['CATE_ID']; ?></td>
                    <td><?php echo $row['CATE_NAME']; ?></td>
                    <td>
                        <a href="category_list.php?delete_id=<?php echo $row['CATE_ID']; ?>" class="btn btn-delete" onclick="return confirm('Xóa danh mục sẽ ảnh hưởng đến các bài viết thuộc danh mục này!')">Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>