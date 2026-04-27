<?php 
session_start();
include '../includes/connect.php'; 
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/The_thao.css" />
    <link rel="stylesheet" href="../css/styleprj.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <title>Thể thao - Báo Mới</title>
    <style>
      .user-nav { display: flex; align-items: center; gap: 15px; margin-left: auto; color: #333; }
      .user-nav span { font-weight: bold; color: #2c3e50; }
      .user-nav a { color: white; text-decoration: none; font-weight: bold; background: #e74c3c; padding: 5px 15px; border-radius: 20px; }
      .user-nav a:hover { background: #c0392b; }
      .user-nav .logout-btn { background: #7f8c8d; }
      .user-nav .logout-btn:hover { background: #95a5a6; }
      .interaction-bar { display: flex; gap: 15px; margin-top: 10px; font-size: 0.9rem; color: #555; }
      .interaction-btn { cursor: pointer; display: flex; align-items: center; gap: 5px; transition: 0.3s; }
      .interaction-btn:hover { color: #e74c3c; }
      .bi-heart-fill { color: #e74c3c; }
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
            <li><a href="./The_thao.php" class="active">Thể thao</a></li>
            <li><a href="./Giai_tri.php">Giải trí</a></li>
            <li><a href="./Lien_he.php">Liên hệ</a></li>
            <li><a href="./FAQ.php">FAQ</a></li>
          </ul>
          <div class="user-nav">
            <?php if(isset($_SESSION['username'])) { 
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
          <div class="category-header">
            <h1>Thể thao</h1>
          </div>

          <div class="hero article-container" data-id="N23">
            <a href="Chi_tiet_tin.php?id=N23">
                <img src="../img/TT_ tu_hao_Vn.webp" alt="80 nam the thao vn" style="object-fit: cover;" />
            </a>
            <div class="hero-content">
              <a href="Chi_tiet_tin.php?id=N23" class="news-link">
                <h3>Tự hào hành trình thể thao trong 80 năm của Việt Nam</h3>
              </a>
              <p>Tiến bộ dần đều trong thể thao và gặt hái những danh hiệu và thành công trong nước, Việt Nam ngày sỡ hữu nhiều anh tài...</p>
              <div class="hero-meta">
                <span>Báo Thể thao</span> • <span>27/04/2026</span>
              </div>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">412</span></div>
                <div class="interaction-btn"><i class="bi bi-chat-dots"></i> <span>105</span></div>
              </div>
            </div>
          </div>

          <div class="news-grid-2col">
            <div class="news-card-medium article-container" data-id="N24">
              <a href="Chi_tiet_tin.php?id=N24" class="news-link">
                <img src="../img/TT_ban_cung_sea_game.webp" alt="Bắn cung SEA Games" style="object-fit: cover;" />
                <h3>Bắn cung Việt Nam</h3>
              </a>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">189</span></div>
                <div class="interaction-btn"><i class="bi bi-chat-dots"></i> 45</div>
              </div>
            </div>
            <div class="news-card-medium article-container" data-id="N25">
              <a href="Chi_tiet_tin.php?id=N25" class="news-link">
                <img src="../img/TT_football_global.jpg" alt="Barca Ngoại hạng Anh" style="object-fit: cover;" />
                <h3>Barca vẫn còn cửa vô địch Ngoại hạng Anh nếu...</h3>
              </a>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">320</span></div>
                <div class="interaction-btn"><i class="bi bi-chat-dots"></i> 88</div>
              </div>
            </div>
          </div>

          <div class="news-grid-4col">
            <div class="news-card-small article-container" data-id="N26">
              <a href="Chi_tiet_tin.php?id=N26" class="news-link">
                <img src="../img/TT_football_vn.jpg" alt="U17 Việt Nam" style="object-fit: cover;" />
                <h4>Sức hút đặc biệt của U17 Việt Nam</h4>
              </a>
              <div class="interaction-bar"><div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">156</span></div></div>
            </div>
            <div class="news-card-small article-container" data-id="N27">
              <a href="Chi_tiet_tin.php?id=N27" class="news-link">
                <img src="../img/TT_Basketball_vn.png" alt="Bóng rổ" style="object-fit: cover;" />
                <h4>Bóng rổ vẫn luôn mang sức hút mãnh liệt</h4>
              </a>
              <div class="interaction-bar"><div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">210</span></div></div>
            </div>
            <div class="news-card-small article-container" data-id="N28">
              <a href="Chi_tiet_tin.php?id=N28" class="news-link">
                <img src="../img/TT_tenis_vn.jpg" alt="tenis vn" style="object-fit: cover;" />
                <h4>Tennis căng thẳng nhất quả đất</h4>
              </a>
              <div class="interaction-bar"><div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">98</span></div></div>
            </div>
            <div class="news-card-small article-container" data-id="N29">
              <a href="Chi_tiet_tin.php?id=N29" class="news-link">
                <img src="../img/TT_boxing.jpg" alt="Boxing" style="object-fit: cover;" />
                <h4>Cực căng thẳng giữa 2 boxers đẳng cấp thế giới</h4>
              </a>
              <div class="interaction-bar"><div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">430</span></div></div>
            </div>
          </div>
        </main>
      </div>

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
              <li><a href="#">Nhóm 5 Lập Trình Web, ĐH GTVT, TP.HCM</a></li>
              <li><a href="#">Hotline: 1900 1234</a></li>
              <li><a href="#">Email: info@baomoi.vn</a></li>
              <li><a href="#">Làm việc: 07:00 - 17:00</a></li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <span>&copy; 2026 Báo Mới. All rights reserved.</span>
          <span><a href="#">Điều khoản</a> &nbsp;·&nbsp; <a href="#">Bảo mật</a></span>
        </div>
      </footer>
    </div>

    <script src="../javascript/prj.js"></script>
    <script src="../javascript/light_dark_mode.js"></script>
    <script src="../javascript/menu_hide_show.js"></script>
    <script src="../javascript/search_filter.js"></script>
    <script>
      // Kích hoạt nút thả tim
      document.querySelectorAll('.heart-btn').forEach(btn => {
          btn.addEventListener('click', function(e) {
              e.preventDefault(); 
              const icon = this.querySelector('i');
              const countSpan = this.querySelector('.count');
              let count = parseInt(countSpan.innerText);
              if (icon.classList.contains('bi-heart')) {
                  icon.classList.replace('bi-heart', 'bi-heart-fill');
                  countSpan.innerText = count + 1;
              } else {
                  icon.classList.replace('bi-heart-fill', 'bi-heart');
                  countSpan.innerText = count - 1;
              }
          });
      });
    </script>
  </body>
</html>