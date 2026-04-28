<?php
session_start();
include '../includes/connect.php';

// kiem tra quyen admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

// xu ly hanh dong, duyet, go, xoa
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE news SET TRANGTHAI = 1 WHERE NEWS_ID = '$id'");
    } elseif ($action == 'hide') {
        mysqli_query($conn, "UPDATE news SET TRANGTHAI = 0 WHERE NEWS_ID = '$id'");
    } elseif ($action == 'delete') {
        // gỡ rang buoc Fk trc khi xoa
        mysqli_query($conn, "DELETE FROM comment WHERE NEWS_ID = '$id'");
        mysqli_query($conn, "DELETE FROM news_image WHERE NEWS_ID = '$id'");
        mysqli_query($conn, "DELETE FROM trending WHERE NEWS_ID = '$id'"); 
        
        $sql = "DELETE FROM news WHERE NEWS_ID = '$id'";
        mysqli_query($conn, $sql);
    }
    header("Location: Admin.php");
    exit;
}

$sql = "SELECT n.*, c.CATE_NAME FROM news n LEFT JOIN category c ON n.CATE_ID = c.CATE_ID ORDER BY n.NEWS_ID DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Danh sách Tin tức</title>
    <link rel="stylesheet" href="../css/Admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>ADMIN PANEL</h2>
        <a href="Admin.php" class="active">Quản lý Tin tức</a>
        <a href="category_list.php">Quản lý Danh mục</a>
        <a href="account_list.php">Quản lý Tài khoản</a>
        <a href="Trang_chu.php">Trở về Trang chủ</a>
    </div>
    
    <div class="content">
        <h2>Danh sách Tin tức</h2>
        <div class="mb-4">
            <a href="Admin_them_tin.php" class="btn btn-add">+ Thêm tin mới</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>MÃ TIN</th>
                    <th>TIÊU ĐỀ</th>
                    <th>CHUYÊN MỤC</th>
                    <th>NGÀY ĐĂNG</th>
                    <th>TRẠNG THÁI</th>
                    <th>HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><strong><?php echo $row['NEWS_ID']; ?></strong></td>
                    <td><?php echo $row['NEWS_NAME']; ?></td>
                    <td><?php echo $row['CATE_NAME'] ? $row['CATE_NAME'] : 'Chưa phân loại'; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['NGAYDANG'])); ?></td>
                    <td>
                        <?php if($row['TRANGTHAI'] == 1): ?>
                            <span style="color: #27ae60; font-weight: bold;">Đã duyệt</span>
                        <?php else: ?>
                            <span style="color: #e74c3c; font-weight: bold;">Chờ duyệt</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <?php if($row['TRANGTHAI'] == 0): ?>
                                <a href="Admin.php?action=approve&id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-add" style="padding: 5px 10px; font-size: 12px;">Duyệt</a>
                            <?php else: ?>
                                <a href="Admin.php?action=hide&id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-edit" style="padding: 5px 10px; font-size: 12px; background: #f39c12; color: #fff;">Gỡ</a>
                            <?php endif; ?>

                            <a href="Admin_sua_tin.php?id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-edit" style="padding: 5px 10px; font-size: 12px;">Sửa</a>
                            
                            <a href="Admin.php?action=delete&id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-delete" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Xác nhận xóa vĩnh viễn tin này?')">Xóa</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>