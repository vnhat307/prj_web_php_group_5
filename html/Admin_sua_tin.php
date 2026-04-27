<?php
session_start();
include '../includes/connect.php';

// 1. KIỂM TRA ĐĂNG NHẬP: Nếu không có session thì mới cho văng ra login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 2. LẤY DỮ LIỆU TIN CẦN SỬA
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_get = "SELECT * FROM news WHERE NEWS_ID = '$id'";
    $res_get = mysqli_query($conn, $sql_get);
    $news_edit = mysqli_fetch_assoc($res_get);

    // Nếu không tìm thấy tin, đá về trang tương ứng với quyền
    if (!$news_edit) {
        $back_page = ($_SESSION['role'] === 'Admin') ? "admin.php" : "author_news.php";
        header("Location: $back_page");
        exit();
    }
}

// 3. XỬ LÝ CẬP NHẬT
if (isset($_POST['submit'])) {
    $news_id = $_POST['news_id'];
    // Dùng real_escape_string để tránh lỗi dấu nháy đơn làm hỏng câu lệnh SQL
    $news_name = mysqli_real_escape_string($conn, $_POST['news_name']);
    $cate_id = $_POST['cate_id'];
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);
    $news_url = $_POST['news_url'];
    $ngaydang = $_POST['ngaydang'];

    $sql_update = "UPDATE news SET 
        NEWS_NAME = '$news_name', 
        CATE_ID = '$cate_id', 
        NOIDUNG = '$noidung', 
        NEWS_URL = '$news_url', 
        NGAYDANG = '$ngaydang' 
        WHERE NEWS_ID = '$news_id'";
    
    if (mysqli_query($conn, $sql_update)) {
        // TỰ ĐỘNG QUAY VỀ ĐÚNG TRANG THEO QUYỀN
        if ($_SESSION['role'] === 'Admin') {
            header("Location: admin.php");
        } else {
            header("Location: author_news.php");
        }
        exit;
    } else {
        $error = "Lỗi: " . mysqli_error($conn);
    }
}

$sql_cate = "SELECT * FROM category";
$res_cate = mysqli_query($conn, $sql_cate);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Tin Tức - <?php echo $_SESSION['role']; ?></title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        /* Thêm tí style cho đẹp */
        .sidebar p { color: #fff; padding: 10px 20px; font-size: 13px; opacity: 0.8; }
        .btn-submit { cursor: pointer; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><?php echo ($_SESSION['role'] === 'Admin') ? 'ADMIN PANEL' : 'AUTHOR PANEL'; ?></h2>
        <p>Chào, <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)</p>
        
        <?php if($_SESSION['role'] === 'Admin'): ?>
            <a href="admin.php">Quản lý Tin tức</a>
            <a href="category_list.php">Quản lý Danh mục</a>
            <a href="account_list.php">Quản lý Tài khoản</a>
        <?php else: ?>
            <a href="author_news.php" class="active">Bài viết của tôi</a>
        <?php endif; ?>
        
        <a href="Trang_chu.php">Trở về Trang chủ</a>
        <a href="logout.php" style="color: #ff7675;">Đăng xuất</a>
    </div>

    <div class="content">
        <h2>Sửa Tin Tức</h2>
        <div class="form-container">
            <?php if(isset($error)) echo "<div class='error' style='color:red; margin-bottom:15px;'>$error</div>"; ?>
            
            <form action="admin_sua_tin.php?id=<?php echo $news_edit['NEWS_ID']; ?>" method="POST">
                <div class="form-group">
                    <label>Mã Tin (Cố định):</label>
                    <input type="text" name="news_id" value="<?php echo $news_edit['NEWS_ID']; ?>" readonly style="background-color: #eee; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Tiêu đề tin:</label>
                    <input type="text" name="news_name" required value="<?php echo htmlspecialchars($news_edit['NEWS_NAME']); ?>">
                </div>
                <div class="form-group">
                    <label>Chuyên mục:</label>
                    <select name="cate_id" required>
                        <?php while($cate = mysqli_fetch_assoc($res_cate)) { ?>
                            <option value="<?php echo $cate['CATE_ID']; ?>" <?php if($cate['CATE_ID'] == $news_edit['CATE_ID']) echo 'selected'; ?>>
                                <?php echo $cate['CATE_NAME']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nội dung:</label>
                    <textarea name="noidung" required style="height: 200px;"><?php echo htmlspecialchars($news_edit['NOIDUNG']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Đường dẫn ảnh (URL):</label>
                    <input type="text" name="news_url" required value="<?php echo $news_edit['NEWS_URL']; ?>">
                </div>
                <div class="form-group">
                    <label>Ngày đăng:</label>
                    <input type="date" name="ngaydang" required value="<?php echo date('Y-m-d', strtotime($news_edit['NGAYDANG'])); ?>">
                </div>
                <button type="submit" name="submit" class="btn-submit" style="background: #2980b9; color:white; padding: 10px 20px; border:none; border-radius:5px;">Lưu thay đổi</button>
                <a href="<?php echo ($_SESSION['role'] === 'Admin') ? 'admin.php' : 'author_news.php'; ?>" style="margin-left:10px; color:#666;">Hủy bỏ</a>
            </form>
        </div>
    </div>
</body>
</html>