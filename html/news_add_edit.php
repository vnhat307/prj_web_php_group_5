<?php // trang soạn thảo và chỉnh sửa tin tức dành cho Author
session_start();
include '../includes/connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Author') {
    header("Location: login.php");
    exit;
}

$acc_id = $_SESSION['acc_id'];
$query_author = mysqli_query($conn, "SELECT AUTHOR_ID FROM author WHERE ACC_ID = '$acc_id'");
$author_data = mysqli_fetch_assoc($query_author);
$author_id = $author_data['AUTHOR_ID'] ?? '';

$id = ""; $news_name = ""; $noidung = ""; $cate_id = ""; $news_URL = ""; $trangthai = 0; $is_edit = false;

// lay danh sach the loai (Category) from Database de dua vao Dropdown
$category_list = mysqli_query($conn, "SELECT * FROM category");

if (isset($_GET['id'])) {
    $is_edit = true;
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM news WHERE news_id = '$id' AND author_id = '$author_id'");
    $data = mysqli_fetch_assoc($res);
    
    if($data) {
        $news_name = $data['news_name'];
        $noidung = $data['noidung'];
        $cate_id = $data['CATE_ID'];
        $news_URL = $data['news_URL'];
        $trangthai = $data['trangthai'];
    }
}

if (isset($_POST['save'])) {
    $news_name = mysqli_real_escape_string($conn, $_POST['news_name']);
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);
    $cate_id = mysqli_real_escape_string($conn, $_POST['cate_id']);
    $news_URL = mysqli_real_escape_string($conn, $_POST['news_URL']);
    $trangthai = 0; 
    $ngayDang = date('Y-m-d');

    if ($is_edit) {
        $sql = "UPDATE news SET news_name='$news_name', noidung='$noidung', CATE_ID='$cate_id', news_URL='$news_URL', trangthai='$trangthai' WHERE news_id='$id'";
    } else {
        $check_id = mysqli_query($conn, "SELECT news_id FROM news ORDER BY news_id DESC LIMIT 1");
        $last_id = mysqli_fetch_assoc($check_id);
        $num = $last_id ? (int)substr($last_id['news_id'], 1) + 1 : 1;
        $new_id = "N" . str_pad($num, 11, '0', STR_PAD_LEFT);
        
        $sql = "INSERT INTO news (news_id, news_name, trangthai, noidung, CATE_ID, ngayDang, news_URL, author_id) 
                VALUES ('$new_id', '$news_name', '$trangthai', '$noidung', '$cate_id', '$ngayDang', '$news_URL', '$author_id')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: author_news.php");
        exit;
    } else {
        $error = "Lỗi Database: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Viết bài</title>
    <link rel="stylesheet" href="../css/Admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>TÁC GIẢ</h2>
        <a href="author_news.php" class="active">Bài viết của tôi</a>
        <a href="logout.php">Đăng xuất</a>
    </div>

    <div class="content">
        <div class="form-container">
            <h2 style="border-bottom: 2px solid #1abc9c; padding-bottom: 10px;"><?php echo $is_edit ? 'SỬA TIN' : 'SOẠN TIN MỚI'; ?></h2>
            
            <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Tên tin (news_name)</label>
                    <input type="text" name="news_name" value="<?php echo $news_name; ?>" maxlength="20" required>
                </div>
                <div class="form-group">
                    <label>Danh mục (category)</label>
                    <select name="cate_id" required>
                        <option value="">-- Chọn danh mục bài viết --</option>
                        <?php while($cat = mysqli_fetch_assoc($category_list)): ?>
                            <option value="<?php echo $cat['CATE_ID']; ?>" <?php echo ($cate_id == $cat['CATE_ID']) ? 'selected' : ''; ?>>
                                <?php echo $cat['CATE_NAME']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>URL bài viết (news_URL)</label>
                    <input type="text" name="news_URL" value="<?php echo $news_URL; ?>">
                </div>
                <div class="form-group">
                    <label>Nội dung (noidung)</label>
                    <textarea name="noidung" maxlength="500"><?php echo $noidung; ?></textarea>
                </div>
                <div class="success" style="background: #e3f2fd; color: #0d47a1; border: 1px solid #bbdefb;">
                    Bài viết sau khi lưu sẽ chờ Admin duyệt.
                </div>
                <div class="d-flex gap-2" style="margin-top: 30px;">
                    <button type="submit" name="save" class="btn-submit" style="flex: 2;">GỬI BÀI ĐỢI DUYỆT</button>
                    <a href="author_news.php" class="btn btn-delete" style="flex: 1; display: flex; align-items: center; justify-content: center;">HỦY</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>