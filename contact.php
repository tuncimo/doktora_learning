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
        <title><?echo CONTACT;?> - TDB Immobilien GmbH</title>
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
                <br style="clear:both" />
            </div>
            <div class="main_menu">
                <ul>
                <li><a href="index.php" title="Home"><?echo MAIN_PAGE;?></a></li>
                <li><a href="about_us.php" title="Hakkımızda"><?echo ABOUT_US_HEADER;?></a></li>
                <li><a href="ads.php" title=""><?echo ADVERTISEMENTS;?></a></li>
                <li><a href="service.php" title="Service"><?echo SERVICE;?></a></li>
                <li class="current"><a href="contact.php" title="Kontakt"><?echo CONTACT;?></a></li>
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
            <div id="contact_main_content">
                <div id="form-all">
                    <ul class="form-section">
                        <li class="form-input-wide">
                            <div class="form-header-group">
                                <h2 class="form-header">TDB Immobilien GmbH</h2>
                            </div>
                        </li>
                        <br/>
                        <div class="about_content">
                            <h3 style="text-decoration:underline"><?echo CONTACT;?></h3>
                            <table>
                                <tr>
                                    <td valign="top">TDB Dienstleistungen GmbH <br/>
                                Münzstr. 14 <br/>
                                38100 Braunschweig <br/>
                                Telefon: 0531/40588 <br/>
                                Telefax: 0531/13211 <br/> <br/>
                                E-Mail : info@tdb-immo.de <br/>
                                URL   : www.tdb-immo.de </td>
                                    <td style="padding-left:100px"><iframe width="470" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=TDB+Dienstleistungen+GmbH,+M%C3%BCnzstra%C3%9Fe+14,+38100+Braunschweig,+Germany&amp;sll=37.579413,-95.712891&amp;sspn=56.805293,135.263672&amp;ie=UTF8&amp;hq=TDB+Dienstleistungen+GmbH,&amp;hnear=M%C3%BCnzstra%C3%9Fe+14,+Brunswick,+Germany&amp;ll=52.26263,10.52345&amp;spn=0.006295,0.006295&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=TDB+Dienstleistungen+GmbH,+M%C3%BCnzstra%C3%9Fe+14,+38100+Braunschweig,+Germany&amp;sll=37.579413,-95.712891&amp;sspn=56.805293,135.263672&amp;ie=UTF8&amp;hq=TDB+Dienstleistungen+GmbH,&amp;hnear=M%C3%BCnzstra%C3%9Fe+14,+Brunswick,+Germany&amp;ll=52.26263,10.52345&amp;spn=0.006295,0.006295" style="color:#0000FF;text-align:left"><?echo VIEW_LARGER_MAP?></a></small></td>
                                </tr>
                            </table>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>