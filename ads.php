<?php
        session_start();
        if(isset($_SESSION[username])) {
            $user_signed_in = true;
        }
        else {
            $user_signed_in = false;
        }
        include_once 'common.php';
        include_once 'connection.php';
        include_once 'format_date.php';

        if($_POST['search_submit']) {
            $title = $_POST['title'];
            if($title == "İlan Metni" || $title == "Ad Title" || $title == "Anzeigen Überschrift" || $title == "AD_TITLE") $title = null;
            $prop_type = $_POST['prop_type'];
            if($prop_type == "") $prop_type = null;
            $state = $_POST['state'];
            $city = $_POST['city'];
            $type = $_POST['type'];
            $country = $_POST['country'];
            if($country == "") $country = "Deutschland";
            $min_price = $_POST['min_price'];
            $max_price = $_POST['max_price'];
            $min_space = $_POST['min_space'];
            $max_space = $_POST['max_space'];
            $min_rooms = $_POST['min_rooms'];
            $max_rooms = $_POST['max_rooms'];
            if($min_price == null) $min_price = 0;
            if($max_price == null) $max_price = 999999999;
            if($min_rooms == null) $min_rooms = 0;
            if($max_rooms == null) $max_rooms = 99;
            if($min_space == null) $min_space = 0;
            if($max_space == null) $max_space = 999999999;

            $query = mysql_query("SELECT * FROM property WHERE title LIKE '%$title%' AND approved=1 AND property_category LIKE '%$prop_type%'
                                  AND category='$type' AND city LIKE '%$city%' AND country LIKE '%$country%' AND price
                                  BETWEEN $min_price AND $max_price AND living_space BETWEEN $min_space AND $max_space
                                  AND nb_rooms BETWEEN $min_rooms AND $max_rooms");

            if (!$query) {
                die('Hatalı sorgu: ' . mysql_error());
            }
            while ($row = mysql_fetch_array($query)) {
                $properties[] = $row;
            }
        }
        else {
            if ($_POST['narrow_submit']) {
                $title = $_POST['title'];
                $prop_type = $_POST['prop_type'];
                if($prop_type == "") $prop_type = null;
                $country = $_POST['country'];
                $state = $_POST['state'];
                $city = $_POST['city'];
                $type = $_POST['type'];
                $min_price = $_POST['min_price'];
                $max_price = $_POST['max_price'];
                $min_space = $_POST['min_space'];
                $max_space = $_POST['max_space'];
                $min_rooms = $_POST['min_rooms'];
                $max_rooms = $_POST['max_rooms'];
                if($min_price == null) $min_price = 0;
                if($max_price == null) $max_price = 999999999;
                if($min_rooms == null) $min_rooms = 0;
                if($max_rooms == null) $max_rooms = 99;
                if($min_space == null) $min_space = 0;
                if($max_space == null) $max_space = 999999999;
                $heating = $_POST['heating'];
                if($heating == "") $heating = null;
                $min_bathrooms = $_POST['min_bathrooms'];
                $max_bathrooms = $_POST['max_bathrooms'];
                $min_floor = $_POST['min_floor'];
                $max_floor = $_POST['max_floor'];
                if($min_bathrooms == null) $min_bathrooms = 0;
                if($max_bathrooms == null) $max_bathrooms = 99;
                if($min_floor == null) $min_floor = 0;
                if($max_floor == null) $max_floor = 99;
                $ads_wphotos = $_POST['ads_wphotos'];
                $ads_wvids = $_POST['ads_wvids'];

                $query = mysql_query("SELECT * FROM property WHERE title LIKE '%$title%' AND approved=1 AND property_category LIKE '%$prop_type%'
                                      AND category='$type' AND city LIKE '%$city%' AND country LIKE '%$country%' AND price
                                      BETWEEN $min_price AND $max_price AND living_space BETWEEN $min_space AND $max_space
                                      AND nb_rooms BETWEEN $min_rooms AND $max_rooms AND heating LIKE '%$heating%' AND nb_bathrooms BETWEEN $min_bathrooms AND
                                      $max_bathrooms AND floor BETWEEN $min_floor AND $max_floor");

                if (!$query) {
                    die('Hatalı sorgu: ' . mysql_error());
                }
                while ($row = mysql_fetch_array($query)) {
                    if($ads_wphotos == false && $ads_wvids == false) {
                        $properties[] = $row;
                    }
                    elseif ($ads_wphotos == true && $ads_wvids == true) {
                        $query2 = mysql_query("SELECT id FROM photos WHERE property_id='$row[id]'");
                        if(mysql_num_rows($query2) > 0) {
                            $query3 = mysql_query("SELECT id FROM videos WHERE property_id='$row[id]'");
                            if(mysql_num_rows($query3) > 0) $properties[] = $row;
                        }
                    }
                    elseif ($ads_wphotos == true && $ads_wvids == false) {
                        $query2 = mysql_query("SELECT id FROM photos WHERE property_id='$row[id]'");
                        if(mysql_num_rows($query2) > 0) $properties[] = $row;
                    }
                    elseif ($ads_wphotos == false && $ads_wvids == true) {
                        $query2 = mysql_query("SELECT id FROM videos WHERE property_id='$row[id]'");
                        if(mysql_num_rows($query2) > 0) $properties[] = $row;
                    }
                }
            }
            else {
                if(isset ($_GET['cat'])) $cat = $_GET['cat'];
                if(isset ($_GET['ptype'])) $ptype = $_GET['ptype'];
                $country = "Deutschland";
                $state = null;
                $city = null;
                if($cat != null && $ptype != null) {
                    if($cat == "verkaufen" && $ptype == "ABROAD") $query = mysql_query("SELECT * FROM property WHERE approved=1 AND country NOT LIKE '%Deutschland%'");
                    else $query = mysql_query("SELECT * FROM property WHERE approved=1 AND country='$country' AND category='$cat' AND property_category='$ptype'");
                }
                else $query = mysql_query("SELECT * FROM property WHERE approved=1 AND country='$country'");
                while($row = mysql_fetch_array($query)) {
                    $properties[] = $row;
                }
            }
        }
        

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo ADVERTISEMENT;?> - TDB Immobilien GmbH</title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="stylesheet" type="text/css"  href="stylesheets/form.css"/>
        <script type="text/javascript" src="scripts/form_validate.js"></script>
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
                <br style="clear:both" />
            </div>
            <div class="main_menu">
                <ul>
                <li><a href="index.php"><?echo MAIN_PAGE;?></a></li>
                <li><a href="about_us.php"><?echo ABOUT_US_HEADER;?></a></li>
                <li class="current"><a href="ads.php"><?echo ADVERTISEMENTS;?></a></li>
                <li><a href="service.php"><?echo SERVICE;?></a></li>
                <li><a href="contact.php"><?echo CONTACT;?></a></li>
                <li><a href="new_ad.php"><?echo ADVERTISE;?></a>
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
            <div id="ads_sidebar_left">
                <div class="bar_header">
                    <h3><?echo NARROW_SEARCH;?></h3>
                </div>
                <div id="ads_sidebar_content">
                    <form action="" name="narrow_down" method="post" onsubmit="return validateNarrowSearch(this); document.write('dsg')">
                        <p> <?echo COUNTRY;?>: <b><? echo " ".$country ?></b> <input type="hidden" name="country" value="<?echo $country?>" /> </p>
                        <p> <?echo STATE;?>: <b><? if($state != null) echo " ".$state; else echo ALL; ?></b> <input type="hidden" name="state" value="<?echo $state?>" /> </p>
                        <p> <?echo CITY;?>: <b><? if($city  != null) echo " ".$city;  else echo ALL; ?></b> <input type="hidden" name="city" value="<?echo $city?>" /> </p>
                        <p>
                            <input id="mieten" type="radio" name="type" value="vermieten" <?if($type == "vermieten") echo "CHECKED"?> /> <label class="label" for="vermieten"><b> <?echo FOR_RENT;?> </b></label>
                            <br/><input id="kaufen" type="radio" name="type" value="verkaufen" <?if($type == "verkaufen") echo "CHECKED"?> /> <label class="label" for="verkaufen"><b> <?echo FOR_SALE;?> </b></label>
                        </p>
                        <p> <? echo CATEGORY;?>: <br/>
                            <select name="prop_type">
                                <option value=""> <? echo CHOOSE; ?> </option>
                                <option value="HOUSE" <?if($prop_type == "HOUSE") echo "selected='true'"?>> <? echo HOUSE; ?> </option>
                                <option value="APARTMENT" <?if($prop_type == "APARTMENT") echo "selected='true'"?>> <? echo APARTMENT; ?> </option>
                                <option value="LOT" <?if($prop_type == "LOT") echo "selected='true'"?>> <? echo LOT; ?> </option>
                                <option value="WORKPLACE" <?if($prop_type == "WORKPLACE") echo "selected='true'"?>> <? echo WORKPLACE; ?> </option>
                            </select>
                        </p>
                        <p> <? echo HEATING;?>: <br/>
                            <select name="heating">
                                <option value=""> <? echo CHOOSE; ?> </option>
                                <option value="NONE"      <?if($heating == "NONE") echo "selected='true'"?>> <? echo NONE; ?></option>
                                <option value="NATURAL_GAS" <?if($heating == "NATURAL_GAS") echo "selected='true'"?>> <?echo NATURAL_GAS; ?> </option>
                                <option value="CEN_SYSTEM"  <?if($heating == "CEN_SYSTEM") echo "selected='true'"?>> <? echo CEN_SYSTEM; ?> </option>
                                <option value="AIR_CONDITONER"    <?if($heating == "AIR_CONDITIONER") echo "selected='true'"?>> <? echo AIR_CONDITIONER; ?> </option>
                                <option value="SOLAR_ENERGY"    <?if($heating == "SOLAR_ENERGY") echo "selected='true'"?>> <? echo SOLAR_ENERGY; ?> </option>
                            </select>
                        </p>
                        <p> <? echo NUMBER_OF_ROOMS;?>: <br/>
                            <input name="min_rooms" size="1" value="<?if($min_rooms != 0) echo $min_rooms?>"/> -
                            <input name="max_rooms" size="1" value="<?if($max_rooms != 99) echo $max_rooms?>" onClick="javascript:this.form.max_rooms.focus();this.form.max_rooms.select()"/>
                        </p>
                        <p> <? echo NUMBER_OF_BATHROOMS;?>: <br/>
                            <input name="min_bathrooms" size="1" value="<?if(isset ($min_bathrooms)) { if($min_bathrooms != 0) echo $min_bathrooms; }?>"/> -
                            <input name="max_bathrooms" size="1" value="<?if(isset ($max_bathrooms)) { if($max_bathrooms != 99) echo $max_bathrooms;}?>" onClick="javascript:this.form.max_bathrooms.focus();this.form.max_bathrooms.select()"/>
                        </p>
                        <p> <? echo LIVING_SPACE;?>: <br/>
                            <input name="min_space" size="1" value="<?if($min_space != 0) echo $min_space?>"/>m<sup>2</sup> -
                            <input name="max_space" size="1" value="<?if($max_space != 999999999) echo $max_space?>" onClick="javascript:this.form.max_space.focus();this.form.max_space.select()"/>m<sup>2</sup>
                        </p>
                        <p> <? echo PRICE;?>: <br/>
                            <input name="min_price" size="5" value="<?if($min_price != 0) echo $min_price?>"/>(€) -
                            <input name="max_price" size="5" value="<?if($max_price != 999999999) echo $max_price?>" onClick="javascript:this.form.max_price.focus();this.form.max_price.select()"/> (€)
                        </p>
                        <p> <? echo FLOOR;?>: <br/>
                            <input name="min_floor" size="1" value="<?if(isset ($min_floor)) { if($min_floor != 0) echo $min_floor; }?>"/> -
                            <input name="max_floor" size="1" value="<?if(isset ($max_floor)) { if($max_floor != 99) echo $max_floor; }?>" onClick="javascript:this.form.max_floor.focus();this.form.max_floor.select()"/>
                        </p>
                        <p>
                            <?echo ADS_WITH_PHOTOS; ?>&nbsp; <input name="ads_wphotos" type="checkbox" <?if(isset ($ads_wphotos) && $ads_wphotos == "on") echo "checked"?>/> <br/>
                            <?echo ADS_WITH_VIDS;   ?>&nbsp; <input name="ads_wvids" type="checkbox" <?if(isset ($ads_wvids) && $ads_wvids == "on") echo "checked"?>/>
                        </p>
                        <br/>
                        <p>
                            <input name="title" type="hidden" value="<? echo $title?>" />
                            <input name="narrow_submit" type="submit" value="<? echo SUBMIT;?>" />
                        </p>
                    </form>
                </div>
            </div>
            <div id="ads_main_content">
                <? if(count($properties) == 0) {?>
                <p style="padding-left:10px"><?echo NO_RESULTS_WITH_YOUR_CRITERIA?>!</p>
                <? } else { ?>
                <table border="1" style="text-align:center; font-size:13px">
                    <tr>
                        <th><?echo PHOTOS;?></th>
                        <th><?echo CATEGORY;?></th>
                        <th><?echo TITLE;?></th>
                        <th><?echo NUMBER_OF_ROOMS;?></th>
                        <th><?echo LIVING_SPACE;?></th>
                        <th><?echo PRICE;?></th>
                        <th><?echo CITY;?></th>
                    </tr>
                    <? foreach ($properties as $p) { 
					$price_dots = number_format($p[price], 2, ',', '.');
                    $query = mysql_query("SELECT url FROM photos WHERE property_id=$p[id]");
                    $photo = mysql_fetch_assoc($query);
                    if($photo == null) $photo[url] = "resimler/icons/cam.png"
                    ?>
                    <tr>
                        <td style="padding:2px"><img src="<?print($photo[url])?>" style="width:80px" /></td>
                        <td><a href="ad.php?id=<?echo $p[id]?>"><?print(constant($p[category])." ".constant($p[property_subcategory]))?></td>
                        <td><a href="ad.php?id=<?echo $p[id]?>"><?print(ucwords(mb_strtolower($p[title],"UTF-8")))?></a></td>
                        <td><a href="ad.php?id=<?echo $p[id]?>"><?print($p[nb_rooms])?></a></td>
                        <td><a href="ad.php?id=<?echo $p[id]?>"><?print($p[living_space])?>m<sup>2</sup></a></td>
                        <td><a href="ad.php?id=<?echo $p[id]?>"><?print($price_dots." €")?></a></td>
                        <td><a href="ad.php?id=<?echo $p[id]?>"><?print($p[city])?></a></td>
                    </tr>
                    <? } ?>
                </table>
                <? }?>
            </div>
            <div style="margin-left:210px; margin-top:5px">
                <script type="text/javascript">
                    var lefty = (window.screen.width - 500) / 2;
                    var topty = (window.screen.height -700) / 2;
                </script>
                <a style="cursor:pointer" onclick="window.open('newsletter_register.php?country=<?echo $country?>', 'newsletter','toolbar=no,location=no,status=no,menubar=no,scrollbars=auto,resizable=no,width=500,height=700,left='+lefty+',top='+topty)"><? echo COULD_NOT_FIND_WHAT_YOURE_LOOKING; ?></a>
            </div>
        </div>
    </body>
</html>