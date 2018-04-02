<?php
        session_start();
        if(isset($_SESSION[username])) {
            $user_signed_in = true;
        }
        else {
            $user_signed_in = false;
        }

        if(isset ($_GET['error'])) {
            $error = $_GET['error'];
        }
        include_once 'common.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo REGISTER;?></title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="stylesheet" type="text/css"  href="stylesheets/form.css"/>
        <link rel="stylesheet" type="text/css"  href="stylesheets/calendarview.css"/>
        <script type="text/javascript" src="scripts/city_select.js"></script>
        <script type="text/javascript" src="scripts/form_validate.js"></script>
        <link rel="shortcut icon" type="image/x-icon" href="resimler/hou.ico">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript">
	//<![CDATA[
        $(function()
        {
                var config = {
                        toolbar:
                        [
                                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
                                ['UIColor']
                        ]
                };

                // Initialize the editor.
                // Callback function can be passed and executed after full instance creation.
                $('.jquery_ckeditor').ckeditor(config);
        });
        //]]>
	</script>
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
            <div id="register_main_content">
                <form class="jotform-form" action="register_submit.php" enctype="multipart/form-data" method="post" name="register_form" id="register_form" accept-charset="utf-8" onsubmit="return validateMainRegisterForm(this)">
                    <input type="hidden" name="formID" value="" />
                    <div class="form-all">
                        <ul class="form-section">
                            <li class="form-input-wide">
                                <div class="form-header-group">
                                    <h2 class="form-header">
                                        <?echo REGISTRATION_FORM;?>
                                    </h2>
                                </div>
                            </li>
                            <br/>
                            <?
                            if($error == "SECURITY_CODE_INCORRECT")echo "<h2>".SECURITY_CODE_INCORRECT."</h2>";
                            elseif ($error == "USERNAME_IN_USE")echo "<h2>".USERNAME_IN_USE."</h2>";
                            elseif ($error == "AN_ERROR_OCCURED")echo "<h2>".AN_ERROR_OCCURED."</h2>";
                            elseif ($error == "UNKNOWN_FILE_EXTENSION")echo "<h2>".UNKNOWN_FILE_EXTENSION."</h2>";
                            elseif ($error == "MAX_SIZE_LIMIT")echo "<h2>".MAX_SIZE_LIMIT."</h2>";
                            elseif ($error == "PROCESS_FAILED")echo "<h2>".PROCESS_FAILED."</h2>";
                            ?>

                            <li class="form-line">
                                <label class="form-label-left"><?echo USER;?>:</label>
                                <div class="form-input">
                                    <?echo PERSON;?><input type="radio" name="user_status" value="human" checked onclick="change_fields(this.value)"/>
                                    <?echo FIRM;?><input type="radio" name="user_status" value="firm" onclick="change_fields(this.value)"/>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left" for="username_input">
                                    <span id="user_firm"><?echo USERNAME;?></span><span id="user_firm2" style="display:none"><?echo FIRM_NAME;?></span>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input">
                                    <input type="text" id="username_input" name="username" size="20" />
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left" for="email_input">
                                    <?echo EMAIL;?>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input">
                                    <input type="text" id="email_input" name="email" size="30" />
                                </div>
                            </li>

                            <li class="form-line">
                                <label class="form-label-left" for="password_input">
                                    <?echo PASSWORD;?>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input">
                                    <input type="password" id="password_input" name="password" size="20" autocomplete="off"/>
                                </div>
                            </li>

                            <li class="form-line">
                                <label class="form-label-left" for="password2_input">
                                    <?echo PASSWORD_AGAIN;?>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input">
                                    <input type="password" id="password2_input" name="password2" size="20" />
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left">
                                    <?echo SALUTATION;?>
                                </label>
                                <div class="form-input">
                                    <select name="salutation">
                                        <option></option>
                                        <option value="MR"><?echo MR;?></option>
                                        <option value="MRS"><?echo MRS;?></option>
                                    </select>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left" for="fullname_input">
                                    <?echo FULL_NAME;?>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input">
                                    <span class="form-sub-label-container">
                                        <input type="text" size="10" name="firstname" id="firstname_input" /><label class="form-sub-label" for="firstname_input"> <?echo FIRST_NAME;?> </label>
                                    </span>
                                    <span class="form-sub-label-container">
                                        <input type="text" size="15" name="lastname" id="lastname_input" /><label class="form-sub-label" for="lastname_input"> <?echo LAST_NAME;?> </label>
                                    </span>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left">
                                    <?echo ADDRESS;?>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input">
                                    <span class="form-sub-label-container">
                                        <input type="text" name="street" size="30"/><label class="form-sub-label"><?echo STREET;?></label>
                                    </span>
                                    <span class="form-sub-label-container">
                                        <input type="text" name="number" size="3"/><label class="form-sub-label"><?echo NUMBER;?></label>
                                    </span>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left"></label>
                                <div class="form-input">
                                    <span class="form-sub-label-container">
                                        <input type="text" name="postcode" size="8"/><label class="form-sub-label"><?echo POSTCODE;?></label>
                                    </span>
                                    <span class="form-sub-label-container">
                                        <select name="city" id="city_input">
                                            <option value="Aachen">Aachen</option>
                                            <option value="Amberg">Amberg</option>
                                            <option value="Ansbach">Ansbach</option>
                                            <option value="Aschaffenburg">Aschaffenburg</option>
                                            <option value="Augsburg">Augsburg</option>
                                            <option value="Bamberg">Bamberg</option>
                                            <option value="Bayreuth">Bayreuth</option>
                                            <option value="Berlin">Berlin</option>
                                            <option value="Bielefeld">Bielefeld</option>
                                            <option value="Bochum">Bochum</option>
                                            <option value="Bonn">Bonn</option>
                                            <option value="Bottrop">Bottrop</option>
                                            <option value="Brandenburg">Brandenburg</option>
                                            <option value="Braunschweig">Braunschweig</option>
                                            <option value="Bremen">Bremen</option>
                                            <option value="Bremerhaven">Bremerhaven</option>
                                            <option value="Chemnitz">Chemnitz</option>
                                            <option value="Coburg">Coburg</option>
                                            <option value="Cottbus">Cottbus</option>
                                            <option value="Darmstadt">Darmstadt</option>
                                            <option value="Delmenhorst">Delmenhorst</option>
                                            <option value="Dessau">Dessau</option>
                                            <option value="Dortmund">Dortmund</option>
                                            <option value="Dresden">Dresden</option>
                                            <option value="Duisburg">Duisburg</option>
                                            <option value="Düsseldorf">Düsseldorf</option>
                                            <option value="Eisenach">Eisenach</option>
                                            <option value="Emden">Emden</option>
                                            <option value="Erfurt">Erfurt</option>
                                            <option value="Erlangen">Erlangen</option>
                                            <option value="Essen">Essen</option>
                                            <option value="Flensburg">Flensburg</option>
                                            <option value="Frankenthal">Frankenthal</option>
                                            <option value="Frankfurt">Frankfurt</option>
                                            <option value="Frankfurt">Frankfurt</option>
                                            <option value="Freiburg">Freiburg</option>
                                            <option value="Fürth">Fürth</option>
                                            <option value="Gelsenkirchen">Gelsenkirchen</option>
                                            <option value="Gera">Gera</option>
                                            <option value="Görlitz">Görlitz</option>
                                            <option value="Greifswald">Greifswald</option>
                                            <option value="Hagen">Hagen</option>
                                            <option value="Halle">Halle</option>
                                            <option value="Hamburg">Hamburg</option>
                                            <option value="Hameln">Hameln</option>
                                            <option value="Hamm">Hamm</option>
                                            <option value="Hannover">Hannover</option>
                                            <option value="Heidelberg">Heidelberg</option>
                                            <option value="Heilbronn">Heilbronn</option>
                                            <option value="Herne">Herne</option>
                                            <option value="Hof">Hof</option>
                                            <option value="Homburg">Homburg</option>
                                            <option value="Hoyerswerda">Hoyerswerda</option>
                                            <option value="Husum">Husum</option>
                                            <option value="Ingolstadt">Ingolstadt</option>
                                            <option value="Jena">Jena</option>
                                            <option value="Kaiserslautern">Kaiserslautern</option>
                                            <option value="Karlsruhe">Karlsruhe</option>
                                            <option value="Kassel">Kassel</option>
                                            <option value="Kaufbeuren">Kaufbeuren</option>
                                            <option value="Kempten">Kempten</option>
                                            <option value="Kiel">Kiel</option>
                                            <option value="Koblenz">Koblenz</option>
                                            <option value="Konstanz">Konstanz</option>
                                            <option value="Köln">Köln</option>
                                            <option value="Krefeld">Krefeld</option>
                                            <option value="Landau">Landau</option>
                                            <option value="Landsberg am Lech">Landsberg am Lech</option>
                                            <option value="Landshut">Landshut</option>
                                            <option value="Leipzig">Leipzig</option>
                                            <option value="Leverkusen">Leverkusen</option>
                                            <option value="Ludwigshafen">Ludwigshafen</option>
                                            <option value="Lübeck">Lübeck</option>
                                            <option value="Magdeburg">Magdeburg</option>
                                            <option value="Mainz">Mainz</option>
                                            <option value="Mannheim">Mannheim</option>
                                            <option value="Memmingen">Memmingen</option>
                                            <option value="Merzig">Merzig</option>
                                            <option value="Mönchengladbach">Mönchengladbach</option>
                                            <option value="Münih">Münih</option>
                                            <option value="Münster">Münster</option>
                                            <option value="Neubrandenburg">Neubrandenburg</option>
                                            <option value="Neudsadt">Neudsadt</option>
                                            <option value="Neumünster">Neumünster</option>
                                            <option value="Neunkirchen">Neunkirchen</option>
                                            <option value="Nürnberg">Nürnberg</option>
                                            <option value="Oberhausen">Oberhausen</option>
                                            <option value="Offenbach">Offenbach</option>
                                            <option value="Oldenburg">Oldenburg</option>
                                            <option value="Osnabrück">Osnabrück</option>
                                            <option value="Paderborn">Paderborn</option>
                                            <option value="Passau">Passau</option>
                                            <option value="Pforzheim">Pforzheim</option>
                                            <option value="Pinneberg">Pinneberg</option>
                                            <option value="Pirmasens">Pirmasens</option>
                                            <option value="Plauen">Plauen</option>
                                            <option value="Potsdam">Potsdam</option>
                                            <option value="Regensburg">Regensburg</option>
                                            <option value="Remscheid">Remscheid</option>
                                            <option value="Reutlingen">Reutlingen</option>
                                            <option value="Rosenheim">Rosenheim</option>
                                            <option value="Rostock">Rostock</option>
                                            <option value="Saarbrücken">Saarbrücken</option>
                                            <option value="Saarlouis">Saarlouis</option>
                                            <option value="Salzgitter">Salzgitter</option>
                                            <option value="Sankt İngbert">Sankt İngbert</option>
                                            <option value="Sankt Wendel">Sankt Wendel</option>
                                            <option value="Schwabach">Schwabach</option>
                                            <option value="Schweinfurt">Schweinfurt</option>
                                            <option value="Schwerin">Schwerin</option>
                                            <option value="Solingen">Solingen</option>
                                            <option value="Speyer">Speyer</option>
                                            <option value="Stralsund">Stralsund</option>
                                            <option value="Straubing">Straubing</option>
                                            <option value="Stuttgart">Stuttgart</option>
                                            <option value="Suhl">Suhl</option>
                                            <option value="Trier">Trier</option>
                                            <option value="Tübingen">Tübingen</option>
                                            <option value="Ulm">Ulm</option>
                                            <option value="Weiden">Weiden</option>
                                            <option value="Weimar">Weimar</option>
                                            <option value="Wiesbaden">Wiesbaden</option>
                                            <option value="Wilhelmshaven">Wilhelmshaven</option>
                                            <option value="Wismar">Wismar</option>
                                            <option value="Wolfsburg">Wolfsburg</option>
                                            <option value="Worms">Worms</option>
                                            <option value="Wuppertal">Wuppertal</option>
                                            <option value="Würzburg">Würzburg</option>
                                            <option value="Zweibrücken">Zweibrücken</option>
                                            <option value="Zwickau">Zwickau</option>
                                        </select>
                                        <label class="form-sub-label"><?echo CITY;?> </label>
                                    </span>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left"></label>
                                <div class="form-input">
                                    <span class="form-sub-label-container">
                                        <select name="country" id="country_input" onchange="city_select_reg(this.value)">
                                                        <option selected="selected" value="Deutschland"> Deutschland </option>
                                                        <option value="Türkiye"> Türkiye </option>
                                                        <option value="Abkhazia"> Abkhazia </option>
                                                        <option value="Afghanistan"> Afghanistan </option>
                                                        <option value="Albania"> Albania </option>
                                                        <option value="Algeria"> Algeria </option>
                                                        <option value="American Samoa"> American Samoa </option>

                                                        <option value="Andorra"> Andorra </option>
                                                        <option value="Angola"> Angola </option>
                                                        <option value="Anguilla"> Anguilla </option>
                                                        <option value="Antigua and Barbuda"> Antigua and Barbuda </option>
                                                        <option value="Argentina"> Argentina </option>

                                                        <option value="Armenia"> Armenia </option>
                                                        <option value="Aruba"> Aruba </option>
                                                        <option value="Australia"> Australia </option>
                                                        <option value="Austria"> Austria </option>
                                                        <option value="Azerbaijan"> Azerbaijan </option>

                                                        <option value="The Bahamas"> The Bahamas </option>
                                                        <option value="Bahrain"> Bahrain </option>
                                                        <option value="Bangladesh"> Bangladesh </option>
                                                        <option value="Barbados"> Barbados </option>
                                                        <option value="Belarus"> Belarus </option>

                                                        <option value="Belgium"> Belgium </option>
                                                        <option value="Belize"> Belize </option>
                                                        <option value="Benin"> Benin </option>
                                                        <option value="Bermuda"> Bermuda </option>
                                                        <option value="Bhutan"> Bhutan </option>

                                                        <option value="Bolivia"> Bolivia </option>
                                                        <option value="Bosnia and Herzegovina"> Bosnia and Herzegovina </option>
                                                        <option value="Botswana"> Botswana </option>
                                                        <option value="Brazil"> Brazil </option>
                                                        <option value="Brunei"> Brunei </option>

                                                        <option value="Bulgaria"> Bulgaria </option>
                                                        <option value="Burkina Faso"> Burkina Faso </option>
                                                        <option value="Burundi"> Burundi </option>
                                                        <option value="Cambodia"> Cambodia </option>
                                                        <option value="Cameroon"> Cameroon </option>

                                                        <option value="Canada"> Canada </option>
                                                        <option value="Cape Verde"> Cape Verde </option>
                                                        <option value="Cayman Islands"> Cayman Islands </option>
                                                        <option value="Central African Republic"> Central African Republic </option>
                                                        <option value="Chad"> Chad </option>

                                                        <option value="Chile"> Chile </option>
                                                        <option value="People's Republic of China"> People's Republic of China </option>
                                                        <option value="Republic of China"> Republic of China </option>
                                                        <option value="Christmas Island"> Christmas Island </option>
                                                        <option value="Cocos (Keeling) Islands"> Cocos (Keeling) Islands </option>

                                                        <option value="Colombia"> Colombia </option>
                                                        <option value="Comoros"> Comoros </option>
                                                        <option value="Congo"> Congo </option>
                                                        <option value="Cook Islands"> Cook Islands </option>
                                                        <option value="Costa Rica"> Costa Rica </option>

                                                        <option value="Cote d'Ivoire"> Cote d'Ivoire </option>
                                                        <option value="Croatia"> Croatia </option>
                                                        <option value="Cuba"> Cuba </option>
                                                        <option value="Cyprus"> Cyprus </option>
                                                        <option value="Czech Republic"> Czech Republic </option>

                                                        <option value="Denmark"> Denmark </option>
                                                        <option value="Djibouti"> Djibouti </option>
                                                        <option value="Dominica"> Dominica </option>
                                                        <option value="Dominican Republic"> Dominican Republic </option>
                                                        <option value="Ecuador"> Ecuador </option>

                                                        <option value="Egypt"> Egypt </option>
                                                        <option value="El Salvador"> El Salvador </option>
                                                        <option value="Equatorial Guinea"> Equatorial Guinea </option>
                                                        <option value="Eritrea"> Eritrea </option>
                                                        <option value="Estonia"> Estonia </option>

                                                        <option value="Ethiopia"> Ethiopia </option>
                                                        <option value="Falkland Islands"> Falkland Islands </option>
                                                        <option value="Faroe Islands"> Faroe Islands </option>
                                                        <option value="Fiji"> Fiji </option>
                                                        <option value="Finland"> Finland </option>

                                                        <option value="France"> France </option>
                                                        <option value="French Polynesia"> French Polynesia </option>
                                                        <option value="Gabon"> Gabon </option>
                                                        <option value="The Gambia"> The Gambia </option>
                                                        <option value="Georgia"> Georgia </option>

                                                        <option value="Ghana"> Ghana </option>
                                                        <option value="Gibraltar"> Gibraltar </option>
                                                        <option value="Greece"> Greece </option>
                                                        <option value="Greenland"> Greenland </option>

                                                        <option value="Grenada"> Grenada </option>
                                                        <option value="Guam"> Guam </option>
                                                        <option value="Guatemala"> Guatemala </option>
                                                        <option value="Guernsey"> Guernsey </option>
                                                        <option value="Guinea"> Guinea </option>

                                                        <option value="Guinea-Bissau"> Guinea-Bissau </option>
                                                        <option value="Guyana Guyana"> Guyana Guyana </option>
                                                        <option value="Haiti Haiti"> Haiti Haiti </option>
                                                        <option value="Honduras"> Honduras </option>
                                                        <option value="Hong Kong"> Hong Kong </option>

                                                        <option value="Hungary"> Hungary </option>
                                                        <option value="Iceland"> Iceland </option>
                                                        <option value="India"> India </option>
                                                        <option value="Indonesia"> Indonesia </option>
                                                        <option value="Iran"> Iran </option>

                                                        <option value="Iraq"> Iraq </option>
                                                        <option value="Ireland"> Ireland </option>
                                                        <option value="Israel"> Israel </option>
                                                        <option value="Italy"> Italy </option>
                                                        <option value="Jamaica"> Jamaica </option>

                                                        <option value="Japan"> Japan </option>
                                                        <option value="Jersey"> Jersey </option>
                                                        <option value="Jordan"> Jordan </option>
                                                        <option value="Kazakhstan"> Kazakhstan </option>
                                                        <option value="Kenya"> Kenya </option>

                                                        <option value="Kiribati"> Kiribati </option>
                                                        <option value="North Korea"> North Korea </option>
                                                        <option value="South Korea"> South Korea </option>
                                                        <option value="Kosovo"> Kosovo </option>
                                                        <option value="Kuwait"> Kuwait </option>

                                                        <option value="Kyrgyzstan"> Kyrgyzstan </option>
                                                        <option value="Laos"> Laos </option>
                                                        <option value="Latvia"> Latvia </option>
                                                        <option value="Lebanon"> Lebanon </option>
                                                        <option value="Lesotho"> Lesotho </option>

                                                        <option value="Liberia"> Liberia </option>
                                                        <option value="Libya"> Libya </option>
                                                        <option value="Liechtenstein"> Liechtenstein </option>
                                                        <option value="Lithuania"> Lithuania </option>
                                                        <option value="Luxembourg"> Luxembourg </option>

                                                        <option value="Macau"> Macau </option>
                                                        <option value="Macedonia"> Macedonia </option>
                                                        <option value="Madagascar"> Madagascar </option>
                                                        <option value="Malawi"> Malawi </option>
                                                        <option value="Malaysia"> Malaysia </option>

                                                        <option value="Maldives"> Maldives </option>
                                                        <option value="Mali"> Mali </option>
                                                        <option value="Malta"> Malta </option>
                                                        <option value="Marshall Islands"> Marshall Islands </option>
                                                        <option value="Mauritania"> Mauritania </option>

                                                        <option value="Mauritius"> Mauritius </option>
                                                        <option value="Mayotte"> Mayotte </option>
                                                        <option value="Mexico"> Mexico </option>
                                                        <option value="Micronesia"> Micronesia </option>
                                                        <option value="Moldova"> Moldova </option>

                                                        <option value="Monaco"> Monaco </option>
                                                        <option value="Mongolia"> Mongolia </option>
                                                        <option value="Montenegro"> Montenegro </option>
                                                        <option value="Montserrat"> Montserrat </option>
                                                        <option value="Morocco"> Morocco </option>

                                                        <option value="Mozambique"> Mozambique </option>
                                                        <option value="Myanmar"> Myanmar </option>
                                                        <option value="Nagorno-Karabakh"> Nagorno-Karabakh </option>
                                                        <option value="Namibia"> Namibia </option>
                                                        <option value="Nauru"> Nauru </option>

                                                        <option value="Nepal"> Nepal </option>
                                                        <option value="Netherlands"> Netherlands </option>
                                                        <option value="Netherlands Antilles"> Netherlands Antilles </option>
                                                        <option value="New Caledonia"> New Caledonia </option>
                                                        <option value="New Zealand"> New Zealand </option>

                                                        <option value="Nicaragua"> Nicaragua </option>
                                                        <option value="Niger"> Niger </option>
                                                        <option value="Nigeria"> Nigeria </option>
                                                        <option value="Niue"> Niue </option>
                                                        <option value="Norfolk Island"> Norfolk Island </option>

                                                        <option value="Turkish Republic of Northern Cyprus"> Turkish Republic of Northern Cyprus </option>
                                                        <option value="Northern Mariana"> Northern Mariana </option>
                                                        <option value="Norway"> Norway </option>
                                                        <option value="Pakistan"> Pakistan </option>
                                                        <option value="Palau"> Palau </option>

                                                        <option value="Palestine"> Palestine </option>
                                                        <option value="Panama"> Panama </option>
                                                        <option value="Papua New Guinea"> Papua New Guinea </option>
                                                        <option value="Paraguay"> Paraguay </option>
                                                        <option value="Peru"> Peru </option>

                                                        <option value="Philippines"> Philippines </option>
                                                        <option value="Pitcairn Islands"> Pitcairn Islands </option>
                                                        <option value="Poland"> Poland </option>
                                                        <option value="Portugal"> Portugal </option>
                                                        <option value="Transnistria Pridnestrovie"> Transnistria Pridnestrovie </option>

                                                        <option value="Puerto Rico"> Puerto Rico </option>
                                                        <option value="Qatar"> Qatar </option>
                                                        <option value="Romania"> Romania </option>
                                                        <option value="Russia"> Russia </option>
                                                        <option value="Rwanda"> Rwanda </option>

                                                        <option value="Saint Barthelemy"> Saint Barthelemy </option>
                                                        <option value="Saint Helena"> Saint Helena </option>
                                                        <option value="Saint Kitts and Nevis"> Saint Kitts and Nevis </option>
                                                        <option value="Saint Lucia"> Saint Lucia </option>
                                                        <option value="Saint Martin"> Saint Martin </option>

                                                        <option value="Saint Pierre and Miquelon"> Saint Pierre and Miquelon </option>
                                                        <option value="Saint Vincent and the Grenadines"> Saint Vincent and the Grenadines </option>
                                                        <option value="Samoa"> Samoa </option>
                                                        <option value="San Marino"> San Marino </option>
                                                        <option value="Sao Tome and Principe"> Sao Tome and Principe </option>

                                                        <option value="Saudi Arabia"> Saudi Arabia </option>
                                                        <option value="Senegal"> Senegal </option>
                                                        <option value="Serbia"> Serbia </option>
                                                        <option value="Seychelles"> Seychelles </option>
                                                        <option value="Sierra Leone"> Sierra Leone </option>

                                                        <option value="Singapore"> Singapore </option>
                                                        <option value="Slovakia"> Slovakia </option>
                                                        <option value="Slovenia"> Slovenia </option>
                                                        <option value="Solomon Islands"> Solomon Islands </option>
                                                        <option value="Somalia"> Somalia </option>

                                                        <option value="Somaliland"> Somaliland </option>
                                                        <option value="South Africa"> South Africa </option>
                                                        <option value="South Ossetia"> South Ossetia </option>
                                                        <option value="Spain"> Spain </option>
                                                        <option value="Sri Lanka"> Sri Lanka </option>

                                                        <option value="Sudan"> Sudan </option>
                                                        <option value="Suriname"> Suriname </option>
                                                        <option value="Svalbard"> Svalbard </option>
                                                        <option value="Swaziland"> Swaziland </option>
                                                        <option value="Sweden"> Sweden </option>

                                                        <option value="Switzerland"> Switzerland </option>
                                                        <option value="Syria"> Syria </option>
                                                        <option value="Taiwan"> Taiwan </option>
                                                        <option value="Tajikistan"> Tajikistan </option>
                                                        <option value="Tanzania"> Tanzania </option>

                                                        <option value="Thailand"> Thailand </option>
                                                        <option value="Timor-Leste"> Timor-Leste </option>
                                                        <option value="Togo"> Togo </option>
                                                        <option value="Tokelau"> Tokelau </option>
                                                        <option value="Tonga"> Tonga </option>

                                                        <option value="Trinidad and Tobago"> Trinidad and Tobago </option>
                                                        <option value="Tristan da Cunha"> Tristan da Cunha </option>
                                                        <option value="Tunisia"> Tunisia </option>
                                                        <option value="Turkmenistan"> Turkmenistan </option>

                                                        <option value="Turks and Caicos Islands"> Turks and Caicos Islands </option>
                                                        <option value="Tuvalu"> Tuvalu </option>
                                                        <option value="Uganda"> Uganda </option>
                                                        <option value="Ukraine"> Ukraine </option>
                                                        <option value="United Arab Emirates"> United Arab Emirates </option>

                                                        <option value="United Kingdom"> United Kingdom </option>
                                                        <option value="United States"> United States </option>
                                                        <option value="Uruguay"> Uruguay </option>
                                                        <option value="Uzbekistan"> Uzbekistan </option>
                                                        <option value="Vanuatu"> Vanuatu </option>

                                                        <option value="Vatican City"> Vatican City </option>
                                                        <option value="Venezuela"> Venezuela </option>
                                                        <option value="Vietnam"> Vietnam </option>
                                                        <option value="British Virgin Islands"> British Virgin Islands </option>
                                                        <option value="US Virgin Islands"> US Virgin Islands </option>

                                                        <option value="Wallis and Futuna"> Wallis and Futuna </option>
                                                        <option value="Western Sahara"> Western Sahara </option>
                                                        <option value="Yemen"> Yemen </option>
                                                        <option value="Zambia"> Zambia </option>
                                                        <option value="Zimbabwe"> Zimbabwe </option>

                                                        <option value="other"> Other </option>
                                                    </select>
                                        <label class="form-sub-label" for="country_input"> <?echo COUNTRY;?> </label>
                                    </span>
                                </div>
                            </li>
                            <li id="birthdate_li" class="form-line">
                                <label class="form-label-left" for="birthdate">
                                    <?echo BIRTH_DATE;?>:
                                </label>
                                <div class="form-input"><span class="form-sub-label-container"><select name="day" id="day_input">
                                            <option>  </option>
                                            <?for($month_val = 31; $month_val > 0; $month_val--) echo "<option value='$month_val'> $month_val </option>"?>
                                        </select>
                                        <label class="form-sub-label" for="day_input"> <?echo DAY;?> </label></span><span class="form-sub-label-container"><select name="month" id="month_input">
                                            <option>  </option>
                                            <option value="01"> <?echo JANUARY;?> </option>
                                            <option value="02"> <?echo FEBRUARY;?> </option>
                                            <option value="03"> <?echo MARCH;?> </option>
                                            <option value="04"> <?echo APRIL;?> </option>
                                            <option value="05"> <?echo MAY;?> </option>
                                            <option value="06"> <?echo JUNE;?> </option>
                                            <option value="07"> <?echo JULY;?> </option>
                                            <option value="08"> <?echo AUGUST;?> </option>
                                            <option value="09"> <?echo SEPTEMBER;?> </option>
                                            <option value="10"> <?echo OCTOBER;?> </option>
                                            <option value="11"> <?echo NOVEMBER;?> </option>
                                            <option value="12"> <?echo DECEMBER;?> </option>
                                        </select>
                                        <label class="form-sub-label" for="month_input"> <?echo MONTH;?> </label></span><span class="form-sub-label-container"><select name="year" id="year_input">
                                            <option>  </option>
                                            <?for($year_val = 2010; $year_val>=1910; $year_val--) echo "<option value='$year_val'> $year_val </option>"?>
                                        </select>
                                        <label class="form-sub-label" for="year_input"> <?echo YEAR;?> </label></span>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left" for="phone_input">
                                    <?echo PHONE_NUMBER;?>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input"><span class="form-sub-label-container"><input type="text" name="areacode" id="areacode_input" size="3">
                                        -
                                        <label class="form-sub-label" for="area_input"> <?echo AREA_CODE;?> </label></span><span class="form-sub-label-container"><input type="text" name="phone" id="phone_input" size="8">
                                        <label class="form-sub-label" for="phone_input"> <?echo PHONE;?> </label></span>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left" for="phone_input">
                                    <?echo FAX_NUMBER;?>:
                                </label>
                                <div class="form-input"><span class="form-sub-label-container"><input type="text" name="fareacode" id="areacode_input" size="3">
                                        -
                                        <label class="form-sub-label"> <?echo AREA_CODE;?> </label></span><span class="form-sub-label-container"><input type="text" name="fax" id="phone_input" size="8">
                                        <label class="form-sub-label"> <?echo FAX;?> </label></span>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left" for="phone_input">
                                    <?echo MOBILE_NUMBER;?>:
                                </label>
                                <div class="form-input"><span class="form-sub-label-container"><input type="text" name="mareacode" id="areacode_input" size="3">
                                        -
                                        <label class="form-sub-label"> <?echo AREA_CODE;?> </label></span><span class="form-sub-label-container"><input type="text" name="mobile" id="phone_input" size="8">
                                        <label class="form-sub-label"> <?echo MOBILE;?> </label></span>
                                </div>
                            </li>
                            <li id="website_li" class="form-line" style="display:none">
                                <label class="form-label-left">
                                    <?echo WEB_PAGE;?>:
                                </label>
                                <div class="form-input">
                                    <input type="text" name="website" size="40"/>
                                </div>
                            </li>
                            <li id="logo_li" class="form-line" style="display:none">
                                <label class="form-label-left">
                                    <?echo LOGO;?>:
                                </label>
                                <div class="form-input">
                                    <input type="file" name="logo" />
                                </div>
                            </li>
                            <li id="impressum_li" class="form-line" style="display:none">
                                <label class="form-label-left">
                                    <?echo IMPRESSUM;?>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input">
                                    <textarea class="jquery_ckeditor" name="impressum" rows="8"></textarea>
                                </div>
                            </li>
                            <li class="form-line">
                                <label class="form-label-left" for="captcha_input">
                                    <?echo PLEASE_ENTER_CAPTCHA;?>:<span class="form-required">*</span>
                                </label>
                                <div class="form-input">
                                    <div class="form-captcha">
                                        <?php
                                        require_once('recaptcha/recaptchalib.php');

                                        //recaptcha keys
                                        $publickey = "6LeLlrsSAAAAAHX_uYZTeoETCFCNidW-NuZDPjlC";
                                        $privatekey = "6LeLlrsSAAAAAJmH4gG0Y87ApXRsJciH8yqsGn8P";

                                        echo recaptcha_get_html($publickey, $error);
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <li class="form-line">

                                <div class="form-input-wide">
                                    <div style="margin-left:156px">
                                        <button id="button1" type="submit" class="form-submit-button">
                                            <?echo SUBMIT;?>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <?php

        ?>
    </body>
</html>

<script type="text/javascript">
    function change_fields(litmus) {
        if(litmus == "human") {
            document.getElementById("user_firm").style.display="inline";
            document.getElementById("user_firm2").style.display="none";
            document.getElementById("website_li").style.display = "none";
            document.getElementById("impressum_li").style.display = "none";
            document.getElementById("logo_li").style.display = "none";
            document.getElementById("birthdate_li").style.display = "block";
        }
        if(litmus == "firm")  {
            document.getElementById("user_firm").style.display="none";
            document.getElementById("user_firm2").style.display="inline";
            document.getElementById("website_li").style.display = "block";
            document.getElementById("impressum_li").style.display = "block";
            document.getElementById("logo_li").style.display = "block";
            document.getElementById("birthdate_li").style.display = "none";
        }
    }
</script>