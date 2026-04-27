<?php 
session_start();
include '../includes/connect.php'; 

// Hàm lấy dữ liệu theo chuyên mục và sắp xếp mới nhất (DESC)
function getNewsByCategory($conn, $cate_id, $limit) {
    $sql = "SELECT * FROM news WHERE CATE_ID = '$cate_id' ORDER BY NEWS_ID DESC LIMIT $limit";
    $res = mysqli_query($conn, $sql);
    $data = [];
    if($res) {
        while($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Lấy dữ liệu cho 5 chuyên mục
$tin_trongngay = getNewsByCategory($conn, 'C01', 7);
$tin_chinhtri  = getNewsByCategory($conn, 'C05', 3);
$tin_doisong   = getNewsByCategory($conn, 'C06', 6);
$tin_giaothong = getNewsByCategory($conn, 'C07', 3);
$tin_nongmang  = getNewsByCategory($conn, 'C08', 5);
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tin Tức - Báo Mới</title>
    <link rel="stylesheet" href="../css/fonts.css" />
    <link rel="stylesheet" href="../css/styleprj.css" />
    <link rel="stylesheet" href="../css/Tin_tuc.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <style>
      .user-nav { display: flex; align-items: center; gap: 15px; margin-left: auto; color: #333; }
      .user-nav span { font-weight: bold; color: #2c3e50; }
      .user-nav a.btn-login { color: white; text-decoration: none; font-weight: bold; background: #e74c3c; padding: 5px 15px; border-radius: 20px; }
      .user-nav a.btn-login:hover { background: #c0392b; }
      .user-nav .logout-btn { background: #7f8c8d; color: white; padding: 5px 15px; border-radius: 20px; text-decoration: none; font-weight: bold;}
      .user-nav .logout-btn:hover { background: #95a5a6; }
      
      .img-link { display: block; width: 100%; height: 100%; }
      .img-link img { width: 100%; height: 100%; object-fit: cover; display: block; }
      
      .news-link-black { color: inherit; text-decoration: none; transition: 0.2s; }
      .news-link-black:hover { color: #d32f2f; }
    </style>
  </head>

  <body>
    <div class="wrapper">
      <header>
        <h1>Báo Mới</h1>
        <form action="search.php" method="GET" class="search-box">
          <input type="text" name="keyword" placeholder="Tìm kiếm..." required />
          <button type="submit">Find</button>
        </form>
        <div class="logo"><img src="../img/logo.png" alt="Logo" /></div>
      </header>

      <nav>
        <div class="nav-container">
          <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
          </button>
          <ul class="nav-menu" id="nav-menu">
            <li><a href="./Trang_chu.php">Trang chủ</a></li>
            <li><a href="./Gioi_thieu.php">Giới thiệu</a></li>
            <li><a href="./Tin_tuc.php" class="active">Tin tức</a></li>
            <li><a href="./The_thao.php">Thể thao</a></li>
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
                <a href="login.php" class="btn-login">Đăng nhập</a>
            <?php } ?>
          </div>
          <button id="switch-mode" style="margin-left: 15px;"><i class="bi bi-moon-stars-fill"></i></button>
        </div>
      </nav>

      <div class="sub-nav">
        <div class="sub-nav-inner">
          <div class="sub-nav-label">Tin tức</div>
          <ul>
            <li class="active"><a href="#" data-section="trong-ngay">Tin tức trong ngày</a></li>
            <li><a href="#" data-section="chinh-tri">Chính trị - Xã hội</a></li>
            <li><a href="#" data-section="doi-song">Đời sống - Dân sinh</a></li>
            <li><a href="#" data-section="giao-thong">Giao thông Đô thị</a></li>
            <li><a href="#" data-section="nong-mang">Nóng trên mạng</a></li>
          </ul>
        </div>
      </div>

      <div class="ticker-bar">
        <div class="ticker-label">Nóng</div>
        <div class="ticker-track">
          <div class="ticker-inner">
            <?php foreach($tin_trongngay as $tick): ?>
                <span><a href="Chi_tiet_tin.php?id=<?= $tick['NEWS_ID'] ?>" style="color:white; text-decoration:none;"><?= $tick['NEWS_NAME'] ?></a></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="page-wrapper">
        <main>
          <div class="page-wrap">

            <section id="trong-ngay" class="content-section active">
              <div class="section-head"><h2>Tin tức trong ngày</h2><div class="head-line"></div></div>
              <div class="section-body-with-sidebar">
                <div class="main-content">
                  <div class="hero-grid">
                    <?php if(isset($tin_trongngay[0])): $n0 = $tin_trongngay[0]; ?>
                    <div class="hero-main">
  <div class="img-wrap" style="position: relative;">
    
    <a href="Chi_tiet_tin.php?id=<?= $n0['NEWS_ID'] ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10;"></a>
    
    <img src="<?= $n0['NEWS_URL'] ?>" alt="tin tức" style="width: 100%; height: 100%; object-fit: cover;" />
    
  </div>
  
  <div class="card-body">
    <span class="card-tag">Tin nóng</span>
    <h2 class="card-title">
      <a href="Chi_tiet_tin.php?id=<?= $n0['NEWS_ID'] ?>" class="news-link-black" style="position: relative; z-index: 11;"><?= $n0['NEWS_NAME'] ?></a>
    </h2>
    <div class="card-meta"><span>Phóng viên &nbsp;|&nbsp; <?= date('d/m/Y', strtotime($n0['NGAYDANG'])) ?></span></div>
  </div>
</div>
                    <?php endif; ?>

                    <?php if(isset($tin_trongngay[1])): $n1 = $tin_trongngay[1]; ?>
                    <div class="hero-side-top">
                      <div class="thumb thumb-1">
                        <a href="Chi_tiet_tin.php?id=<?= $n1['NEWS_ID'] ?>" class="img-link"><img src="<?= $n1['NEWS_URL'] ?>" alt="" /></a>
                      </div>
                      <div class="info">
                        <span class="card-tag-sm">Xã hội</span>
                        <p class="card-title-sm"><a href="Chi_tiet_tin.php?id=<?= $n1['NEWS_ID'] ?>" class="news-link-black"><?= $n1['NEWS_NAME'] ?></a></p>
                      </div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($tin_trongngay[2])): $n2 = $tin_trongngay[2]; ?>
                    <div class="hero-side-bot">
                      <div class="thumb thumb-1">
                        <a href="Chi_tiet_tin.php?id=<?= $n2['NEWS_ID'] ?>" class="img-link"><img src="<?= $n2['NEWS_URL'] ?>" alt="" /></a>
                      </div>
                      <div class="info">
                        <span class="card-tag-sm">Kinh tế</span>
                        <p class="card-title-sm"><a href="Chi_tiet_tin.php?id=<?= $n2['NEWS_ID'] ?>" class="news-link-black"><?= $n2['NEWS_NAME'] ?></a></p>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>

                  <div class="news-grid-4">
                    <?php for($i = 3; $i < count($tin_trongngay); $i++): $n = $tin_trongngay[$i]; ?>
                    <div class="news-card">
                      <div class="thumb thumb-2">
                        <a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="img-link"><img src="<?= $n['NEWS_URL'] ?>" alt="" /></a>
                      </div>
                      <div class="card-body">
                        <div class="card-tag">Sự kiện</div>
                        <h3 class="card-title"><a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="news-link-black"><?= $n['NEWS_NAME'] ?></a></h3>
                        <div class="card-desc"><?= mb_substr($n['NOIDUNG'], 0, 80) ?>...</div>
                      </div>
                    </div>
                    <?php endfor; ?>
                  </div>
                </div>
                
                <aside class="sidebar">
                  <div class="sidebar-box">
                    <h3>Tin nổi bật hôm nay</h3>
                    <?php for($i=0; $i<4; $i++): if(isset($tin_trongngay[$i])) { $s = $tin_trongngay[$i]; ?>
                    <div class="sidebar-news-item">
                      <span class="num"><?= $i+1 ?></span>
                      <div><div class="title"><a href="Chi_tiet_tin.php?id=<?= $s['NEWS_ID'] ?>" class="news-link-black"><?= $s['NEWS_NAME'] ?></a></div></div>
                    </div>
                    <?php } endfor; ?>
                  </div>
                  <div class="sidebar-box">
                    <h3>Chủ đề nổi bật</h3>
                    <div class="tag-cloud"><a href="#">Kinh tế</a><a href="#">Y tế</a><a href="#">Giáo dục</a><a href="#">Xã hội</a></div>
                  </div>
                </aside>
              </div>
            </section>

            <section id="chinh-tri" class="content-section">
              <div class="section-head"><h2>Chính trị - Xã hội</h2><div class="head-line"></div></div>
              <div class="section-body-with-sidebar">
                <div class="main-content">
                  <div class="featured-list">
                    <?php foreach($tin_chinhtri as $index => $n): $isBig = ($index == 0) ? 'big' : ''; ?>
                    <div class="featured-card <?= $isBig ?>">
                      <div class="thumb <?= ($index == 0) ? 'thumb-3' : 'thumb-4' ?>">
                        <a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="img-link"><img src="<?= $n['NEWS_URL'] ?>" alt="" /></a>
                      </div>
                      <div class="info">
                        <span class="card-tag-sm">Chính trị</span>
                        <h3 class="card-title"><a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="news-link-black"><?= $n['NEWS_NAME'] ?></a></h3>
                        <p class="card-desc"><?= mb_substr($n['NOIDUNG'], 0, 120) ?>...</p>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <aside class="sidebar">
                  <div class="sidebar-box">
                    <h3>Tin chính trị hôm nay</h3>
                    <?php for($i=0; $i<3; $i++): if(isset($tin_chinhtri[$i])) { $s = $tin_chinhtri[$i]; ?>
                    <div class="sidebar-news-item">
                      <span class="num"><?= $i+1 ?></span>
                      <div><div class="title"><a href="Chi_tiet_tin.php?id=<?= $s['NEWS_ID'] ?>" class="news-link-black"><?= $s['NEWS_NAME'] ?></a></div></div>
                    </div>
                    <?php } endfor; ?>
                  </div>
                  <div class="sidebar-box">
                    <h3>Chủ đề nổi bật</h3>
                    <div class="tag-cloud"><a href="#">Luật Đất đai</a><a href="#">Bầu cử</a><a href="#">Ngoại giao</a></div>
                  </div>
                </aside>
              </div>
            </section>

            <section id="doi-song" class="content-section">
              <div class="section-head"><h2>Đời sống - Dân sinh</h2><div class="head-line"></div></div>
              <div class="section-body-with-sidebar">
                <div class="main-content">
                  <div class="news-grid-3">
                    <?php foreach($tin_doisong as $n): ?>
                    <div class="news-card">
                      <div class="thumb thumb-2">
                        <a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="img-link"><img src="<?= $n['NEWS_URL'] ?>" alt="" /></a>
                      </div>
                      <div class="card-body">
                        <div class="card-tag">Đời sống</div>
                        <h3 class="card-title"><a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="news-link-black"><?= $n['NEWS_NAME'] ?></a></h3>
                        <div class="card-desc"><?= mb_substr($n['NOIDUNG'], 0, 80) ?>...</div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <aside class="sidebar">
                  <div class="sidebar-box">
                    <h3>Tin đời sống hôm nay</h3>
                    <?php for($i=0; $i<3; $i++): if(isset($tin_doisong[$i])) { $s = $tin_doisong[$i]; ?>
                    <div class="sidebar-news-item">
                      <span class="num"><?= $i+1 ?></span>
                      <div><div class="title"><a href="Chi_tiet_tin.php?id=<?= $s['NEWS_ID'] ?>" class="news-link-black"><?= $s['NEWS_NAME'] ?></a></div></div>
                    </div>
                    <?php } endfor; ?>
                  </div>
                  <div class="sidebar-box">
                    <h3>Chủ đề đời sống</h3>
                    <div class="tag-cloud"><a href="#">Sức khoẻ</a><a href="#">Nhà ở</a><a href="#">Ẩm thực</a><a href="#">Lao động</a></div>
                  </div>
                </aside>
              </div>
            </section>

            <section id="giao-thong" class="content-section">
              <div class="section-head"><h2>Giao thông - Đô thị</h2><div class="head-line"></div></div>
              <div class="section-body-with-sidebar">
                <div class="main-content">
                  <div class="featured-list">
                    <?php foreach($tin_giaothong as $index => $n): $isBig = ($index == 0) ? 'big' : ''; ?>
                    <div class="featured-card <?= $isBig ?>">
                      <div class="thumb <?= ($index == 0) ? 'thumb-3' : 'thumb-4' ?>">
                        <a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="img-link"><img src="<?= $n['NEWS_URL'] ?>" alt="" /></a>
                      </div>
                      <div class="info">
                        <span class="card-tag-sm">Đô thị</span>
                        <h3 class="card-title"><a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="news-link-black"><?= $n['NEWS_NAME'] ?></a></h3>
                        <p class="card-desc"><?= mb_substr($n['NOIDUNG'], 0, 120) ?>...</p>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <aside class="sidebar">
                  <div class="sidebar-box">
                    <h3>Dự báo giao thông</h3>
                    <p class="sidebar-note"><strong>Hà Nội:</strong> Đường Nguyễn Trãi, Cầu Giấy dự kiến ùn tắc.</p>
                    <p class="sidebar-note"><strong>TP.HCM:</strong> Ngã tư Hàng Xanh có công trình thi công.</p>
                    <p class="sidebar-note"><strong>Đà Nẵng:</strong> Giao thông thông thoáng.</p>
                  </div>
                  <div class="sidebar-box">
                    <h3>Tin giao thông hôm nay</h3>
                    <?php for($i=0; $i<3; $i++): if(isset($tin_giaothong[$i])) { $s = $tin_giaothong[$i]; ?>
                    <div class="sidebar-news-item">
                      <span class="num"><?= $i+1 ?></span>
                      <div><div class="title"><a href="Chi_tiet_tin.php?id=<?= $s['NEWS_ID'] ?>" class="news-link-black"><?= $s['NEWS_NAME'] ?></a></div></div>
                    </div>
                    <?php } endfor; ?>
                  </div>
                </aside>
              </div>
            </section>

            <section id="nong-mang" class="content-section">
              <div class="section-head"><h2>Nóng trên mạng</h2><div class="head-line"></div></div>
              <div class="section-body-with-sidebar">
                <div class="main-content">
                  <div class="nong-grid">
                    <?php if(isset($tin_nongmang[0])): $n0 = $tin_nongmang[0]; ?>
                    <div class="nong-main">
                      <div class="thumb thumb-5">
                        <a href="Chi_tiet_tin.php?id=<?= $n0['NEWS_ID'] ?>" class="img-link"><img src="<?= $n0['NEWS_URL'] ?>" alt="" /></a>
                      </div>
                      <div class="body">
                        <span class="viral-badge">Viral</span>
                        <h3 class="card-title"><a href="Chi_tiet_tin.php?id=<?= $n0['NEWS_ID'] ?>" class="news-link-black"><?= $n0['NEWS_NAME'] ?></a></h3>
                        <p class="card-desc"><?= mb_substr($n0['NOIDUNG'], 0, 100) ?>...</p>
                      </div>
                    </div>
                    <?php endif; ?>

                    <?php for($i = 1; $i < count($tin_nongmang); $i++): $n = $tin_nongmang[$i]; ?>
                    <div class="nong-side-card">
                      <div class="thumb thumb-6">
                        <a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="img-link"><img src="<?= $n['NEWS_URL'] ?>" alt="" /></a>
                      </div>
                      <div class="info">
                        <span class="card-tag-sm">Trend</span>
                        <p class="card-title"><a href="Chi_tiet_tin.php?id=<?= $n['NEWS_ID'] ?>" class="news-link-black"><?= $n['NEWS_NAME'] ?></a></p>
                      </div>
                    </div>
                    <?php endfor; ?>
                  </div>
                  <div class="load-more-wrap">
                    <button class="btn-load">Xem thêm tin nóng</button>
                  </div>
                </div>
                <aside class="sidebar">
                  <div class="sidebar-box">
                    <h3>Trending hôm nay</h3>
                    <?php for($i=0; $i<3; $i++): if(isset($tin_nongmang[$i])) { $s = $tin_nongmang[$i]; ?>
                    <div class="sidebar-news-item">
                      <span class="num"><?= $i+1 ?></span>
                      <div><div class="title"><a href="Chi_tiet_tin.php?id=<?= $s['NEWS_ID'] ?>" class="news-link-black"><?= $s['NEWS_NAME'] ?></a></div></div>
                    </div>
                    <?php } endfor; ?>
                  </div>
                  <div class="sidebar-box">
                    <h3>Hashtag nổi bật</h3>
                    <div class="tag-cloud"><a href="#">#CơmNhàNgon</a><a href="#">#ViralVN</a><a href="#">#TốtĐời</a></div>
                  </div>
                </aside>
              </div>
            </section>

          </div>
        </main>
      </div>

      <footer class="site-footer">
        <div class="footer-top">
          <div class="footer-brand">
            <h2>Báo Mới</h2>
            <p>Cập nhật tin tức nhanh, chính xác và khách quan. Đồng hành cùng bạn mỗi ngày.</p>
            <div class="footer-social">
              <a href="#" title="Facebook">Fb</a><a href="#" title="YouTube">Ytb</a>
              <a href="#" title="TikTok">Tik</a><a href="#" title="Zalo">Zalo</a>
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
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <span>&copy; 2026 Báo Mới. All rights reserved.</span>
          <span><a href="#">Điều khoản</a> &nbsp;·&nbsp; <a href="#">Bảo mật</a></span>
        </div>
      </footer>
    </div>

    <script src="../javascript/Tin_tuc.js"></script>
    <script src="../javascript/tha_tym.js"></script>
    <script src="../javascript/light_dark_mode.js"></script>
    <script src="../javascript/menu_hide_show.js"></script>
    <script src="../javascript/search_filter.js"></script>
  </body>
</html>