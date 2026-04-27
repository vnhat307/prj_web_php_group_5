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
    <link rel="stylesheet" href="../css/The_thao.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <title>Giải trí - Báo Mới</title>
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
            <li><a href="./The_thao.php">Thể thao</a></li>
            <li><a href="./Giai_tri.php" class="active">Giải trí</a></li>
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
            <h1>Giải trí</h1>
          </div>

          <div class="hero article-container" data-id="N16">
            <a href="Chi_tiet_tin.php?id=N16">
                <img src="../img/Gt_1.png" alt="Gt_1" style="object-fit: cover;" />
            </a>
            <div class="hero-content">
              <a href="Chi_tiet_tin.php?id=N16" class="news-link">
                <h3>Giải trí lành mạnh</h3>
              </a>
              <p>Xu hướng giải trí ngày càng tăng trong những năm gần đây.</p>
              <div class="hero-meta">
                <span>Báo giải trí</span> • <span>27/04/2026</span>
              </div>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">315</span></div>
                <div class="interaction-btn"><i class="bi bi-chat-dots"></i> <span>82</span></div>
              </div>
            </div>
          </div>

          <div class="news-grid-2col">
            <div class="news-card-medium article-container" data-id="N17">
              <a href="Chi_tiet_tin.php?id=N17" class="news-link">
                <img src="../img/Gt_2.png" alt="Gt_2" style="object-fit: cover;" />
                <h3>Công viên, bắt kịp xu hướng giải trí thế giới</h3>
              </a>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">104</span></div>
                <div class="interaction-btn"><i class="bi bi-chat-dots"></i> 26</div>
              </div>
            </div>
            <div class="news-card-medium article-container" data-id="N18">
              <a href="Chi_tiet_tin.php?id=N18" class="news-link">
                <img src="../img/Gt_3.png" alt="Gt_3" style="object-fit: cover;" />
                <h3>Giải trí trực tuyến bùng nổ</h3>
              </a>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">450</span></div>
                <div class="interaction-btn"><i class="bi bi-chat-dots"></i> 112</div>
              </div>
            </div>
          </div>

          <div class="news-grid-4col">
            <div class="news-card-small article-container" data-id="N19">
              <a href="Chi_tiet_tin.php?id=N19" class="news-link">
                <img src="../img/gt_4.png" alt="gt_4" style="object-fit: cover;" />
                <h4>Bà Nà Hill, sức hút đặc biệt của Việt Nam</h4>
              </a>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">88</span></div>
              </div>
            </div>
            <div class="news-card-small article-container" data-id="N20">
              <a href="Chi_tiet_tin.php?id=N20" class="news-link">
                <img src="../img/Gt_5.png" alt="Gt_5" style="object-fit: cover;" />
                <h4>Xu hướng giải trí hiện nay.</h4>
              </a>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">65</span></div>
              </div>
            </div>
            <div class="news-card-small article-container" data-id="N21">
              <a href="Chi_tiet_tin.php?id=N21" class="news-link">
                <img src="../img/Gt_6.png" alt="Gt_6" style="object-fit: cover;" />
                <h4>Truyền hình Vĩnh Long, nhà đài mạnh mẽ về giải trí Việt Nam</h4>
              </a>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">210</span></div>
              </div>
            </div>
            <div class="news-card-small article-container" data-id="N22">
              <a href="Chi_tiet_tin.php?id=N22" class="news-link">
                <img src="../img/Gt_7.png" alt="Gt_7" style="object-fit: cover;" />
                <h4>Ông hoàng nhạc pop - Giải trí ca nhạc.</h4>
              </a>
              <div class="interaction-bar">
                <div class="interaction-btn heart-btn"><i class="bi bi-heart"></i> <span class="count">999</span></div>
              </div>
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
    <script>
      // Chức năng Thả tim siêu mượt
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