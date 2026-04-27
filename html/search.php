<?php
session_start();
include '../includes/connect.php';

$keyword = '';
$res_search = null;
$count = 0;

if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    $sql_search = "SELECT n.*, c.CATE_NAME FROM news n JOIN category c ON n.CATE_ID = c.CATE_ID WHERE n.TRANGTHAI = 1 AND (n.NEWS_NAME LIKE '%$keyword%' OR n.NOIDUNG LIKE '%$keyword%') ORDER BY n.NEWS_ID DESC";
    $res_search = mysqli_query($conn, $sql_search);
    $count = mysqli_num_rows($res_search);
}
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/styleprj.css" />
    <link rel="stylesheet" href="../css/trang_chu.css" />
    <link rel="stylesheet" href="../css/font.css" />
    <title>Kết quả tìm kiếm - Báo Mới</title>
    <style>
      .user-nav { display: flex; align-items: center; gap: 15px; margin-left: auto; color: #333; }
      .user-nav span { font-weight: bold; color: #2c3e50; }
      .user-nav a { color: white; text-decoration: none; font-weight: bold; background: #e74c3c; padding: 5px 15px; border-radius: 20px; }
      .user-nav a:hover { background: #c0392b; }
      .user-nav .logout-btn { background: #7f8c8d; }
      .user-nav .logout-btn:hover { background: #95a5a6; }
      .search-result-title { margin-bottom: 20px; font-size: 24px; color: #333; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; display: inline-block;}
    </style>
  </head>
  <body>
    <div class="wrapper">
      <header>
        <h1><a href="Trang_chu.php" style="text-decoration: none; color: inherit;">Báo Mới</a></h1>
        <form action="search.php" method="GET" class="search-box">
          <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Tìm kiếm..." required />
          <button type="submit" class="ntbutton">Find</button>
        </form>
        <div class="logo">
          <img src="../img/logo.webp" alt="Logo" />
        </div>
      </header>

      <nav>
        <div class="nav-container">
          <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
          </button>

          <ul class="nav-menu" id="nav-menu">
            <li><a href="./Trang_chu.php">Trang chủ</a></li>
            <li><a href="./Gioi_thieu.html">Giới thiệu</a></li>
            <li><a href="./Tin_tuc.html">Tin tức</a></li>
            <li><a href="./The_thao.html">Thể thao</a></li>
            <li><a href="./Giai_tri.html">Giải trí</a></li>
            <li><a href="./Lien_he.html">Liên hệ</a></li>
            <li><a href="./FAQ.html">FAQ</a></li>
          </ul>
          
          <div class="user-nav">
            <?php if(isset($_SESSION['username'])) { 
                $panel_link = "#";
                if($_SESSION['role'] == 'Admin') {
                    $panel_link = "Admin.php";
                } elseif($_SESSION['role'] == 'Author') {
                    $panel_link = "author_news.php";
                }
            ?>
                <a href="<?php echo $panel_link; ?>" style="background: none; padding: 0; color: inherit; display: inline-flex; align-items: center; gap: 5px;">
                    <span>👋 Chào, <?php echo $_SESSION['username']; ?></span>
                </a>
                <?php if($_SESSION['role'] == 'Admin') { ?>
                    <a href="Admin.php" style="background:#3498db;">Admin</a>
                <?php } elseif($_SESSION['role'] == 'Author') { ?>
                    <a href="author_news.php" style="background:#1abc9c;">Viết bài</a>
                <?php } ?>
                <a href="logout.php" class="logout-btn">Đăng xuất</a>
            <?php } else { ?>
                <a href="login.php">Đăng nhập</a>
            <?php } ?>
          </div>
        </div>
      </nav>

      <div class="page-wrapper">
        <div class="layout-trang-chu">
          <main style="width: 100%;">
            <div class="container">
              <h2 class="search-result-title">Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($keyword); ?>" (<?php echo $count; ?> kết quả)</h2>
              
              <div class="list_news">
                <?php if($count > 0): ?>
                    <?php while($news = mysqli_fetch_assoc($res_search)) { ?>
                    <article class="news_item">
                      <div class="news_img">
                        <a href="Chi_tiet_tin.php?id=<?php echo $news['NEWS_ID']; ?>">
                          <img src="<?php echo $news['NEWS_URL']; ?>" alt="Hình ảnh tin" />
                        </a>
                      </div>
                      <div class="news_items_content">
                        <h4>
                          <a href="Chi_tiet_tin.php?id=<?php echo $news['NEWS_ID']; ?>" style="text-decoration: none; color: inherit;">
                            <?php echo $news['NEWS_NAME']; ?>
                          </a>
                        </h4>
                        <p class="meta">
                            <?php echo $news['CATE_NAME']; ?> • 
                            <?php echo date('d/m/Y', strtotime($news['NGAYDANG'])); ?>
                        </p>
                      </div>
                    </article>
                    <?php } ?>
                <?php else: ?>
                    <p style="text-align: center; color: #7f8c8d; font-size: 18px; margin-top: 50px;">Không tìm thấy bài viết nào phù hợp với từ khóa của bạn.</p>
                <?php endif; ?>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>
    <script src="../javascript/prj.js"></script>
    <script src="../javascript/light_dark_mode.js"></script>
    <script src="../javascript/menu_hide_show.js"></script>
  </body>
</html>