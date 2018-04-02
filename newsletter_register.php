<?
session_start();

if(isset($_SESSION[username])) $user_signed_in = true;
else $user_signed_in = false;

include 'connection.php';
include_once 'common.php';
include_once 'scripts/countries.php';
if($user_signed_in == true) {
    $user_id = $_SESSION[id];
    $query = mysql_query("SELECT * FROM users WHERE id=$user_id");
    $user = mysql_fetch_assoc($query);
}
if(isset ($_GET['country'])) $country = $_GET['country'];
if($_GET['process'] == 'success') {
    echo "<img src='resimler/tdb_logo.jpg' style='margin-top:200px; margin-left:140px'/>";
    echo "<h1>";
    echo YOUR_REQUEST_HAS_BEEN_SAVED;
    echo "</h1>";
}else{

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo NEWSLETTER_REGISTER;?></title>

        <script type="text/javascript" src="scripts/city_select.js"></script>
        <script type="text/javascript" src="scripts/form_validate.js"></script>
    </head>
    <body <?if($country != "Deutschland"){?>onload="city_select_newsletter(<?print($country)?>)" <?}else {?> onload="city_select_newsletter('baden_wurttemberg')" <?}?>>
        <div id="contain">
            <?if($user_signed_in != true) echo "<center>"?>
            <div id="main_content">
                <?if($user_signed_in != true) {?>
                <form id="signin_form" action="check_login.php" method="post" name="enter">
                <img src="resimler/tdb_logo.jpg" style="margin-top:200px" />
                <h1 align="center"><?echo USER_LOGIN;?></h1>
                <table id="signin_table">
                    <tr>
                        <td><?echo USERNAME;?>:</td>
                        <td><input class="same_size" type="text" name="myusername"/> </td>
                    </tr>
                    <tr>
                        <td><?echo PASSWORD;?>:</td>
                        <td><input class="same_size" type="password" name="mypassword" autocomplete="off"/> </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" value="<?echo SUBMIT;?>" name="submit" /></td>
                    </tr>
                </table>
                </form>
                <? } else {?>
                <form action="newsletter_submit.php" method="post" name="newsletter" style="padding:20px" onsubmit="return validateNewsletter(this)">
                    <h1 align="center"><?echo SUBSCRIBE_TITLE;?></h1>
                    <?echo HELLO; echo " ".$user[username].", <br>"; echo SUBSCRIBE_TEXT;?>
                    <table style="margin-top:20px; line-height:25px">
                        <tr>
                            <td width="150px"><?echo EMAIL;?>:</td>
                            <td><input type="text" value="<?echo $user[email]?>" disabled="true"/></td>
                        </tr>
                        <?if($country != "Deutschland") {?>
                        <tr>
                            <td width="150px"><?echo COUNTRY;?>:</td>
                            <td>
                                <select name="country" onchange="city_select_newsletter(this.value)">
                                    <?foreach ($countries as $c) if($country == $c) echo "<option value='$c' selected> $c </option>"; else echo "<option value='$c'> $c </option>"?>
                                </select>
                            </td>
                        </tr>
                        <? } else{?>
                        <tr>
                            <td width="150px"><?echo STATE;?>:</td>
                            <td>
                                <select name="state" onchange="city_select_newsletter(this.value)">
                                    <option value="baden_wurttemberg">Baden-Württemberg</option>
                                    <option value="bayern">Bayern</option>
                                    <option value="berlin">Berlin</option>
                                    <option value="brandenburg">Brandenburg</option>
                                    <option value="bremen">Bremen</option>
                                    <option value="hamburg">Hamburg</option>
                                    <option value="hessen">Hessen</option>
                                    <option value="mecklenburg_vorpommern">Mecklenburg-Vorpommern</option>
                                    <option value="niedersachsen">Niedersachsen</option>
                                    <option value="nordrhein_westfalen">Nordrhein-Westfalen</option>
                                    <option value="rheinland_pfalz">Rheinland-Pfalz</option>
                                    <option value="saarland">Saarland</option>
                                    <option value="sachsen">Sachsen</option>
                                    <option value="sachsen_anhalt">Sachsen-Anhalt</option>
                                    <option value="schleswig_holstein">Schleswig-Holstein</option>
                                    <option value="thuringen">Thüringen</option>
                                </select>
                            </td>
                        </tr>
                        <input type="hidden" name="country" value="Deutschland" />
                        <?}?>
                        <tr>
                            <td width="150px"><?echo CITY;?>:</td>
                            <td>
                                <select name="city"></select>
                            </td>
                        </tr>
                        <tr>
                            <td><?echo CATEGORY;?>:</td>
                            <td><input type="radio" name="category" value="verkaufen" checked><?echo FOR_SALE;?><input type="radio" name="category" value="vermieten"><?echo FOR_RENT;?></td>
                        </tr>
                        <tr>
                            <td><?echo PROPERTY_CATEGORY;?>:</td>
                            <td>
                                <select name="property_category">
                                    <option value="HOUSE"><?echo HOUSE;?></option>
                                    <option value="APARTMENT"><?echo APARTMENT;?></option>
                                    <option value="LOT"><?echo LOT;?></option>
                                    <option value="WORKPLACE"><?echo WORKPLACE;?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?echo HEATING;?>:</td>
                            <td>
                                <select name="heating">
                                    <option value=""> <? echo ALL; ?> </option>
                                    <option value="NONE"> <? echo NONE; ?></option>
                                    <option value="NATURAL_GAS"> <?echo NATURAL_GAS; ?> </option>
                                    <option value="CEN_SYSTEM"> <? echo CEN_SYSTEM; ?> </option>
                                    <option value="AIR_CONDITIONER"> <? echo AIR_CONDITIONER; ?> </option>
                                    <option value="SOLAR_ENERGY"> <? echo SOLAR_ENERGY; ?> </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?echo NUMBER_OF_ROOMS;?>:</td>
                            <td><input type="text" name="min_nb_rooms"  size="1"/> - <input type="text" name="max_nb_rooms"  size="1"/></td>
                        </tr>
                        <tr>
                            <td><?echo NUMBER_OF_BATHROOMS;?>:</td>
                            <td><input type="text" name="min_nb_bathrooms"  size="1"/> - <input type="text" name="max_nb_bathrooms"  size="1"/></td>
                        </tr>
                        <tr>
                            <td><?echo FLOOR;?>:</td>
                            <td><input type="text" name="min_floor" size="1"/> - <input type="text" name="max_floor"  size="1"/></td>
                        </tr>
                        <tr>
                            <td><?echo LIVING_SPACE;?>:</td>
                            <td><input type="text" name="min_living_space" size="2"/>m<sup>2</sup> - <input type="text" name="max_living_space" size="2"/>m<sup>2</sup> </td>
                        </tr>
                        <tr>
                            <td><?echo PRICE;?>:</td>
                            <td><input type="text" name="min_price" size="5"/>EUR - <input type="text" name="max_price" size="5"/>EUR</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td> </td>
                            <td align="right"><input type="submit" name="newsletter_submit" value="<?echo SUBMIT?>"/></td>
                        </tr>
                    </table>
                    <input type="hidden" value="<?echo $user[id]?>" name="user_id"/>
                </form>
                <? } ?>
            </div>
            <?if($user_signed_in != true) echo "</center>"?>
        </div>
    </body>
</html>
<? } ?>

<style>
    #main_content {
        width:100%;
        height:670px;
        font-family:calibri,helvetica,verdana;
    }
</style>
