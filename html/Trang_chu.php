<?php 
session_start();
include '../includes/connect.php'; 

$sql_featured = "SELECT * FROM news ORDER BY NEWS_ID ASC LIMIT 1";
$res_featured = mysqli_query($conn, $sql_featured);
$featured = mysqli_fetch_assoc($res_featured);

$sql_sub = "SELECT * FROM news ORDER BY NEWS_ID ASC LIMIT 1, 3";
$res_sub = mysqli_query($conn, $sql_sub);

$sql_list = "SELECT n.*, c.CATE_NAME FROM news n JOIN category c ON n.CATE_ID = c.CATE_ID ORDER BY n.NEWS_ID DESC";
$res_list = mysqli_query($conn, $sql_list);

$sql_trending = "SELECT n.NEWS_ID, n.NEWS_NAME, n.NOIDUNG, n.NEWS_URL, t.VIEWS FROM trending t JOIN news n ON t.NEWS_ID = n.NEWS_ID ORDER BY t.VIEWS DESC";
$res_trending = mysqli_query($conn, $sql_trending);
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/styleprj.css" />
    <link rel="stylesheet" href="../css/trang_chu.css" />
    <link rel="stylesheet" href="../css/font.css" />
    <title>Trang chủ - Báo Mới</title>
    <style>
      .user-nav { display: flex; align-items: center; gap: 15px; margin-left: auto; color: #333; }
      .user-nav span { font-weight: bold; color: #2c3e50; }
      .user-nav a { color: white; text-decoration: none; font-weight: bold; background: #e74c3c; padding: 5px 15px; border-radius: 20px; }
      .user-nav a:hover { background: #c0392b; }
      .user-nav .logout-btn { background: #7f8c8d; }
      .user-nav .logout-btn:hover { background: #95a5a6; }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <header>
        <h1>Báo Mới</h1>
        <form action="search.php" method="GET" class="search-box">
          <input type="text" name="keyword" placeholder="Tìm kiếm..." required />
          <button type="submit" class="ntbutton">Find</button>
        </form>
        <div class="logo">
          <img src="../img/logo.png" alt="Logo" />
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
            <li><a href="./Trang_chu.php" class="active">Trang chủ</a></li>
            <li><a href="./Gioi_thieu.php">Giới thiệu</a></li>
            <li><a href="./Tin_tuc.php">Tin tức</a></li>
            <li><a href="./The_thao.php">Thể thao</a></li>
            <li><a href="./Giai_tri.php">Giải trí</a></li>
            <li><a href="./Lien_he.php">Liên hệ</a></li>
            <li><a href="./FAQ.php">FAQ</a></li>
          </ul>
          
          <div class="user-nav">
    <?php if(isset($_SESSION['username'])) { 
        // Xác định link nhảy dựa trên role
        $panel_link = "#";
        if($_SESSION['role'] == 'Admin') {
            $panel_link = "Admin.php";
        } elseif($_SESSION['role'] == 'Author') {
            $panel_link = "author_news.php";
        }
    ?>
        <a href="<?php echo $panel_link; ?>" style="background: none; padding: 0; color: inherit; display: inline-flex; align-items: center; gap: 5px;">
            <span>Chào, <?php echo $_SESSION['username']; ?></span>
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

          <button id="switch-mode" style="margin-left: 15px;">
            <i class="bi bi-moon-stars-fill"></i>
          </button>
        </div>
      </nav>
      <div class="page-wrapper">
        <div class="layout-trang-chu">
          <main>
            <div class="container">
              
              <?php if($featured) { ?>
              <article class="featured-top">
                <div class="featured_img">
                  <a href="Chi_tiet_tin.php?id=<?php echo $featured['NEWS_ID']; ?>">
                    <img src="<?php echo $featured['NEWS_URL']; ?>" alt="Tin hot" />
                  </a>
                </div>
                <h2 class="featured-title">
                  <a href="Chi_tiet_tin.php?id=<?php echo $featured['NEWS_ID']; ?>" style="text-decoration: none; color: inherit;">
                    <?php echo $featured['NEWS_NAME']; ?>
                  </a>
                </h2>
              </article>
              <?php } ?>

              <div class="sub-featured-grid">
                <?php while($sub = mysqli_fetch_assoc($res_sub)) { ?>
                <article class="sub-item">
                  <div class="sub_img">
                    <a href="Chi_tiet_tin.php?id=<?php echo $sub['NEWS_ID']; ?>">
                      <img src="<?php echo $sub['NEWS_URL']; ?>" alt="Tin phụ" />
                    </a>
                  </div>
                  <h4>
                    <a href="Chi_tiet_tin.php?id=<?php echo $sub['NEWS_ID']; ?>" style="text-decoration: none; color: inherit;">
                      <?php echo $sub['NEWS_NAME']; ?>
                    </a>
                  </h4>
                </article>
                <?php } ?>
              </div>

              <hr style="margin: 20px 0" />

              <div class="list_news">
                <?php while($news = mysqli_fetch_assoc($res_list)) { ?>
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
              </div>

            </div>
          </main>

          <aside>
            <div class="news_trending">
              <h1>Tin nổi bật tháng 4/2026</h1>
              <?php while($trend = mysqli_fetch_assoc($res_trending)) { ?>
              <article class="news_trending_item">
                <h2>
                  <a href="Chi_tiet_tin.php?id=<?php echo $trend['NEWS_ID']; ?>" style="text-decoration: none; color: inherit;">
                    <?php echo $trend['NEWS_NAME']; ?>
                  </a>
                </h2>
                <div class="row_content">
                  <div class="news_trending_img">
                    <a href="Chi_tiet_tin.php?id=<?php echo $trend['NEWS_ID']; ?>">
                      <img src="<?php echo $trend['NEWS_URL']; ?>" alt="Tin nổi bật" />
                    </a>
                  </div>
                  <h4>
                    <a href="Chi_tiet_tin.php?id=<?php echo $trend['NEWS_ID']; ?>" style="text-decoration: none; color: inherit;">
                      <?php echo mb_substr($trend['NOIDUNG'], 0, 100, 'UTF-8') . '...'; ?>
                    </a>
                  </h4>
                </div>
                <p style="font-size: 12px; color: red; margin-top: 5px;"><?php echo number_format($trend['VIEWS']); ?> lượt xem</p>
              </article>
              <?php } ?>

            </div>
          </aside>
        </div>
      </div>
      <footer class="site-footer">
        <div class="footer-top">
          <div class="footer-brand">
            <h2>Báo Mới</h2>
            <p>
              Cập nhật tin tức nhanh, chính xác và khách quan. Đồng hành cùng
              bạn mỗi ngày.
            </p>
            <div class="footer-social">
              <a href="#" title="Facebook">Fb</a>
              <a href="#" title="YouTube">Ytb</a>
              <a href="#" title="TikTok">Tik</a>
              <a href="#" title="Zalo">Zalo</a>
            </div>
          </div>
          <div class="footer-col">
            <h4>Chuyên mục</h4>
            <ul>
              <li><a href="./Trang_chu.php">Trang chủ</a></li>
              <li><a href="./Tin_tuc.php">Tin tức</a></li>
              <li><a href="./The_thao.php">Thể thao</a></li>
              <li><a href="./Giai_tri.php">Giải trí</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>Về chúng tôi</h4>
            <ul>
              <li><a href="./Gioi_thieu.php">Giới thiệu</a></li>
              <li><a href="./Lien_he.php">Liên hệ</a></li>
              <li><a href="./FAQ.php">FAQ</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>Liên hệ</h4>
            <ul>
              <li><a href="#">Nhóm 5 Lập Trình Web, ĐH GTVT, TP.HCM</a></li>
              <li><a href="#">Hotline: 1900 1234</a></li>
              <li><a href="#">Email: info@baomoi.vn</a></li>
              <li><a href="#">Làm việc: 07:00 - 17:00</a></li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <span>&copy; 2026 Báo Mới. All rights reserved.</span>
          <span>
            <a href="#">Điều khoản</a> &nbsp;·&nbsp;
            <a href="#">Bảo mật</a> &nbsp;·&nbsp;
          </span>
        </div>
      </footer>
    </div>
    <script src="../javascript/prj.js"></script>
    <script src="../javascript/light_dark_mode.js"></script>
    <script src="../javascript/menu_hide_show.js"></script>
    <script src="../javascript/search_filter.js"></script>
  </body>
</html>