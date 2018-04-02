<?php
        session_start();
        $ref = $_SERVER['HTTP_REFERER'];

        if(isset($_SESSION[username])) {
            $user_signed_in = true;
        }
        else {
            $user_signed_in = false;
        }
        include_once 'common.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo ADVERTISE;?></title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="shortcut icon" type="image/x-icon" href="resimler/hou.ico">
        <link rel="stylesheet" type="text/css"  href="stylesheets/form.css"/>
         <script type="text/javascript" src="scripts/form_validate.js"></script>
    </head>
    <body>
        <div id="contain">
            <div class="top_menu">
                <a href="index.php"><img style="border:none; float:left" src="resimler/tdb_logo2.jpg"/></a>
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
                <li><a href="index.php" title=""><?echo MAIN_PAGE;?></a></li>
                <li><a href="about_us.php" title=""><?echo ABOUT_US_HEADER;?></a></li>
                <li><a href="ads.php" title=""><?echo ADVERTISEMENTS;?></a></li>
                <li><a href="service.php" title=""><?echo SERVICE;?></a></li>
                <li><a href="contact.php" title="Kontakt"><?echo CONTACT;?></a></li>
                <li class="current"><a href="new_ad.php" title=""><?echo ADVERTISE;?></a>
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
            <div id="new_ad_main_content">
                <?if ($user_signed_in == true) {?>
                <div id="form-all">
                    <ul class="form-section">
                        <li class="form-input-wide">
                            <div class="form-header-group">
                                <h2 class="form-header"><?echo ADVERTISE;?></h2>
                            </div>
                        </li>
                        <br/>
                        <h3 style="margin-left:30px"><?echo STEP_ONE;?></h3>
                        <form id="ad_form" method="post" name="ad_form" action="new_ad2.php" style="padding:25px" onsubmit="return adFormSelection(this)">
                            <div style="position:relative; border-right:1px solid #DBDBDB; width:140px; margin-left:30px; height:240px; margin-top:30px">
                                <h3><?echo PRIVAT;?></h3>
                                <input type="radio" name="property_category" value="PAPARTMENT"/> <?echo APARTMENT;?><br/>
                                <input type="radio" name="property_category" value="PHOUSE"/> <?echo HOUSE;?><br/>
                                <input type="radio" name="property_category" value="PLOT"/><?echo LOT;?><br/>
                                <input type="radio" name="property_category" value="PGARAGE"/><?echo GARAGE;?><br/>
                            </div>
                            <div style=" margin-left:220px; margin-top:-240px; width:190px; border-right:1px solid #DBDBDB; height:240px">
                                <h3><?echo WORKPLACE;?></h3>
                                <input type="radio" name="property_category" value="GLOT"/> <?echo LOT;?><br/>
                                <input type="radio" name="property_category" value="GOFFICE"/> <?echo OFFICE;?><br/>
                                <input type="radio" name="property_category" value="GRETAIL_STORE"/><?echo RETAIL_STORE;?><br/>
                                <input type="radio" name="property_category" value="GHOTEL"/><?echo HOTEL;?><br/>
                                <input type="radio" name="property_category" value="GHALL_MARKET"/><?echo HALL_MARKET;?><br/>
                                <input type="radio" name="property_category" value="GLEISURE"/><?echo LEISURE;?><br/>
                                <input type="radio" name="property_category" value="GGARAGE"/><?echo GARAGE;?><br/>
                                <input type="radio" name="property_category" value="GAPARTMENT_TOWNHOUSE"/><?echo APARTMENT_TOWNHOUSE;?><br/>
                                <input type="radio" name="property_category" value="GOTHER"/><?echo OTHER_PROPERTY;?><br/>
                            </div>
                            <div style=" margin-left:450px; margin-top:-240px; width:190px; border-right:1px solid #DBDBDB; height:240px">
                                <h3><?echo CAPITAL;?></h3>
                                <input type="radio" name="property_category" value="KAPARTMENT"/> <?echo APARTMENT;?><br/>
                                <input type="radio" name="property_category" value="KHOUSE"/> <?echo HOUSE;?><br/>
                                <input type="radio" name="property_category" value="KAPARTMENT_TOWNHOUSE"/><?echo APARTMENT_TOWNHOUSE;?><br/>
                                <input type="radio" name="property_category" value="KOFFICE"/> <?echo OFFICE;?><br/>
                                <input type="radio" name="property_category" value="KRETAIL_STORE"/><?echo RETAIL_STORE;?><br/>
                                <input type="radio" name="property_category" value="KHOTEL"/><?echo HOTEL;?><br/>
                                <input type="radio" name="property_category" value="KHALL_MARKET"/><?echo HALL_MARKET;?><br/>
                                <input type="radio" name="property_category" value="KLEISURE"/><?echo LEISURE;?><br/>
                                <input type="radio" name="property_category" value="KGARAGE"/><?echo GARAGE;?><br/>
                                <input type="radio" name="property_category" value="KLOT"/> <?echo LOT;?><br/>
                                <input type="radio" name="property_category" value="KOTHER"/><?echo OTHER_PROPERTY;?><br/>
                            </div>
                            <div style=" margin-left:670px; margin-top:-238px; width:160px; height:240px">
                                <h3><?echo ABROAD;?></h3>
                                <input type="radio" name="property_category" value="AAPARTMENT"/> <?echo APARTMENT;?><br/>
                                <input type="radio" name="property_category" value="AHOUSE"/> <?echo HOUSE;?><br/>
                                <input type="radio" name="property_category" value="ALOT"/><?echo LOT;?><br/>
                            </div>
                            <div style="padding:30px; font-size:18px">
                                <select name="category" style="outline:1px solid gray">
                                    <option value=""><?echo CHOOSE;?></option>
                                    <option value="verkaufen"><?echo verkaufen;?></option>
                                    <option value="vermieten"><?echo vermieten;?></option>
                                </select>
                                <input type="submit" value="<?echo SUBMIT;?>"/>
                            </div>
                        </form>
                    </ul>
                </div>
                <? } else { ?>
            <form id="signin_form" action="check_login.php" method="post">
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
                    <td colspan="2" align="right"><input type="submit" value="<?echo SUBMIT;?>" name="submit" /></td>
                </tr>
                <tr><td> &nbsp;</td></tr>
                <tr>
                    <td colspan="2" align="left"><a href="register.php"><?echo YOURE_NOT_A_MEMBER_REGISTER?></a></td>
                </tr>
            </table>
            </form>
            <? } ?>
            </div>
        </div>
    </body>
</html>


<script type="text/javascript">
    function refresh(name) {
        if (name=="estate") {
        }
    }
</script>