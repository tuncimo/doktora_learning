<?php
session_start();
unset ($_SESSION['username']);
unset ($_SESSION['arrayData']);
unset ($_SESSION['id']);
header("location:index.php");
?>
