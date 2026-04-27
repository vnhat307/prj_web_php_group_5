<?php
session_start();
include '../includes/connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

$id = ""; $acc_id = ""; $author_name = ""; $full_name = ""; $phone = ""; $bio = ""; $is_edit = false;

if (isset($_GET['id'])) {
    $is_edit = true;
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM author WHERE AUTHOR_ID = '$id'");
    $data = mysqli_fetch_assoc($res);
    $acc_id = $data['ACC_ID'];
    $author_name = $data['AUTHOR_NAME'];
    $full_name = $data['FULL_NAME'];
    $phone = $data['PHONE'];
    $bio = $data['BIO'];
}

if (isset($_POST['save'])) {
    $acc_id = mysqli_real_escape_string($conn, $_POST['acc_id']);
    $author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    if ($is_edit) {
        $sql = "UPDATE author SET ACC_ID='$acc_id', AUTHOR_NAME='$author_name', FULL_NAME='$full_name', PHONE='$phone', BIO='$bio' WHERE AUTHOR_ID='$id'";
    } else {
        $check_id = mysqli_query($conn, "SELECT AUTHOR_ID FROM author ORDER BY AUTHOR_ID DESC LIMIT 1");
        $last_id = mysqli_fetch_assoc($check_id);
        $num = $last_id ? (int)substr($last_id['AUTHOR_ID'], 2) + 1 : 1;
        $new_id = "AU" . str_pad($num, 3, '0', STR_PAD_LEFT);
        
        $sql = "INSERT INTO author (AUTHOR_ID, ACC_ID, AUTHOR_NAME, FULL_NAME, PHONE, BIO) VALUES ('$new_id', '$acc_id', '$author_name', '$full_name', '$phone', '$bio')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: author_list.php");
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
    <title>Cập nhật Tác giả</title>
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
        <div class="form-container">
            <h2 style="margin-top: 0; color: #2c3e50; border-bottom: 2px solid #1abc9c; padding-bottom: 10px; margin-bottom: 25px;">
                <?php echo $is_edit ? 'CẬP NHẬT TÁC GIẢ' : 'THÊM TÁC GIẢ MỚI'; ?>
            </h2>
            
            <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Mã Tài Khoản (ACC_ID) - Bắt buộc</label>
                    <input type="text" name="acc_id" value="<?php echo $acc_id; ?>" placeholder="Ví dụ: A02, U03..." required>
                </div>
                <div class="form-group">
                    <label>Bút danh (AUTHOR_NAME)</label>
                    <input type="text" name="author_name" value="<?php echo $author_name; ?>" required>
                </div>
                <div class="form-group">
                    <label>Họ và tên đầy đủ (FULL_NAME)</label>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                </div>
                <div class="form-group">
                    <label>Số điện thoại (PHONE)</label>
                    <input type="text" name="phone" value="<?php echo $phone; ?>">
                </div>
                <div class="form-group">
                    <label>Tiểu sử (BIO)</label>
                    <textarea name="bio"><?php echo $bio; ?></textarea>
                </div>
                <div class="d-flex gap-2" style="margin-top: 30px;">
                    <button type="submit" name="save" class="btn-submit" style="flex: 2;">LƯU THÔNG TIN</button>
                    <a href="author_list.php" class="btn btn-delete" style="flex: 1; padding: 12px; display: flex; align-items: center; justify-content: center; margin: 0;">HỦY</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>