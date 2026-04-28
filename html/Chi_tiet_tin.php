<?php 
session_start();
include '../includes/connect.php';

if (!isset($_GET['id'])) {
    header("Location: Trang_chu.php");
    exit;
}

$news_id = $_GET['id'];
// Đếm lượt xem và đảm bảo mỗi phiên chỉ đếm một lần
if (!isset($_SESSION['viewed_' . $news_id])) {
    mysqli_query($conn, "UPDATE trending SET VIEWS = VIEWS + 1 WHERE NEWS_ID = '$news_id'");
    if (mysqli_affected_rows($conn) == 0) {
        $trend_id = 'T' . rand(10000, 99999);
        mysqli_query($conn, "INSERT INTO trending (TRENDING_ID, NEWS_ID, VIEWS, LIKES, CAPNHATNGAY) VALUES ('$trend_id', '$news_id', 1, 0, NOW())");
    }
    $_SESSION['viewed_' . $news_id] = true;
}
// Kiểm tra xem người dùng đã thích bài viết này chưa
$has_liked = isset($_SESSION['liked_' . $news_id]);
if (isset($_POST['react'])) {
    if ($has_liked) {
        mysqli_query($conn, "UPDATE trending SET LIKES = GREATEST(LIKES - 1, 0) WHERE NEWS_ID = '$news_id'");
        unset($_SESSION['liked_' . $news_id]);
    } else {
        mysqli_query($conn, "UPDATE trending SET LIKES = LIKES + 1 WHERE NEWS_ID = '$news_id'");
        $_SESSION['liked_' . $news_id] = true;
    }
    header("Location: Chi_tiet_tin.php?id=" . $news_id);
    exit;
}
// Xử lý bình luận mới
if (isset($_POST['submit_comment']) && isset($_SESSION['user_id'])) {
    $noidung = trim($_POST['noidung']);
    $user_id = $_SESSION['user_id']; 
    $com_id = 'CM' . rand(1000, 9999);
    if(!empty($noidung)){
        mysqli_query($conn, "INSERT INTO comment (COMMENT_ID, NEWS_ID, USER_ID, NOIDUNG, NGAY_COM, TRANGTHAI) VALUES ('$com_id', '$news_id', '$user_id', '$noidung', NOW(), 1)");
        header("Location: Chi_tiet_tin.php?id=" . $news_id);
        exit;
    }
}
// Truy vấn lấy thông tin chi tiết bài viết, tên thể loại, tên tác giả, số lượt thích và xem
$sql_news = "SELECT n.*, c.CATE_NAME, a.AUTHOR_NAME, IFNULL(t.LIKES, 0) as LIKES, IFNULL(t.VIEWS, 0) as VIEWS 
             FROM news n 
             JOIN category c ON n.CATE_ID = c.CATE_ID 
             JOIN author a ON n.AUTHOR_ID = a.AUTHOR_ID
             LEFT JOIN trending t ON n.NEWS_ID = t.NEWS_ID
             WHERE n.NEWS_ID = '$news_id'";
$res_news = mysqli_query($conn, $sql_news);
$news = mysqli_fetch_assoc($res_news);

$sql_com = "SELECT c.NOIDUNG, c.NGAY_COM, u.FULL_NAME, u.AVATAR FROM comment c JOIN userr u ON c.USER_ID = u.USER_ID WHERE c.NEWS_ID = '$news_id' ORDER BY c.NGAY_COM DESC";
$res_com = mysqli_query($conn, $sql_com);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $news['NEWS_NAME']; ?></title>
    <link rel="stylesheet" href="../css/chi_tiet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <article class="article-wrapper">
        <a href="javascript:history.back()" class="back-link" style="color: #7f8c8d; text-decoration: none; font-weight: bold;">
    &larr; Quay lại trang trước
</a>
        
        <div class="cate-name"><?php echo $news['CATE_NAME']; ?></div>
        <h1 class="article-title"><?php echo $news['NEWS_NAME']; ?></h1>
        
        <div class="article-meta">
            <span><?php echo date('d/m/Y, H:i', strtotime($news['NGAYDANG'])); ?> (GMT+7)</span>
            <span><i class="bi bi-eye"></i> <?php echo number_format($news['VIEWS']); ?> lượt xem</span>
        </div>

        <div class="article-image-box">
            <img src="<?php echo $news['NEWS_URL']; ?>" alt="Ảnh bài báo">
            <div class="image-caption">Ảnh minh họa: Phóng viên Việt Nhật/Báo Mới</div>
        </div>

        <div class="article-content">
            <?php echo $news['NOIDUNG']; ?>
            <div class="author-sign"><?php echo $news['AUTHOR_NAME']; ?></div>
        </div>

        <div class="toolbar">
            <form method="POST">
                <button type="submit" name="react" class="btn-like <?php echo $has_liked ? 'btn-like-active' : ''; ?>">
                    <i class="bi <?php echo $has_liked ? 'bi-heart-fill' : 'bi-heart'; ?>"></i> 
                    <?php echo $has_liked ? 'Đã thích' : 'Thích'; ?>
                </button>
            </form>
            <span class="stats-item"><i class="bi bi-chat-dots"></i> <?php echo mysqli_num_rows($res_com); ?> bình luận</span>
            <span class="stats-item"><i class="bi bi-heart-fill" style="color: #e74c3c"></i> <?php echo number_format($news['LIKES']); ?> lượt thích</span>
        </div>

        <section class="comment-section">
            <div class="comment-header">Ý kiến (<?php echo mysqli_num_rows($res_com); ?>)</div>
            
            <?php if(isset($_SESSION['username'])) { ?>
                <form class="comment-form" method="POST">
                    <textarea name="noidung" placeholder="Chia sẻ ý kiến của bạn về bài viết..."></textarea>
                    <button type="submit" name="submit_comment">Gửi bình luận</button>
                </form>
            <?php } else { ?>
                <div style="background: #f9f9f9; padding: 20px; text-align: center; border: 1px solid #eee; font-size: 14px;">
                    Vui lòng <a href="login.php" style="color: #076db6; font-weight: bold; text-decoration: none;">Đăng nhập</a> để tham gia bình luận.
                </div>
            <?php } ?>

            <div class="comment-list">
                <?php while($com = mysqli_fetch_assoc($res_com)) { ?>
                    <div class="comment-item">
                        <img src="<?php echo $com['AVATAR'] ? $com['AVATAR'] : '../img/news.jpg'; ?>" alt="Avatar">
                        <div class="comment-item-info">
                            <b><?php echo $com['FULL_NAME']; ?></b>
                            <span><?php echo date('d/m/Y H:i', strtotime($com['NGAY_COM'])); ?></span>
                            <p><?php echo $com['NOIDUNG']; ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </article>

</body>
</html>