<?php
session_start();
include '../includes/connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM author WHERE AUTHOR_ID = '$id'");
    header("Location: author_list.php");
    exit;
}

$sql = "SELECT * FROM author ORDER BY AUTHOR_ID DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Tác giả</title>
    <link rel="stylesheet" href="../css/Admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>BÁO MỚI</h2>
        <a href="admin.php">Dashboard</a>
        <a href="author_list.php" class="active">Tác giả</a>
        <a href="news_list.php">Tin tức</a>
        <a href="logout.php">Đăng xuất</a>
    </div>
    
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="margin: 0;">Danh sách Tác giả</h2>
            <a href="author_add_edit.php" class="btn btn-add" style="margin-bottom: 0;">Thêm Tác giả</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Mã TG</th>
                    <th>Mã TK (ACC_ID)</th>
                    <th>Tên tác giả</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><strong><?php echo $row['AUTHOR_ID']; ?></strong></td>
                    <td><span style="color: #2980b9; font-weight: bold;"><?php echo $row['ACC_ID']; ?></span></td>
                    <td><?php echo $row['AUTHOR_NAME']; ?></td>
                    <td><?php echo $row['FULL_NAME']; ?></td>
                    <td><?php echo $row['PHONE']; ?></td>
                    <td>
                        <a href="author_add_edit.php?id=<?php echo $row['AUTHOR_ID']; ?>" class="btn btn-edit">Sửa</a>
                        <a href="author_list.php?delete_id=<?php echo $row['AUTHOR_ID']; ?>" class="btn btn-delete" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>