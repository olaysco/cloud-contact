<?php
session_start();

$out = isset($_SESSION['user'])?(function(){session_destroy(); header('location: ../login.php');}):(function(){header('location: ../login.php');});
$out();
?>