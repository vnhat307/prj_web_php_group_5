<?php 
session_start();
include '../includes/connect.php'; 
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Giới Thiệu - Báo Mới</title>
    <link rel="stylesheet" href="../css/styleprj.css" />
    <link rel="stylesheet" href="../css/Gioi_thieu.css" />
    <link rel="stylesheet" href="../css/fonts.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap"
      rel="stylesheet"
    />

    <style>
      /* Style cho thanh User Nav dong bo vs all trang */
      .user-nav {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-left: auto;
        color: #333;
      }
      .user-nav span {
        font-weight: bold;
        color: #2c3e50;
      }
      .user-nav a.btn-login {
        color: white;
        text-decoration: none;
        font-weight: bold;
        background: #e74c3c;
        padding: 5px 15px;
        border-radius: 20px;
      }
      .user-nav a.btn-login:hover {
        background: #c0392b;
      }
      .user-nav .logout-btn {
        background: #7f8c8d;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
      }
      .user-nav .logout-btn:hover {
        background: #95a5a6;
      }
      /* fix loi rớt dấu cho blockquote */
blockquote { font-style: normal; line-height: 1.6; }
    </style>
  </head>

  <body>
    <div class="wrapper">
      <header>
        <h1>Báo Mới</h1>
        <form action="search.php" method="GET" class="search-box">
          <input
            type="text"
            name="keyword"
            placeholder="Tìm kiếm..."
            required
          />
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
            <li><a href="./Gioi_thieu.php" class="active">Giới thiệu</a></li>
            <li><a href="./Tin_tuc.php">Tin tức</a></li>
            <li><a href="./The_thao.php">Thể thao</a></li>
            <li><a href="./Giai_tri.php">Giải trí</a></li>
            <li><a href="./Lien_he.php">Liên hệ</a></li>
            <li><a href="./FAQ.php">FAQ</a></li>
          </ul>

          <div class="user-nav">
            <?php if(isset($_SESSION['username'])) { $panel_link =
            (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') ?
            "Admin.php" : "author_news.php"; ?>
            <a
              href="<?php echo $panel_link; ?>"
              style="
                background: none;
                padding: 0;
                color: inherit;
                display: inline-flex;
                align-items: center;
                gap: 5px;
              "
            >
              <span>Chào, <?php echo $_SESSION['username']; ?></span>
            </a>
            <a href="logout.php" class="logout-btn">Đăng xuất</a>
            <?php } else { ?>
            <a href="login.php" class="btn-login">Đăng nhập</a>
            <?php } ?>
          </div>

          <button id="switch-mode" style="margin-left: 15px">
            <i class="bi bi-moon-stars-fill"></i>
          </button>
        </div>
      </nav>

      <section class="hero">
        <div class="hero-bg"></div>
        <div class="container hero-content">
          <p class="hero-eyebrow">Giới thiệu</p>
          <h1>
            Tin tức <em>nhanh chóng</em>,<br />chính xác &amp; đáng tin cậy
          </h1>
          <p class="hero-sub">— nơi thông tin gặp gỡ sự trung thực.</p>
        </div>
      </section>

      <main class="container">
        <section class="team section-block">
          <div class="section-label">01 / Đội ngũ</div>
          <h2>Đội Ngũ</h2>
          <p class="team-desc">
            Chúng tôi là tập hợp những người trẻ năng động, đam mê báo chí và
            công nghệ...
          </p>
          <div class="team-avatars">
            <div class="avatar-item">
              <div class="avatar">
                <img
                  src="../img/Avatar_GiaBao.png"
                  alt="Gia Bảo"
                  class="avatar-img"
                  onerror="this.style.display = 'none'"
                /><span class="avatar-initials">NB</span>
              </div>
              <span class="avatar-name">Nguyễn Trương Gia Bảo</span>
            </div>
            <div class="avatar-item">
              <div class="avatar">
                <img
                  src="../img/Avatar_DangDuy.png"
                  alt="Đăng Duy"
                  class="avatar-img"
                  onerror="this.style.display = 'none'"
                /><span class="avatar-initials">PD</span>
              </div>
              <span class="avatar-name">Phạm Đăng Duy</span>
            </div>
            <div class="avatar-item">
              <div class="avatar">
                <img
                  src="../img/Avatar_VanKham.png"
                  alt="Văn Khâm"
                  class="avatar-img"
                  onerror="this.style.display = 'none'"
                /><span class="avatar-initials">NK</span>
              </div>
              <span class="avatar-name">Nguyễn Văn Khâm</span>
            </div>
            <div class="avatar-item">
              <div class="avatar">
                <img
                  src="../img/Avatar_VietNhat.png"
                  alt="Việt Nhật"
                  class="avatar-img"
                  onerror="this.style.display = 'none'"
                /><span class="avatar-initials">NN</span>
              </div>
              <span class="avatar-name">Nguyễn Đình Việt Nhật</span>
            </div>
            <div class="avatar-item">
              <div class="avatar">
                <img
                  src="../img/Avatar_MinhThai.png"
                  alt="Minh Thái"
                  class="avatar-img"
                  onerror="this.style.display = 'none'"
                /><span class="avatar-initials">PT</span>
              </div>
              <span class="avatar-name">Phạm Minh Thái</span>
            </div>
            <div class="avatar-item">
              <div class="avatar">
                <img
                  src="../img/Avatar-MinhTrinh.png"
                  alt="Minh Trinh"
                  class="avatar-img"
                  onerror="this.style.display = 'none'"
                /><span class="avatar-initials">HT</span>
              </div>
              <span class="avatar-name">Hoàng Đinh Minh Trinh</span>
            </div>
          </div>
        </section>

        <section class="about-intro section-block">
          <div class="section-label">02 / Giới thiệu</div>
          <div class="about-grid">
            <div class="about-text">
              <h2>Chúng tôi là ai?</h2>
              <p>
                <strong>Báo Mới</strong> là nền tảng cung cấp tin tức nhanh
                chóng, chính xác...
              </p>
              <p>
                Với đội ngũ biên tập viên giàu kinh nghiệm, chúng tôi cam kết
                mang đến nội dung chất lượng...
              </p>
            </div>
            <div class="about-decoration">
              <div class="deco-card">
                <span class="deco-num">24/7</span
                ><span class="deco-text">Cập nhật tin tức</span>
              </div>
              <div class="deco-card accent">
                <span class="deco-num">100%</span
                ><span class="deco-text">Kiểm chứng nội dung</span>
              </div>
            </div>
          </div>
        </section>

        <section class="mission section-block">
          <div class="section-label">03 / Sứ mệnh</div>
          <h2>Sứ mệnh</h2>
          <div class="mission-list">
            <div class="mission-item">
              <div class="mission-icon">⚡</div>
              <div>
                <h3>Nhanh &amp; Chính xác</h3>
                <p>Cung cấp thông tin nhanh chóng...</p>
              </div>
            </div>
            <div class="mission-item">
              <div class="mission-icon">🔍</div>
              <div>
                <h3>Minh bạch</h3>
                <p>Đảm bảo tính minh bạch và khách quan...</p>
              </div>
            </div>
            <div class="mission-item">
              <div class="mission-icon">📱</div>
              <div>
                <h3>Tiện lợi</h3>
                <p>Trải nghiệm đọc tin mọi lúc mọi nơi...</p>
              </div>
            </div>
          </div>
        </section>

        <section class="vision section-block">
          <div class="section-label">04 / Tầm nhìn</div>
          <div class="vision-wrap">
            <h2>Tầm Nhìn</h2>
            <blockquote>
  Báo Mới hướng tới trở thành một trong những nền tảng tin tức hàng đầu, nơi người dùng có thể tin tưởng và sử dụng hàng ngày để cập nhật thông tin.
</blockquote>
          </div>
        </section>

        <section class="values section-block">
          <div class="section-label">05 / Giá trị</div>
          <h2>Giá Trị Cốt Lõi</h2>
          <div class="values-grid">
            <div class="value-card">
              <div class="value-icon">✅</div>
              <h3>Chính xác</h3>
              <p>Thông tin được kiểm chứng rõ ràng.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">⏱</div>
              <h3>Nhanh chóng</h3>
              <p>Cập nhật liên tục 24/7.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">⚖️</div>
              <h3>Khách quan</h3>
              <p>Tôn trọng sự đa dạng thông tin.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">🖥️</div>
              <h3>Tiện lợi</h3>
              <p>Giao diện thân thiện mọi thiết bị.</p>
            </div>
          </div>
        </section>
      </main>

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
    <script src="../javascript/light_dark_mode.js"></script>
    <script src="../javascript/menu_hide_show.js"></script>
  </body>
</html>
