<?php
session_start();
session_destroy();
header("Location: login_page/login.php");
exit();
?>