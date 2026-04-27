<?php
session_start();
include '../includes/connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE news SET TRANGTHAI = 1 WHERE NEWS_ID = '$id'");
    } elseif ($action == 'hide') {
        mysqli_query($conn, "UPDATE news SET TRANGTHAI = 0 WHERE NEWS_ID = '$id'");
    } elseif ($action == 'delete') {
        mysqli_query($conn, "DELETE FROM news WHERE NEWS_ID = '$id'");
    }
    header("Location: news_list.php");
    exit;
}

$sql = "SELECT n.*, a.AUTHOR_NAME FROM news n LEFT JOIN author a ON n.AUTHOR_ID = a.AUTHOR_ID ORDER BY n.NEWS_ID DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Duyệt Tin Tức - Admin</title>
    <link rel="stylesheet" href="../css/Admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>BÁO MỚI</h2>
        <a href="admin.php">Dashboard</a>
        <a href="author_list.php">Tác giả</a>
        <a href="news_list.php" class="active">Tin tức</a>
        <a href="logout.php">Đăng xuất</a>
    </div>
    
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="margin: 0;">Quản lý & Duyệt Tin Tức</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Mã Tin</th>
                    <th>Tên tin</th>
                    <th>Tác giả</th>
                    <th>Ngày đăng</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><strong><?php echo $row['NEWS_ID']; ?></strong></td>
                    <td><?php echo $row['NEWS_NAME']; ?></td>
                    <td><span style="color: #2980b9; font-weight: bold;"><?php echo $row['AUTHOR_NAME'] ? $row['AUTHOR_NAME'] : 'Không rõ'; ?></span></td>
                    <td><?php echo $row['NGAYDANG']; ?></td>
                    <td>
                        <?php if($row['TRANGTHAI'] == 1): ?>
                            <span style="color: #27ae60; font-weight: bold;">Đã xuất bản</span>
                        <?php else: ?>
                            <span style="color: #e74c3c; font-weight: bold;">Chờ duyệt</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row['TRANGTHAI'] == 0): ?>
                            <a href="news_list.php?action=approve&id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-add" style="margin: 0; padding: 6px 12px; font-size: 13px;">Duyệt bài</a>
                        <?php else: ?>
                            <a href="news_list.php?action=hide&id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-edit" style="margin: 0; padding: 6px 12px; font-size: 13px; background: #f39c12; color: white;">Gỡ bài</a>
                        <?php endif; ?>
                        <a href="news_list.php?action=delete&id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-delete" style="margin: 0; padding: 6px 12px; font-size: 13px;" onclick="return confirm('Ông chắc chắn muốn xóa vĩnh viễn bài này không?')">Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>