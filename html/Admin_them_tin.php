<?php
include '../includes/connect.php';

if (isset($_POST['submit'])) {
    $news_id = $_POST['news_id'];
    $news_name = $_POST['news_name'];
    $cate_id = $_POST['cate_id'];
    $noidung = $_POST['noidung'];
    $news_url = $_POST['news_url'];
    $ngaydang = $_POST['ngaydang'];
    $ad_id = 'AD01';
    $author_id = 'AU01';
    $trangthai = 1;

    $sql = "INSERT INTO news (NEWS_ID, AD_ID, AUTHOR_ID, CATE_ID, NEWS_NAME, NOIDUNG, TRANGTHAI, NEWS_URL, NGAYDANG) 
            VALUES ('$news_id', '$ad_id', '$author_id', '$cate_id', '$news_name', '$noidung', $trangthai, '$news_url', '$ngaydang')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
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
    <title>Thêm Tin Tức - Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>ADMIN PANEL</h2>
        <a href="admin.php">Quản lý Tin tức</a>
        <a href="#">Quản lý Danh mục</a>
        <a href="#">Quản lý Tài khoản</a>
        <a href="Trang_chu.php">Trở về Trang chủ</a>
    </div>
    <div class="content">
        <h2>Thêm Tin Tức Mới</h2>
        <div class="form-container">
            <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
            <form action="admin_them_tin.php" method="POST">
                <div class="form-group">
                    <label>Mã Tin (NEWS_ID):</label>
                    <input type="text" name="news_id" required placeholder="VD: N16">
                </div>
                <div class="form-group">
                    <label>Tiêu đề tin:</label>
                    <input type="text" name="news_name" required>
                </div>
                <div class="form-group">
                    <label>Chuyên mục:</label>
                    <select name="cate_id" required>
                        <?php while($cate = mysqli_fetch_assoc($res_cate)) { ?>
                            <option value="<?php echo $cate['CATE_ID']; ?>"><?php echo $cate['CATE_NAME']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nội dung:</label>
                    <textarea name="noidung" required></textarea>
                </div>
                <div class="form-group">
                    <label>Đường dẫn ảnh (URL):</label>
                    <input type="text" name="news_url" required value="../img/tinhot.jpg">
                </div>
                <div class="form-group">
                    <label>Ngày đăng:</label>
                    <input type="date" name="ngaydang" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <button type="submit" name="submit" class="btn-submit">Lưu Tin Tức</button>
            </form>
        </div>
    </div>
</body>
</html>