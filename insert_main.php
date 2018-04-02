<?php
        session_start();
        ob_start();
        include_once 'connection.php';
        include_once 'common.php';

        if(isset ($_GET['insert'])) $insert = $_GET['insert'];
        if(isset ($_GET['i'])) $process = $_GET['i'];
        if($process == "main") {
            $query = mysql_query("SELECT * FROM photos WHERE property_id=$insert");
            while($row = mysql_fetch_assoc($query)) {
                $ph[] = $row;
            }
        }
        if ($process == "delete") {
            $query = mysql_query("SELECT * FROM photos WHERE id=$insert");
            $ph = mysql_fetch_assoc($query);
        }
        if ($process == "sure") {
            if(isset ($_GET['p'])) $pid = $_GET['p'];
            $query_u = mysql_query("SELECT * FROM photos WHERE id=$insert");
            $phd = mysql_fetch_assoc($query_u);
            unlink($phd[url]);
            $query = mysql_query("DELETE FROM photos WHERE id=$insert");
            header("location:insert_main.php?insert=$pid&i=main");
        }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <? if($process == "main") { ?>
        <center>
        <div id="insert_main">
            <h3><?echo YOU_ARE_VIEWING_PHOTOS_OF_THIS_PROPERTY;?></h3>
            <? if(count($ph) == 0) { ?>
            <h3><?echo NO_PHOTOS_ADDED_YET;?></h3>
            <? } else { ?>
            <h3><?echo PHOTO_BIGGER_PHOTO_DELETE;?></h3>
            <?foreach($ph as $p) {?>
            <a href="insert_main.php?insert=<?print($p[id])?>&i=delete"><img style="border:none" height="80px" src="<?print($p[url])?>"/></a>
            <? } } ?>
        </div>
        </center>
        <a href="insert_image.php?insert=<?print($insert)?>"><p> <img src="resimler/icons/camera_photo.png" /> <br/> <?echo ADD_NEW_PHOTOS;?> </p></a>
        <? } if($process == "delete") {?>
        <div style="width:790px">
            <center><img height="450px" src="<?print($ph[url])?>" style="padding-top:30px; max-width:700px"></center>
            <p>
                <a href="insert_main.php?insert=<?print ($ph[property_id])?>&i=main"><?echo BACK;?></a> &nbsp;&nbsp;&nbsp;
                <a href="insert_main.php?insert=<?print ($insert)?>&i=sure&p=<?print ($ph[property_id])?>" onclick="return confirm('Emin Misiniz?')"><?echo DELETE;?></a>
            </p>
        </div>
        <? } ?>
    </body>
</html>

<style type="text/css">
    body {
        font-family:calibri,helvetica,verdana;
    }

    a:link {
        text-decoration:none;
        color:black;
    }
    a:hover {
        text-decoration:underline;
    }
    a:visited {
        color:black;
        text-decoration:none;
    }
    a:visited:hover {
        text-decoration:underline;
    }
    h3 {
        text-align:center;
        font-weight:normal;
    }
    p {
        padding-top:30px;
        text-align:center;
    }
    img {
        border:none;
    }
    #insert_main {
        width:780px; 
        height:auto;
        max-height:295px;
        border-bottom:2px solid;
        overflow:hidden;
        padding-bottom:3px;
    }
</style>