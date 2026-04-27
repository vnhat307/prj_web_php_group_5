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
    <link rel="stylesheet" href="../css/FAQ.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <title>FAQ - Báo Mới</title>
    <style>
      /* Style đồng bộ cho thanh User Nav của Leader */
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
            <li><a href="./Lien_he.php">Liên hệ</a></li>
            <li><a href="./FAQ.php" class="active">FAQ</a></li>
          </ul>

          <div class="user-nav">
            <?php if(isset($_SESSION['username'])) { 
                // Kiểm tra Role để điều hướng link "Chào..."
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

      <main>
        <div class="container">
          <h1 style="border-bottom: 2px solid #d32f2f; padding-bottom: 10px; margin-bottom: 20px; color: #d32f2f;">
            Câu hỏi thường gặp (FAQ)
          </h1>

          <div class="faq-section">
            <button class="faq-question" aria-expanded="false">
              <h3 style="font-family: 'Playfair Display', serif">1. Báo Mới là gì?</h3>
            </button>
            <div class="faq-answer">Báo Mới là một trang tin tức trực tuyến cung cấp thông tin nhanh chóng, chính xác...</div>
          </div>

          <div class="faq-section">
            <button class="faq-question" aria-expanded="false">
              <h3 style="font-family: 'Playfair Display', serif">2. Làm thế nào để liên hệ với Báo Mới?</h3>
            </button>
            <div class="faq-answer">Bạn có thể liên hệ với chúng tôi qua email tại nhom5.@gmail.com hoặc gọi điện thoại đến số 0123456789...</div>
          </div>

          <div class="faq-section">
            <button class="faq-question" aria-expanded="false">
              <h3 style="font-family: 'Playfair Display', serif">3. Tôi có thể gửi bài viết cho Báo Mới không?</h3>
            </button>
            <div class="faq-answer">Chúng tôi luôn chào đón những bài viết chất lượng từ cộng đồng. Bạn có thể gửi qua email hoặc trang Liên hệ...</div>
          </div>

          <div class="faq-section">
            <button class="faq-question" aria-expanded="false">
              <h3 style="font-family: 'Playfair Display', serif">4. Làm thế nào để quảng cáo trên Báo Mới?</h3>
            </button>
            <div class="faq-answer">Vui lòng liên hệ với chúng tôi qua email hoặc điện thoại để biết thêm chi tiết về các gói quảng cáo và giá cả.</div>
          </div>

          <div class="faq-section">
            <button class="faq-question" aria-expanded="false">
              <h3 style="font-family: 'Playfair Display', serif">5. Tôi có thể theo dõi Báo Mới trên mạng xã hội không?</h3>
            </button>
            <div class="faq-answer">Có, bạn có thể theo dõi chúng tôi trên Facebook, YouTube, TikTok và Zalo...</div>
          </div>

          <div class="faq-section">
            <button class="faq-question" aria-expanded="false">
              <h3 style="font-family: 'Playfair Display', serif">6. Báo Mới có ứng dụng di động không?</h3>
            </button>
            <div class="faq-answer">Hiện tại chúng tôi chưa có ứng dụng di động riêng, nhưng trang web hiển thị rất tốt trên trình duyệt di động...</div>
          </div>

          <div class="faq-section">
            <button class="faq-question" aria-expanded="false">
              <h3 style="font-family: 'Playfair Display', serif">7. Tôi có thể nhận bản tin hàng ngày từ Báo Mới không?</h3>
            </button>
            <div class="faq-answer">Có, bạn có thể đăng ký nhận bản tin hàng ngày qua email để không bỏ lỡ bất kỳ tin tức quan trọng nào.</div>
          </div>
        </div>
      </main>

      <aside>
        <div class="final-destin">
          <h2>Nếu không tìm thấy câu trả lời bạn cần:</h2>
          <p>Liên hệ với chúng tôi qua <a href="./Lien_he.php">phần liên hệ</a> để được hỗ trợ.</p>
        </div>
      </aside>

      <footer class="site-footer">
        <div class="footer-top">
          <div class="footer-brand">
            <h2>Báo Mới</h2>
            <p>Cập nhật tin tức nhanh, chính xác và khách quan. Đồng hành cùng bạn mỗi ngày.</p>
            <div class="footer-social">
              <a href="#" title="Facebook">Fb</a> <a href="#" title="YouTube">Ytb</a> <a href="#" title="TikTok">Tik</a> <a href="#" title="Zalo">Zalo</a>
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
              <li>Nhóm 5 Lập Trình Web, ĐH GTVT, TP.HCM</li>
              <li>Hotline: 1900 1234</li>
              <li>Email: info@baomoi.vn</li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <span>&copy; 2026 Báo Mới. All rights reserved.</span>
        </div>
      </footer>
    </div>

    <script src="../javascript/prj.js"></script>
    <script src="../javascript/light_dark_mode.js"></script>
    <script src="../javascript/menu_hide_show.js"></script>
    <script src="../javascript/search_filter.js"></script>
    <script src="../javascript/FAQ.js"></script>
  </body>
</html>