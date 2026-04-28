<?php
$host = "localhost";
$user = "root";      
$pass = "";        
$db   = "prj_nhom_5";  

// connect
$conn = mysqli_connect($host, $user, $pass, $db);

// kiem tra ket noi
if (!$conn) {
    // ket noi that bai
    die("Kết nối Database thất bại: " . mysqli_connect_error());
}

// thiet lap font tieng viet, neu ko co the loi (???)
mysqli_set_charset($conn, "utf8mb4");

?>