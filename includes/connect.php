<?php
$host = "localhost";
$user = "root";      // Tên người dùng mặc định của XAMPP là root
$pass = "";          // Mật khẩu mặc định của XAMPP thường là để trống
$db   = "prj_nhom_5";  // Tên Database mà ông vừa tạo trong phpMyAdmin

// 1. Tạo kết nối
$conn = mysqli_connect($host, $user, $pass, $db);

// 2. Kiểm tra xem kết nối có sống không
if (!$conn) {
    // Nếu chết thì báo lỗi và dừng web luôn
    die("Kết nối Database thất bại: " . mysqli_connect_error());
}

// 3. Quan trọng nhất: Thiết lập font tiếng Việt
// Không có dòng này là lát nữa tên tin tức hiện lên toàn dấu hỏi chấm ??? đấy
mysqli_set_charset($conn, "utf8mb4");

// Lưu ý: Đừng viết gì thêm ở dưới này nếu ông định dùng include
?>