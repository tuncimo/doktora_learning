<?php
        session_start();
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
        <title><?echo HELP;?> - TDB Immobilien GmbH</title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="shortcut icon" type="image/x-icon" href="resimler/hou.ico">
        <link rel="stylesheet" type="text/css"  href="stylesheets/form.css"/>
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
                <li><a href="index.php" title="Home"><?echo MAIN_PAGE;?></a></li>
                <li class="current"><a href="about_us.php" title="Hakkımızda"><?echo ABOUT_US_HEADER;?></a></li>
                <li><a href="ads.php" title=""><?echo ADVERTISEMENTS;?></a></li>
                <li><a href="service.php" title="Service"><?echo SERVICE;?></a></li>
                <li><a href="contact.php" title="Kontakt"><?echo CONTACT;?></a></li>
                <li><a href="new_ad.php" title="İlan Ver"><?echo ADVERTISE;?></a>
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
            <div id="about_us_main_content">
                <div id="form-all">
                    <ul class="form-section">
                        <li class="form-input-wide">
                            <div class="form-header-group">
                                <h2 class="form-header">TDB Immobilien GmbH</h2>
                            </div>
                        </li>
                        <br/>
                        <div class="about_content">
                            <h3 style="text-decoration:underline"><?echo HELP?></h3>
                            <p class="about">
                                Sayfanın kullanımı
                            </p>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>