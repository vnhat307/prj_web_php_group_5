<?php
session_start();
include '../includes/connect.php';

// chi cho phep author vao
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Author') {
    header("Location: login.php");
    exit;
}

// lay Author_ID from Account_ID trong Session
$acc_id = $_SESSION['acc_id'];
$query_author = mysqli_query($conn, "SELECT AUTHOR_ID FROM author WHERE ACC_ID = '$acc_id'");
$author_data = mysqli_fetch_assoc($query_author);
$author_id = $author_data['AUTHOR_ID'] ?? '';

// xoa bài (Chi xoa bai cua chinh minh)
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // trc khi xoa news, don dep bang trending/comment (neu co), tranh loi FK
    mysqli_query($conn, "DELETE FROM trending WHERE NEWS_ID = '$id'");
    mysqli_query($conn, "DELETE FROM comment WHERE NEWS_ID = '$id'");
    
    mysqli_query($conn, "DELETE FROM news WHERE NEWS_ID = '$id' AND AUTHOR_ID = '$author_id'");
    header("Location: author_news.php");
    exit;
}

// Lay danh sach bai viet cua tac gia nay
$sql = "SELECT * FROM news WHERE AUTHOR_ID = '$author_id' ORDER BY NEWS_ID DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài viết của tôi - Tác giả</title>
    <link rel="stylesheet" href="../css/Admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>TÁC GIẢ</h2>
        <p style="color: #fff; padding: 0 20px; font-size: 14px;">Chào, <?php echo $_SESSION['username']; ?></p>
        <hr style="border: 0.5px solid #444; margin: 10px 20px;">
        <a href="author_news.php" class="active">Bài viết của tôi</a>
        <a href="Trang_chu.php">Trở về Trang chủ</a>
        <a href="logout.php" style="color: #e74c3c;">Đăng xuất</a>
    </div>
    
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">Quản lý bài viết cá nhân</h2>
            <a href="Admin_them_tin.php" class="btn btn-add" style="text-decoration: none; background: #27ae60; color: white; padding: 10px 20px; border-radius: 5px;">+ Viết bài mới</a>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #f4f4f4;">
                    <th>Mã Tin</th>
                    <th>Tiêu đề bài viết</th>
                    <th>Ngày đăng</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?php echo $row['NEWS_ID']; ?></strong></td>
                        <td style="max-width: 300px;"><?php echo $row['NEWS_NAME']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['NGAYDANG'])); ?></td>
                        <td>
                            <?php if($row['TRANGTHAI'] == 1): ?>
                                <span style="color: #27ae60; font-weight: bold;">✔️ Hiện</span>
                            <?php else: ?>
                                <span style="color: #e74c3c; font-weight: bold;">⏳ Đang ẩn</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="Admin_sua_tin.php?id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-edit" style="background: #3498db; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 13px;">Sửa</a>
                            
                            <a href="author_news.php?delete_id=<?php echo $row['NEWS_ID']; ?>" class="btn btn-delete" style="background: #e74c3c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 13px; margin-left: 5px;" onclick="return confirm('Xác nhận xóa bài viết này?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Bạn chưa có bài viết nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>