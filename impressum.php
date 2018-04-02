<?
include 'connection.php';

$userid = $_GET['id'];
$query = mysql_query("SELECT * FROM users WHERE id=$userid");
$user = mysql_fetch_assoc($query);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <div style="padding:10px; font-family:calibri,helvetica,verdana; line-height:20px">
            <img src="<?echo $user[logo_url]?>" style="max-height:200px; max-width:200px"/>
            <p><?echo $user[impressum]?></p>
        </div>
    </body>
</html>

<style type="text/css">
    div a{
        color:#E32636;
    }
</style>