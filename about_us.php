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
        <title><?echo ABOUT_US;?> - TDB Immobilien GmbH</title>
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
                            <h3 style="text-decoration:underline">Wir über uns</h3>
                            <p class="about">
                                Wir die Firma TDB Dienstleistungen GmbH vermitteln schon seit 1988 in den Bereichen Immobilien, Finanzierungen, Bausparen und Versicherungen.
                                <br><br><i>Unsere stärke ist es Zielgerecht auf den Wunsch des Kunden einzugehen und seinen Wunsch entsprechend, das bestmögliche herauszuholen.</i>
                            </p>
                            <h3 style="text-decoration:underline">Gründung und Verlauf der TDB Dienstleistungen GmbH</h3>
                            <p class="about">
                                Die Firma TDB Dienstleistungen GmbH wurde im Jahre 1988 von Herrn Efendi Aygün als Einzel Person gegründet. Seit der Gründung der TDB, war die
                                Philosophie der Firma sowie des Gründers Herrn Efendi Aygün „es gibt kein ICH sondern ein WIR“ wie auch im Logo zu ersehen ist, beinhaltet es
                                ein Dach, was symbolisch für eine Familie unter einem Dach stehen soll. Im Jahre 2003 wurde aus der TDB Gbr die TDB Dienstleistungen GmbH mit
                                150 Mitarbeitern, die ausschließlich mit der Firma TDB als Handelsvertreter im Außendienst arbeiten. Die Firma TDB ist Bundesweit in den Bereichen
                                Immobilien, Privat Kredite, Baufinanzierungen, Bausparen sowie Versicherungen tätig. Zurzeit sind Bundesweit in großen Städten Deutschlands 23
                                Filialen der TDB vertreten. Die TDB ist Bundesweit, die größte Dienstleistungsgesellschaft in Ihrer Branche unter den türkischen Gesellschaften
                                auf dem Markt. <br><br>

                                Der Firmen Inhaber Herr Efendi Aygün, ist bei der BTEU (Bund Türkisch Europäischer Unternehmer) als Vorstandsmitglied tätig, sowie Mitglied bei der
                                TD-IHK (Türkisch Deutsche- Industrie und Handelskammer). Da Herr Efendi Aygün mit seinem Ehrgeiz und sein Erfolg sehr anerkannt und geschätzt wurde,
                                erschienen Artikel in verschiedenen Zeitungen, Magazinen sowie auch ein Buch in Deutschen sowie Türkischen Verlagen. Herr Aygün bekam am 27.12.2006
                                in London eine Auszeichnung als Erfolgreichster Geschäftsmann des Jahres 2006 (Successful Businessman of the Year 2006).<br><br>

                                Die Firma TDB Dienstleistungen GmbH vermittelt Bundesweit für die Türkischen Mitbürger in der Muttersprache in den Bereichen Immobilien, Privat Kredite,
                                Baufinanzierungen, Bausparen und Versicherungen. Mit vielen verschiedenen Geschäftspartnern die Deutschlandweit bekannt sind, werden die günstigsten und
                                zum Kunden passenden Produkte ausgesucht und angeboten. Es bleibt nicht nur bei einem Abschluss Termin, sondern alle Kunden werden mindestens 1 mal im Jahr
                                vom Betreuer angerufen und beraten.<br><br>

                                Die Firma TDB Dienstleistungen GmbH ist jetzt auch in der Türkei tätig. Die Tätigkeit wird mit der Firma EMC-Int. die mit Herrn Aygün zusammen gegründet
                                wurden ist ausgeübt.. Die EMC-Int. welches in der Türkei stark vertreten ist, ist als Vermittler von Dienstleistungen in den Branchen, Medizin, Hoch und
                                Tiefbau, Energie Erzeugung, Umweltschutz sowie jegliche Art von Baumaschinen und Kränen tätig. Auf Grund dieser vielen Tätigkeitsbereiche und einer guten
                                Zusammenarbeit, hat sich die TDB Dienstleistungen GmbH sehr enge Kontakte mit vielen Staatsoberhäuptern , Bürgermeistern und Ministern der Türkei aufbauen können.
                                <br><br>
                                <a href="http://www.tdb-immo.de">www.tdb-immo.de</a> <br>
                                <a href="http://www.tdb-immo.com">www.tdb-immo.com</a>
                            </p>
                            <h3 style="text-decoration:underline">Ein Zitat von Herrn Aygün:</h3>
                            <p class="about">
                                Jeder Mensch hat Träume, doch nur diejenigen, die mit Ehrgeiz an sich glauben, können ihre Träume verwirklichen.
                            </p>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>