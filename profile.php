<?
session_start();

include 'connection.php';
include_once 'common.php';
include_once 'format_date.php';


if (isset ($_GET['comp_id'])) {
    $comp_id = $_GET['comp_id'];
    $query = mysql_query("SELECT * FROM property WHERE users_id=$comp_id");
    while($row = mysql_fetch_assoc($query)){
        $property[] = $row;
    }
    $query = mysql_query("SELECT * FROM users WHERE id=$comp_id");
    $company = mysql_fetch_assoc($query);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo $company[username]?></title>

        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="stylesheet" type="text/css" href="stylesheets/form.css"/>
        <link rel="shortcut icon" type="image/x-icon" href="resimler/hou.ico">
        <link rel="stylesheet" type="text/css"  href="stylesheets/gray_table.css"/>
    </head>
    <body>
        <div id="contain">
            <div class="top_menu">
                <a href="index.php"><img class="img_logo" src="resimler/tdb_logo2.jpg"/></a>
                <div class="menu">
                    <a href="index.php"><?echo MAIN_PAGE;?></a>&nbsp; | &nbsp;
                    <a href="myaccount.php"><?echo MY_ACCOUNT;?></a>&nbsp; | &nbsp;
                    <a href="help.php"><?echo HELP;?></a> <br/>
                    <div style="float:right">
                        <a href="index.php?lang=en"><img src="resimler/en.png"/></a>
                        <a href="index.php?lang=de"><img src="resimler/de.png"/></a>
                        <a href="index.php?lang=tr"><img src="resimler/tr.png"/></a>
                    </div>
                </div>
                <br style="clear:both"/>
            </div>
            <div class="main_menu">
                <ul>
                <li><a href="index.php" title="Home"><?echo MAIN_PAGE; ?></a></li>
                <li><a href="about_us.php" title="Hakkımızda"><?echo ABOUT_US; ?></a></li>
                <li class="current"><a href="ads.php" title=""><?echo ADVERTISEMENTS; ?></a></li>
                <li><a href="service.php" title="Service"><?echo SERVICE; ?></a></li>
                <li><a href="contact.php" title="Kontakt"><?echo CONTACT; ?></a></li>
                <li><a href="new_ad.php" title="İlan Ver"><?echo ADVERTISE; ?></a>
				<li><a href="tdb_impressum.php" title="Impressum"><?echo IMPRESSUM;?></a>
                </ul>
                <form id="generic_search_form" action="http://search.freefind.com/find.html" method="get" accept-charset="utf-8" target="_self">
                    <input type="hidden" name="si" value="82747906">
                    <input type="hidden" name="pid" value="r">
                    <input type="hidden" name="n" value="0">
                    <input type="hidden" name="_charset_" value="">
                    <input type="hidden" name="bcd" value="&#247;">
                    <input name="query" type="text" class="textinput" value="<?echo ENTER_SEARCH_TEXT;?>"
                           onClick="javascript:this.form.query.focus();this.form.query.select()" style="background-color:#EEF0F3"/>
                    <input class="submit" type="submit" value="<?echo SEARCH;?>" />
                </form>
            </div>
            <div id="profile_main_content">
                <div class="form-header-group">
                    <h2 class="form-header"><?echo ADS;?><?print(" - ".$company[username])?></h2>
                </div>
                <? if(count($property) > 0) { ?>
                <table width="100%">
                    <tr>
                        <th><?echo PHOTOS;?></th>
                        <th><?echo CATEGORY;?></th>
                        <th><?echo TITLE;?></th>
                        <th><?echo NUMBER_OF_ROOMS;?></th>
                        <th><?echo LIVING_SPACE;?></th>
                        <th><?echo PRICE;?></th>
                        <th><?echo CITY;?></th>
                        <th><?echo VIEW;?></th>
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
                        <td><?print($p[city])?></td>
                        <td><a href="ad.php?id=<?print($p[id])?>"><?echo VIEW?></a></td>
                    </tr>
                    <?}?>
                </table>
                <? } else echo "<h3 style='padding:10px'>".NO_ADS_BY_THIS_DEALER."</h3>" ?>
            </div>
        </div>
    </body>
</html>
