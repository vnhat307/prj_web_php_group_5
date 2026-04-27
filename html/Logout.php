<?php
session_start();
session_destroy();
header("Location: Trang_chu.php");
exit;
?>