<?php
        session_start();
        if(isset($_SESSION[username])) {
            $user_signed_in = true;
        }
        else {
            $user_signed_in = false;
        }
        include_once 'connection.php';
        include_once 'common.php';
        include_once 'format_date.php';
        

        $property_id = $_GET['id'];
        $query = mysql_query("SELECT * FROM property WHERE id=$property_id");
        $property = mysql_fetch_assoc($query);
        $property_owner = $property[users_id];

        $query = mysql_query("SELECT * FROM photos WHERE property_id=$property_id");
        while ($row = mysql_fetch_assoc($query))
            $photos[] = $row;

        $query = mysql_query("SELECT * FROM users WHERE id='$property_owner'");
        $user = mysql_fetch_assoc($query);

        $query = mysql_query("SELECT detail_id FROM property_has_detail WHERE property_id=$property_id");
        while ($row = mysql_fetch_assoc($query)) {
            $query2 = mysql_query("SELECT * FROM detail WHERE id='$row[detail_id]'");
            $detail = mysql_fetch_assoc($query2);
            $type = $detail[type];
            if($type == "İç Özellikler") $ic_ozellik[] = $detail[description];
            if($type == "Dış Özellikler") $dis_ozellik[] = $detail[description];
            if($type == "Ulaşım") $ulasim[] = $detail[description];
            if($type == "Manzara") $manzara[] = $detail[description];
            if($type == "Konut Tipi") $konut_tipi[] = $detail[description];
            if($type == "Cephe") $cephe[] = $detail[description];
        }
        if($user_signed_in) {
            $query = mysql_query("SELECT * FROM favourites WHERE property_id=$property_id AND users_id=$_SESSION[id]");
            if(mysql_num_rows($query)) $fav = true;
        }

        $query = mysql_query("SELECT * FROM videos WHERE property_id=$property_id");
        $video = mysql_fetch_assoc($query);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo ADVERTISEMENT;?> - TDB Immobilien GmbH</title>

        <script type="text/javascript">
            var GB_ROOT_DIR = "greybox/greybox/";
        </script>

        <script type="text/javascript" src="flowplayer/flowplayer-3.2.0.min.js"></script>
        <script type="text/javascript" src="greybox/greybox/AJS.js"></script>
        <script type="text/javascript" src="greybox/greybox/AJS_fx.js"></script>
        <script type="text/javascript" src="greybox/greybox/gb_scripts.js"></script>
        <link href="greybox/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="shortcut icon" type="image/x-icon" href="resimler/hou.ico">
        <link rel="stylesheet" type="text/css"  href="stylesheets/form.css"/>
    </head>
    <body onload="document.getElementById('big_image').style.maxHeight = document.getElementById('big_image').height;
                  document.getElementById('big_image').style.minHeight = document.getElementById('big_image').height;">
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
                <br style="clear:both" />
            </div>
            <div class="main_menu">
                <ul>
                <li><a href="index.php"><?echo MAIN_PAGE; ?></a></li>
                <li><a href="about_us.php"><?echo ABOUT_US_HEADER; ?></a></li>
                <li class="current"><a href="ads.php"><?echo ADVERTISEMENTS; ?></a></li>
                <li><a href="service.php"><?echo SERVICE; ?></a></li>
                <li><a href="contact.php"><?echo CONTACT; ?></a></li>
                <li><a href="new_ad.php"><?echo ADVERTISE; ?></a>
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
            <div id="ad_main_content">
                <div id="form-all">
                    <ul class="form-section">
                        <li class="form-input-wide">
                            <div class="form-header-group">
                                <?if($user_signed_in) { if($fav) echo "<img src='resimler/icons/bookmark_add.png'/> "; else {?>
                                <a rel="gb_page_center[400, 230]" href="add_favs.php?udid=<?echo $_SESSION[id]?>&pdid=<?echo $property[id]?>" style="float:right; margin-right:20px; display:inline">ADD_TO_FAVS<img src="resimler/icons/bookmark_add.png"/></a>
                                <? } } ?>
                                <h2 class="form-header" style="display:inline; width:850px"><?echo ucwords(mb_strtolower($property[title],"UTF-8")) ?> </h2>
                            </div>
                        </li>
                        <br/>
                        <table style="margin-left:20px; vertical-align:top; display:block">
                            <?if(count($photos) > 0) $photo1 = array_shift($photos)?>
                            <tr>
                                <td valign="top">
                                    <table style="border-right:1px solid #CDC7AF; border-bottom:1px solid #CDC7AF; background-color:white">
                                        <tr>
                                            <td colspan="5" style="width:400px">
                                                <div class="ad_header">
                                                    <h3><?echo PHOTOS;?></h3>
                                                </div>
                                                <? if(isset($photo1)) { ?>
                                                <a href="<?echo $photo1[url]?>" rel= "gb_imageset[nice_pics]" title="<?echo $photo1[title]?>">
                                                    <img id="big_image" src="<?echo $photo1[url]?>" style="width:400px; height:auto; border-style:none; border-width:1px; margin-top:3px; height:expression( document.body.clientHeight ? document.getElementById('big_image').height : 'auto');" />
                                                </a>
                                                <? } else echo "<img src='resimler/placeholder.png' />" ?>
                                            </td>
                                        </tr>
                                        <?
                                        $counter = 0;
                                        if(count($photos) > 0) {
                                            foreach($photos as $x) {
                                            if($counter%4 == 0) { echo "<tr>"; } ?>
                                                <td style="border:1px solid #CDC7AF">
                                                    <a href="<?echo $x[url]?>" rel= "gb_imageset[nice_pics]" title="<?echo $x[title]?>" onmouseover="document.getElementById('big_image').src='<?echo $x[url]?>'" onmouseout="document.getElementById('big_image').src='<?echo $photo1[url]?>'">
                                                        <img src="<?echo $x[url]?>" style="width:95px; height:auto; border-style:none; border-width:1px" />
                                                    </a>
                                                </td>
                                            <? if($counter%4 == 3) { echo "</tr>";} $counter++;
                                            }
                                        } ?>
                                    </table>
                                    <table class="ad_sol">
                                        <tr>
                                            <td colspan="5">
                                                <div class="ad_header">
                                                    <h3><?echo DESCRIPTION;?></h3>
                                                </div>
                                                    <?print($property[description])?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="ad_sol">
                                        <tr>
                                            <td colspan="5">
                                                <div class="ad_header">
                                                    <h3><?echo LOCATION;?></h3>
                                                </div>
                                                    <?print($property[location])?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="ad_sol">
                                        <tr>
                                            <td colspan="5">
                                                <div class="ad_header">
                                                    <h3><?echo FURNITURE;?></h3>
                                                </div>
                                                    <?print($property[equipment])?>
                                            </td>
                                        </tr>
                                        <? if(trim($property[other]) != "<br />" && $property[other] != null) { ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="ad_header" style="margin-top:20px">
                                                    <h3><?echo OTHER;?></h3>
                                                </div>
                                                    <?print($property[other])?>
                                            </td>
                                        </tr>
                                        <? } ?>
                                    </table>
                                </td>
                                <td rowspan="2" valign="top" style="padding-left:30px">
                                    <table class="ad_table2" style="border-right:1px solid #CDC7AF; border-bottom:1px solid #CDC7AF; background-color:white">
                                        <tr>
                                            <td colspan="2">
                                                <div class="ad_header">
                                                    <h3><?echo INFO_ABOUT_PROPERTY;?></h3>
                                                </div>
                                            </td>
                                        </tr>
										<?if($property[address_sec] == 0) {?>
                                        <tr>
                                            <td width="160px"><b><?echo ADDRESS;?>:</b></td>
                                            <td width="240px"><?print($property[street]." ".$property[house_no].",")?></td>
                                        </tr>
										<tr>
                                            <td class="ad_table">&nbsp;</td>
                                            <td class="ad_table"><?print($property[postcode]." ".$property[city])?></td>
                                        </tr>
										<? } else { ?>
										<tr>
                                            <td width="160px"><b><?echo CITY;?>:</b></td>
                                            <td width="240px"><?print($property[city])?></td>
                                        </tr>
										<? } ?>
                                        <tr>
                                            <td class="ad_table"><b><?echo CATEGORY;?>:</b></td>
                                            <td class="ad_table"><?print(constant($property[category]).', '.constant($property[property_category]).', '.constant($property[property_subcategory]))?></td>
                                        </tr>
										<tr>
                                            <td class="ad_table"><b><?echo PRICE;?>:</b></td>
                                            <td class="ad_table"><?print(number_format($property[price],2,',','.')." €")?></td>
                                        </tr>
										<tr>
                                            <td class="ad_table"><b><?echo COMMISSION;?>:</b></td>
                                            <td class="ad_table"><?print(number_format($property[commission],2,',','.')."%"); if($property[category] == 'vermieten') echo " Netto kaltmieten inkl. gesetzl. Mwst"; else " inkl. gesetzl. Mwst. vom kaufpreis"?></td>
                                        </tr>
                                        <tr>
                                            <td class="ad_table"><b><?echo LIVING_SPACE;?>:</b></td>
                                            <td class="ad_table"><?print($property[living_space]." m")?><sup>2</sup> </td>
                                        </tr>
                                        <tr>
                                            <td class="ad_table"><b><?echo NUMBER_OF_ROOMS;?>:</b></td>
                                            <td class="ad_table"><?print($property[nb_rooms])?></td>
                                        </tr>
                                        <tr>
                                            <td class="ad_table"><b><?echo FLOOR;?>:</b></td>
                                            <td class="ad_table"><?print($property[floor])?></td>
                                        </tr>
										<tr>
                                            <td class="ad_table"><b><?echo NUMBER_OF_BATHROOMS;?>:</b></td>
                                            <td class="ad_table"><?print($property[nb_bathrooms])?></td>
                                        </tr>
										<tr>
                                            <td class="ad_table"><b><?echo HEATING_TYPE;?>:</b></td>
                                            <td class="ad_table"><?print(constant($property[heating]))?></td>
                                        </tr>
                                        <tr>
                                    </table>
                                    <table class="ad_table2" style="border-right:1px solid #CDC7AF; border-bottom:1px solid #CDC7AF; background-color:white; margin-top:20px">
                                        <tr>
                                            <td colspan="2" width="405px">
                                                <div class="ad_header">
                                                    <h3><?echo PROPERTIES;?></h3>
                                                </div>
                                            </td>
                                        </tr>
                                        <? if(count($ic_ozellik) > 0) {?>
                                        <tr>
                                            <td class="ad_table" width="160px"><b><?echo INDOOR_PROPERTIES;?>:</b></td>
                                            <td class="ad_table" width="240px"><?foreach ($ic_ozellik as $si => $x) { print(constant($x)); if($si+1 < count($ic_ozellik)) print(", "); }?></td>
                                        </tr>
                                        <? } ?>
                                        <? if(count($dis_ozellik) > 0) {?>
                                        <tr>
                                            <td class="ad_table" width="160px"><b><?echo OUTDOOR_PROPERTIES;?>:</b></td>
                                            <td class="ad_table" width="240px"><?foreach ($dis_ozellik as $si => $x) { print(constant($x)); if($si+1 < count($dis_ozellik)) print(", "); }?></td>
                                        </tr>
                                        <? } ?>
                                        <? if(count($ulasim) > 0) {?>
                                        <tr>
                                            <td class="ad_table" width="160px"><b><?echo TRANSPORTATION;?>:</b></td>
                                            <td class="ad_table" width="240px"><?foreach ($ulasim as $si => $x) { print(constant($x)); if($si+1 < count($ulasim)) print(", "); }?></td>
                                        </tr>
                                        <? } ?>
                                        <? if(count($manzara) > 0) {?>
                                        <tr>
                                            <td class="ad_table" width="160px"><b><?echo LANDSCAPE;?>:</b></td>
                                            <td class="ad_table" width="240px"><?foreach ($manzara as $si => $x) { print(constant($x)); if($si+1 < count($manzara)) print(", "); }?></td>
                                        </tr>
                                        <? } ?>
                                        <? if(count($konut_tipi) > 0) {?>
                                        <tr>
                                            <td class="ad_table" width="160px"><b><?echo PROPERTY_TYPE;?>:</b></td>
                                            <td class="ad_table" width="240px"><?foreach ($konut_tipi as $si => $x) { print(constant($x)); if($si+1 < count($konut_tipi)) print(", "); }?></td>
                                        </tr>
                                        <? } ?>
                                        <? if(count($cephe) > 0) {?>
                                        <tr>
                                            <td class="ad_table" width="160px"><b><?echo FRONTAGE;?>:</b></td>
                                            <td class="ad_table" width="240px"><?foreach ($cephe as $si => $x) { print(constant($x)); if($si+1 < count($cephe)) print(", "); }?></td>
                                        </tr>
                                        <? } ?>
                                    </table>
                                    <br/>
                                    <table class="ad_table2" style="border-right:1px solid #CDC7AF; border-bottom:1px solid #CDC7AF; background-color:white">
                                        <tr>
                                            <td colspan="2">
                                                <div class="ad_header">
                                                    <h3><?echo DEALER_INFO;?></h3>
                                                </div>
                                            </td>
                                        </tr>
                                        <? if($user[human]==1) {?>
                                        <tr>
                                            <td colspan="2" style="padding:10px"><img src="<?echo $user[logo_url]?>" style="max-height:200px; max-width:200px"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:10px"><b><?print($user[username])?></b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:10px"><?print($user[street]." ".$user[number])?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:10px"><?print($user[postcode]." ".$user[city])?></td>
                                        </tr>
										<tr>
                                            <td colspan="2" style="padding-left:10px"><?echo EMAIL; print(": ".$user[email])?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:10px"><?echo TELEPHONE; print(": 0".$user[areacode]."/".$user[phone])?></td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:10px"><a href="impressum.php?id=<?echo $user[id]?>" target="_blank" style="color:#E32636" rel="gb_page_center[400,540]" title="<?echo $user[username]?>"><?echo IMPRESSUM;?></a></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:10px"><a href="profile.php?comp_id=<?echo $user[id]?>" style="color:#E32636"><?echo SEE_ALL_ADS;?></a></td>
                                        </tr>
                                        <tr><td width="160px"></td><td width="240px"></td></tr>
                                        <? } else { ?>
                                        <tr>
                                            <td class="ad_table" width="160px"><b><?echo FIRST_NAME;?>:</b></td>
                                            <td class="ad_table" width="240px"><?print($user[firstname])?></td>
                                        </tr>
                                        <tr>
                                            <td class="ad_table"><b><?echo LAST_NAME;?>:</b></td>
                                            <td class="ad_table"><?print($user[lastname])?></td>
                                        </tr>
										<tr>
                                            <td class="ad_table"><b><?echo EMAIL;?>:</b></td>
                                            <td class="ad_table"><?echo EMAIL; print(": ".$user[email])?></td>
                                        </tr>
                                        <tr>
                                            <td class="ad_table"><b><?echo TELEPHONE;?>:</b></td>
                                            <td class="ad_table"><?print("(".$user[areacode].") ".$user[phone])?></td>
                                        </tr>
                                        <tr>
                                            <td class="ad_table"><b><?echo MEMBER_SINCE;?>:</b></td>
                                            <td class="ad_table"><?print(format_date($user[member_since]))?></td>
                                        </tr>
                                        <tr>
                                            <td class="ad_table"><b><?echo CITY;?>:</b></td>
                                            <td class="ad_table"><?print($user[city].", ".$user[country])?></td>
                                        </tr>
                                        <? } ?>
                                    </table>
                                    <?if ($video != null) {?>
                                    <br/>
                                    <table class="ad_table2" style="border-right:1px solid #CDC7AF; border-bottom:1px solid #CDC7AF; background-color:white">
                                        <tr>
                                            <td colspan="2">
                                                <div class="ad_header">
                                                    <h3><?echo VIDEO;?></h3>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding:3px">
                                                <object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="400" height="315">
                                                    <param name="movie" value="jwplayer/player.swf" />
                                                    <param name="allowfullscreen" value="true" />
                                                    <param name="allowscriptaccess" value="always" />
                                                    <param name="flashvars" value="file=<?echo $video[url]?>" />
                                                    <embed
                                                            type="application/x-shockwave-flash"
                                                            id="player2"
                                                            name="player2"
                                                            src="jwplayer/player.swf"
                                                            width="400"
                                                            height="315"
                                                            allowscriptaccess="always"
                                                            allowfullscreen="true"
                                                            flashvars="file=<?echo "$video[url]"?>"
                                                    />
                                                </object>
                                            </td>
                                        </tr>
                                    </table>
                                    <? } ?>
                                </td>
                            </tr>
                        </table>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
