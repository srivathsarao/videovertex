<?php
session_start();
$_SESSION['admin'] = null;
header('location: index.php');
?>