<?
    include 'connection.php';
    include_once 'common.php';
    
    if(isset($_GET['nid'])) {
        $nid = $_GET['nid'];
        $query = mysql_query("SELECT * FROM news WHERE id=$nid");
        $news = mysql_fetch_assoc($query);
    }
    else {
        $query = mysql_query("SELECT * FROM news ORDER BY id desc LIMIT 0,5");
        while($row = mysql_fetch_assoc($query))
            $news[] = $row;
    }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><? echo NEWS; ?></title>
    </head>
    <body>
        <?php if($nid != null) { ?>
            <h3> <? echo $news[header] ?></h3>
            <p> <? echo $news[text] ?></p>
            <a href="news.php"><?echo VIEW_ALL_NEWS;?></a>
        <? } else { ?>
            <? foreach ($news as $n) { ?>
            <h3><?echo $n[header]?></h3>
            <p><?echo $n[text]?></p>
        <? } } ?>
    </body>
</html>

<style type="text/css">
    body {
        padding:5px;
        text-align:justify;
    }
</style>
