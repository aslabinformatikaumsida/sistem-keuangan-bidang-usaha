<?php
session_start();
session_unset();
session_destroy();

// Redirect user ke halaman login atau halaman lain setelah logout
header("Location: index.php");
exit();
?>