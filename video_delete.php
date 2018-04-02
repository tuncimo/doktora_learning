<?php
ob_start();
include 'connection.php';

$ref = $_SERVER['HTTP_REFERER'];
$vid = $_POST['previd'];

$query = mysql_query("SELECT * FROM videos where id=$vid");
while($row = mysql_fetch_assoc($query)) unlink("jwplayer/".$row[url]);

mysql_query("DELETE FROM videos WHERE id=$vid");
header("location:$ref");

?>
