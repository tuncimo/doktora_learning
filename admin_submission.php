<?
ob_start();
$ref = $_SERVER['HTTP_REFERER'];
include 'connection.php';
include_once 'common.php';
include 'format_date.php';

$query = mysql_query("SELECT * FROM property WHERE approved=0");
while($row = mysql_fetch_assoc($query)) {
    $property[] = $row;
}
$query = mysql_query("SELECT * FROM property WHERE updated=1");
while($row = mysql_fetch_assoc($query)) {
    $uproperty[] = $row;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo AD_APPROVAL?></title>
        <link rel="stylesheet" type="text/css"  href="stylesheets/gray_table.css"/>
        <link rel="stylesheet" type="text/css"  href="stylesheets/form.css"/>
    </head>
    <body>
        <?php
        if ($ref != "http://www.tdb-immo.de/tdb_web/admin.php" && $ref != "http://www.tdb-immo.de/tdb_web/admin_submission.php") {
            echo "<h3>".YOURE_NOT_AUTHORIZED."<h3>";
        }
        else {
        ?>
        <center>
            <div id="admin_submission_content">
                <div class="form-header-group">
                    <h2 class="form-header"><?echo ADS_PENDING;?></h2>
                </div>
                <div id="submission_ads">
                    <? if(count($property) > 0) { ?>
                    <table width="100%">
                        <tr>
                            <th style="width:70px"><?echo PHOTO?></th>
                            <th><?echo CATEGORY?></th>
                            <th><?echo TITLE?></th>
                            <th><?echo NUMBER_OF_ROOMS?></th>
                            <th><?echo NUMBER_OF_BATHROOMS?></th>
                            <th><?echo PRICE?></th>
                            <th><?echo AD_DATE?></th>
                            <th><?echo CITY?></th>
                            <th><?echo VIEW?></th>
                            <th><?echo DO_YOU_APPROVE?></th>
                        </tr>
                        <?foreach($property as $p) {
                        $query = mysql_query("SELECT url FROM photos WHERE property_id=$p[id]");
                        $photo = mysql_fetch_assoc($query);
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
                            <td>
                                <form action="" method="post">
                                    <input type="submit" value="<?echo YES?>" name="yes"/>&nbsp;&nbsp;&nbsp;
                                    <input type="submit" value="<?echo NO?>" name="no"/>
                                    <input type="hidden" value="<?print ($p[id])?>" name="pid" />
                                </form>
                            </td>
                        </tr>
                        <?}?>
                    </table>
                    <? } else echo "<h3 style='text-align:center'>".NO_PENDING_ADS."</h3>" ?>
                </div>
                <div class="form-header-group">
                    <h2 class="form-header"><?echo MODIFIED_ADS?></h2>
                </div>
                <div id="submission_ads">
                    <? if(count($uproperty) > 0) { ?>
                    <table width="100%">
                        <tr>
                            <th style="width:70px"><?echo PHOTO?></th>
                            <th><?echo CATEGORY?></th>
                            <th><?echo TITLE?></th>
                            <th><?echo NUMBER_OF_ROOMS?></th>
                            <th><?echo NUMBER_OF_BATHROOMS?></th>
                            <th><?echo PRICE?></th>
                            <th><?echo AD_DATE?></th>
                            <th><?echo CITY?></th>
                            <th><?echo VIEW?></th>
                            <th><?echo DO_YOU_APPROVE?></th>
                        </tr>
                        <?foreach($uproperty as $p) {
                        $query = mysql_query("SELECT url FROM photos WHERE property_id=$p[id]");
                        $photo = mysql_fetch_assoc($query);

                        $doc = new DOMDocument();
                        $doc->load( 'xml_data/'.$p[id].'.xml');

                        $xtitle = $doc->getElementsByTagName("title")->item(0)->nodeValue;
                        $xtype = $doc->getElementsByTagName("type")->item(0)->nodeValue;
						$xsecrecy = $doc->getElementsByTagName("secrecy")->item(0)->nodeValue;
                        $xdescription = $doc->getElementsByTagName("description")->item(0)->nodeValue;
                        $xlocation = $doc->getElementsByTagName("location")->item(0)->nodeValue;
                        $xequipment = $doc->getElementsByTagName("equipment")->item(0)->nodeValue;
                        $xother = $doc->getElementsByTagName("other")->item(0)->nodeValue;
                        $xnb_bathrooms = $doc->getElementsByTagName("nb_bathrooms")->item(0)->nodeValue;
                        $xnb_rooms = $doc->getElementsByTagName("nb_rooms")->item(0)->nodeValue;
                        $xfloor = $doc->getElementsByTagName("floor")->item(0)->nodeValue;
                        $xliving_space = $doc->getElementsByTagName("living_space")->item(0)->nodeValue;
                        $xheating = $doc->getElementsByTagName("heating")->item(0)->nodeValue;
                        $xprice = $doc->getElementsByTagName("price")->item(0)->nodeValue;
						$xcommission = $doc->getElementsByTagName("commission")->item(0)->nodeValue;
                        $xdeposit = $doc->getElementsByTagName("deposit")->item(0)->nodeValue;
                        $xcharges = $doc->getElementsByTagName("charges")->item(0)->nodeValue;


                        ?>
                        <tr>
                            <td style="padding:2px"><img src="<?print($photo[url])?>" style="width:80px" /></td>
                            <td><?print(constant($p[category])." ".constant($p[property_subcategory]))?></td>
                            <td><?print($p[title])?></td>
                            <td><?print($p[nb_rooms])?>
                                <table id="<?echo $p[id]?>" style="width:500px; height:auto; border:1px solid gray; background-color:white; display:none; position:absolute; margin-left:0px; margin-top:10px">
                                    <tr><td colspan="2" align="center"><h1><?echo MODIFIED?></h1></td></tr>
                                    <?if ($p[title] != $xtitle) echo "<tr><td>".TITLE."</td><td>".$xtitle."</td></tr>"?>
                                    <?if ($p[category] != $xtype) echo "<tr><td>".CATEGORY."</td><td>".constant($xtype)."</td></tr>"?>
									<?if ($p[address_sec] != $xsecrecy) echo "<tr><td>".HIDE_ADDRESS."</td><td>".$xsecrecy."</td></tr>"?>
                                    <?if ($p[description] != $xdescription) echo "<tr><td>".DESCRIPTION."</td><td>".$xdescription."</td></tr>"?>
                                    <?if ($p[location] != $xlocation) echo "<tr><td>".LOCATION."</td><td>".$xlocation."</td></tr>"?>
                                    <?if ($p[equipment] != $xequipment) echo "<tr><td>".FURNITURE."</td><td>".$xequipment."</td></tr>"?>
                                    <?if ($p[other] != $xother) echo "<tr><td>".OTHER."</td><td>".$xother."</td></tr>"?>
                                    <?if ($p[nb_bathrooms] != $xnb_bathrooms) echo "<tr><td>".NUMBER_OF_BATHROOMS."</td><td>".$xnb_bathrooms."</td></tr>"?>
                                    <?if ($p[nb_rooms] != $xnb_rooms) echo "<tr><td>".NUMBER_OF_ROOMS."</td><td>".$xnb_rooms."</td></tr>"?>
                                    <?if ($p[floor] != $xfloor) echo "<tr><td>".FLOOR."</td><td>".$xfloor."</td></tr>"?>
                                    <?if ($p[living_space] != $xliving_space) echo "<tr><td>".LIVING_SPACE."</td><td>".$xliving_space."</td></tr>"?>
                                    <?if ($p[heating] != $xheating) echo "<tr><td>".HEATING."</td><td>".constant($xheating)."</td></tr>"?>
                                    <?if ($p[price] != $xprice) echo "<tr><td>".PRICE."</td><td>".print(number_format($xprice,2,',','.')." €")."</td></tr>"?>
									<?if ($p[commission] != $xcommission) echo "<tr><td>".COMMISSION."</td><td>".print(number_format($xcommission,2,',','.')." €")."</td></tr>"?>
                                    <?if ($p[deposit] != $xdeposit) echo "<tr><td>".DEPOSIT."</td><td>".print(number_format($xdeposit,2,',','.')." €")."</td></tr>"?>
                                    <?if ($p[charges] != $xcharges) echo "<tr><td>".CHARGES."</td><td>".print(number_format($xcharges,2,',','.')." €")."</td></tr>"?>
                                </table>
                            </td>
                            <td><?print($p[living_space])?>m<sup>2</sup></td>
							<td><?print(number_format($p[price],2,',','.')." €")?></td>
                            <td><?print(format_date($p[ad_date]))?></td>
                            <td><?print($p[city])?></td>
                            <td><a href="ad.php?id=<?print($p[id])?>"><?echo VIEW?></a> <a onmouseover="document.getElementById('<?echo $p[id]?>').style.display=''" onmouseout="document.getElementById('<?echo $p[id]?>').style.display='none'"><?echo MODIFIED?></a></td>
                            <td>
                                <form action="" method="post">
                                    <input type="submit" value="<?echo YES?>" name="uyes"/>&nbsp;&nbsp;&nbsp;
                                    <input type="submit" value="<?echo NO?>" name="uno"/>
                                    <input type="hidden" value="<?print ($p[id])?>" name="pid" />
                                </form>
                            </td>
                        </tr>
                        
                        <?}?>
                    </table>
                    <? } else echo "<h3 style='text-align:center'>".NO_MODIFIED_ADS_PENDING."</h3>" ?>
                </div>
            </div>
        </center>
        <?
        }
        ?>
    </body>
</html>

<?
if(isset($_POST['yes'])){
    $pid = $_POST['pid'];

    mysql_query("UPDATE property SET approved=1 WHERE id=$pid");

    header("location: admin_submission.php");
}
if(isset($_POST['no'])){
    $pid = $_POST['pid'];

    mysql_query("DELETE FROM property_has_detail WHERE property_id=$pid");
    $query = mysql_query("SELECT * FROM photos where property_id=$pid");
    while($row = mysql_fetch_assoc($query)) unlink($row[url]);
    $query = mysql_query("SELECT * FROM videos where property_id=$pid");
    while($row = mysql_fetch_assoc($query)) unlink($row[url]);
    mysql_query("DELETE FROM photos WHERE property_id=$pid");
    mysql_query("DELETE FROM videos WHERE property_id=$pid");
    mysql_query("DELETE FROM property WHERE id=$pid");

    header("location: admin_submission.php");
}
if(isset($_POST['uyes'])) {
    $pid = $_POST['pid'];
    mysql_query("UPDATE property SET category='$xtype', title='$xtitle', address_sec='$xsecrecy', description='$xdescription', location='$xlocation',
        equipment='$xequipment', other='$xother', nb_bathrooms='$xnb_bathrooms', nb_rooms='$xnb_rooms', floor='$xfloor',
        living_space='$xliving_space', heating='$xheating', price='$xprice', deposit='$xdeposit', charges='$xcharges', commission='$xcommission', updated=0 WHERE id='$pid'");

    header("location: admin_submission.php");
    
}
if(isset($_POST['uno'])) {
    $pid = $_POST['pid'];
    mysql_query("UPDATE property SET updated=0 WHERE id=$pid");

    header("location: admin_submission.php");
}

ob_end_flush();
?>

<style type="text/css">
    #admin_submission_content {
        font-family:calibri,helvetica,verdana;
    }
</style>