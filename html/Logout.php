<?php // xử lý đăng xuất tài khoản, hủy session và chuyển về trang chủ
session_start();
session_destroy();
header("Location: Trang_chu.php");
exit;
?>