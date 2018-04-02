<?
session_start();
include 'connection.php';

if(isset ($_GET['pdid'])) $pdid = $_GET['pdid'];
if(isset ($_GET['udid'])) $udid = $_GET['udid'];
if($_SESSION[id] == $udid) {
    $result = mysql_query("INSERT INTO favourites values (null, $udid, $pdid)");
    if (!$result) {
    die('Invalid query: ' . mysql_error());
}
}
else echo "<h1>". YOURE_NOT_AUTHORIZED ."</h1>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>TDB Immobilien GmbH</title>
    </head>
    <body>
        <center>
            <img src="resimler/icons/bookm.png" style="padding-bottom:15px; padding-top:10px"/> <br/>
        <?echo "<span style='font-family:calibri,helvetica,verdana'>Die Immobilie wurde zu Ihren Favoriten hinzugefügt wurde erfolgreich</span>"?>
        </center>
    </body>
</html>
