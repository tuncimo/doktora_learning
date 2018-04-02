<?
session_start();
ob_start();
$ref = $_SERVER['HTTP_REFERER'];
include 'connection.php';
include_once 'common.php';
include 'format_date.php';

$query = mysql_query("SELECT * FROM property WHERE users_id=18");
while($row = mysql_fetch_assoc($query)) {
    $property[] = $row;
}
if($_GET[admin_delete] == "yes") {
    $prop_id = $_GET[pid];
    mysql_query("DELETE FROM property_has_detail WHERE property_id=$prop_id");
    $query = mysql_query("SELECT * FROM photos where property_id=$prop_id");
    while($row = mysql_fetch_assoc($query)) unlink($row[url]);
    $query = mysql_query("SELECT * FROM videos where property_id=$prop_id");
    while($row = mysql_fetch_assoc($query)) unlink($row[url]);

    mysql_query("DELETE FROM photos WHERE property_id=$prop_id");
    mysql_query("DELETE FROM videos WHERE property_id=$prop_id");
    mysql_query("DELETE FROM property WHERE id=$prop_id");

    header("location:$ref");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo ADS_GIVEN_BY_TDB?></title>
        <link rel="stylesheet" type="text/css"  href="stylesheets/gray_table.css"/>
        <link rel="stylesheet" type="text/css"  href="stylesheets/form.css"/>
    </head>
    <body>
        <?php
        if ($_SESSION[username] != "TDB Immobilien GmbH") {
            echo "<h3>".YOURE_NOT_AUTHORIZED."<h3>";
        }
        else {
        ?>
        <center>
            <div id="admin_submission_content">
                <div class="form-header-group">
                    <h2 class="form-header"><?echo ALL_ADS?></h2>
                </div>
                <div id="submission_ads">
                    <? if(count($property) > 0) { ?>
                    <table width="100%">
                        <tr>
                            <th style="width:70px"><?echo PHOTOS?></th>
                            <th><?echo CATEGORY;?></th>
                            <th><?echo TITLE;?></th>
                            <th><?echo NUMBER_OF_ROOMS;?></th>
                            <th><?echo LIVING_SPACE;?></th>
                            <th><?echo PRICE;?></th>
                            <th><?echo AD_DATE;?></th>
                            <th><?echo CITY;?></th>
                            <th><?echo VIEW?></th>
                            <th><?echo MODIFY?></th>
                            <th><?echo DELETE?></th>
                        </tr>
                        <?foreach($property as $p) {
                        $query = mysql_query("SELECT url FROM photos WHERE property_id=$p[id]");
                        $photo = mysql_fetch_assoc($query);
                        if($photo[url] == null) $photo[url] = "resimler/icons/cam.png"
                        ?>
                        <tr>
                            <td style="padding:2px"><img src="<?print($photo[url])?>" style="width:80px" /></td>
                            <td><?print(constant($p[category])." ".constant($p[property_subcategory]))?></td>
                            <td><?print($p[title])?></td>
                            <td><?print($p[nb_rooms])?></td>
                            <td><?print($p[living_space])?>m<sup>2</sup></td>
                            <td><?print(number_format($p[price],2,',','.')." €")?></td>
                            <td><?print(format_date($p[ad_date]))?></td>
                            <td><?print($p[city])?></td>
                            <td><a href="ad.php?id=<?print($p[id])?>"><?echo VIEW?></a></td>
                            <td><a href="myaccount.php?lin=pedit&pid=<?echo $p[id]?>"><?echo MODIFY?></a></td>
                            <td><a href="?admin_delete=yes&pid=<?echo $p[id]?>" onclick="return admin_delete()"><?echo DELETE?></a></td>
                        </tr>
                        <?}?>
                    </table>
                    <? } else echo "<h3 style='text-align:center'>".NO_ADVERTISEMENTS."</h3>" ?>
                </div>
            </div>
        </center>
        <?
        }
        ?>
    </body>
</html>

<?

ob_end_flush();
?>

<style type="text/css">
    #admin_submission_content {
        font-family:calibri,helvetica,verdana;
    }
</style>

<script type="text/javascript">
    function admin_delete(){
        var response=window.prompt("Bitte Passwort eingeben!")
        if(response == "admin") return true;
        else {
            alert("Kennwort falsch");
            return false;
        }
    }
</script>