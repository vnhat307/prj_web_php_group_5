<?php 
session_start();
include '../includes/connect.php'; 
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/styleprj.css" />
    <link rel="stylesheet" href="../css/Lien_he.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <title>Liên hệ - Báo Mới</title>
    <style>
      /* Khung User Nav đồng bộ với Trang chủ */
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
            <span></span><span></span><span></span>
          </button>

          <ul class="nav-menu" id="nav-menu">
            <li><a href="./Trang_chu.php">Trang chủ</a></li>
            <li><a href="./Gioi_thieu.php">Giới thiệu</a></li>
            <li><a href="./Tin_tuc.php">Tin tức</a></li>
            <li><a href="./The_thao.php">Thể thao</a></li>
            <li><a href="./Giai_tri.php">Giải trí</a></li>
            <li><a href="./Lien_he.php" class="active">Liên hệ</a></li>
            <li><a href="./FAQ.php">FAQ</a></li>
          </ul>

          <div class="user-nav">
            <?php if(isset($_SESSION['username'])) { 
                // Gắn link nhảy về trang Admin hoặc Author dựa vào Role
                $panel_link = (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') ? "Admin.php" : "author_news.php";
            ?>
                <a href="<?php echo $panel_link; ?>" style="background: none; padding: 0; color: inherit; display: inline-flex; align-items: center; gap: 5px;">
                    <span>Chào, <?php echo $_SESSION['username']; ?></span>
                </a>
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
        <main>
          <div class="container">
            <h1 style="border-bottom: 2px solid #d32f2f; padding-bottom: 10px; margin-bottom: 20px; color: #d32f2f;">
              Liên hệ với chúng tôi qua các kênh sau:
            </h1>
            <ul>
              <li><img class="letter-icon" src="../img/letter.png" alt="Email">Email: nhom5.@gmail.com</li>
              <li><img class="letter-icon" src="../img/phonenum.png" alt="Phone">Điện thoại: 0123456789</li>
              <li><img class="letter-icon" src="../img/map.png" alt="Location">Địa chỉ: 123 Đường ABC, Quận XYZ, TP.HCM</li>
            </ul>

            <h1 style="border-bottom: 2px solid #d32f2f; padding-bottom: 10px; margin-bottom: 20px; color: #d32f2f;">
              Liên hệ qua mạng xã hội
            </h1>
            <ul>
              <li><a href="#"><img class="social-icon facebook" src="../img/facebook.png"></img> Facebook</a></li>
              <li><a href="#"><img class="social-icon X" src="../img/X.png"></img> Twitter</a></li>
              <li><a href="#"><img class="social-icon instagram" src="../img/instagram.jfif"></img> Instagram</a></li>
              <li><a href="#"><img class="social-icon linkedin" src="../img/linkedin.png"></img> LinkedIn</a></li>
              <li><a href="#"><img class="social-icon tiktok" src="../img/tiktok.png"></img> TikTok</a></li>
            </ul>

            <h1 style="border-bottom: 2px solid #d32f2f; padding-bottom: 10px; margin-bottom: 20px; color: #d32f2f;">
              Mẫu liên hệ:
            </h1>
            <ul>
              <li><a href="#"><img class="letter-icon" src="../img/letter.png" alt="letterimg">[Mẫu 1] Liên hệ quảng cáo</a></li>
              <li><a href="#"><img class="letter-icon" src="../img/letter.png" alt="letterimg">[Mẫu 2] Liên hệ với vai trò tác giả</a></li>
              <li><a href="#"><img class="letter-icon" src="../img/letter.png" alt="letterimg">[Mẫu 3] Góp ý</a></li>
            </ul>
          </div>
        </main>
      </div>

      <footer class="site-footer">
        <div class="footer-top">
          <div class="footer-brand">
            <h2>Báo Mới</h2>
            <p>Cập nhật tin tức nhanh, chính xác và khách quan. Đồng hành cùng bạn mỗi ngày.</p>
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

    <script src="../javascript/tha_tym.js"></script>
    <script src="../javascript/light_dark_mode.js"></script>
    <script src="../javascript/menu_hide_show.js"></script>
    <script src="../javascript/search_filter.js"></script>
  </body>
</html>