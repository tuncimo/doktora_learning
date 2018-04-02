<?php
        session_start();
        ob_start();
        $ref = $_SERVER['HTTP_REFERER'];

        //bakılacak****************************
        //if($ref == "http://localhost/tdb_web/admin_ads.php") {
        //    $_SESSION[username] = "TDB";
        //}
        if(isset($_SESSION[username])) {
            $user_signed_in = true;
        }
        else {
            $user_signed_in = false;
        }
        include 'connection.php';
        include_once 'common.php';
        include_once 'format_date.php';

        if(isset($_GET['lin'])) $lin = $_GET['lin'];
        else $lin = "main";

        if($lin == "edit"){
            $query = mysql_query("SELECT * FROM users WHERE username='$_SESSION[username]'");
            $user = mysql_fetch_assoc($query);
        }
        if($lin == "myads") {
            $query = mysql_query("SELECT * FROM users WHERE username='$_SESSION[username]'");
            $user = mysql_fetch_assoc($query);
            $query = mysql_query("SELECT * FROM property WHERE users_id='$user[id]'");
            while($row = mysql_fetch_assoc($query)){
                $property[] = $row; 
            }
        }
        if($lin == "favs") {
            $query = mysql_query("SELECT * FROM users WHERE username='$_SESSION[username]'");
            $user = mysql_fetch_assoc($query);
            $query = mysql_query("SELECT * FROM favourites WHERE users_id='$user[id]'");
            while($row = mysql_fetch_assoc($query)){
                $query2 = mysql_query("SELECT * FROM property WHERE id=$row[property_id]");
                while($row2 = mysql_fetch_assoc($query2)) $property[] = $row2;
            }
        }
        if($lin == "pedit") {
            if(isset($_GET['pid'])) $pid = $_GET['pid'];
            $query = mysql_query("SELECT * FROM property WHERE id='$pid'");
            $property = mysql_fetch_assoc($query);
        }
        if($lin == "pelete") {
            if(isset ($_GET['pdid'])) $pdid = $_GET['pdid'];
            if(isset ($_GET['udid'])) $udid = $_GET['udid'];
            if($_SESSION[id] == $udid) {
                mysql_query("DELETE FROM property_has_detail WHERE property_id=$pdid");
                $query = mysql_query("SELECT * FROM photos where property_id=$pdid");
                while($row = mysql_fetch_assoc($query)) unlink($row[url]);
                $query = mysql_query("SELECT * FROM videos where property_id=$pdid");
                while($row = mysql_fetch_assoc($query)) unlink($row[url]);

                mysql_query("DELETE FROM photos WHERE property_id=$pdid");
                mysql_query("DELETE FROM videos WHERE property_id=$pdid");
                mysql_query("DELETE FROM property WHERE id=$pdid");

                header("location:myaccount.php?lin=myads");
            }
            else echo "<h1>".YOURE_NOT_AUTHORIZED."</h1>";
        }
        if($lin == "felete") {
            if(isset ($_GET['pdid'])) $pdid = $_GET['pdid'];
            if(isset ($_GET['udid'])) $udid = $_GET['udid'];
            if($_SESSION[id] == $udid) {
                mysql_query("DELETE FROM favourites WHERE property_id=$pdid AND users_id=$udid");

                header("location:myaccount.php?lin=favs");
            }
            else echo "<h1>". YOURE_NOT_AUTHORIZED ."</h1>";
        }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo MY_ACCOUNT?></title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="stylesheet" type="text/css" href="stylesheets/form.css"/>
        <?if($lin=="myads" || $lin == "favs"){?><link rel="stylesheet" type="text/css"  href="stylesheets/gray_table.css"/><?}?>
        <script type="text/javascript" src="scripts/form_validate.js"></script>

        <script type="text/javascript" src="scripts/city_select.js"></script>

        <script type="text/javascript">
            var GB_ROOT_DIR = "greybox/greybox/";
        </script>
        <script type="text/javascript" src="greybox/greybox/AJS.js"></script>
        <script type="text/javascript" src="greybox/greybox/AJS_fx.js"></script>
        <script type="text/javascript" src="greybox/greybox/gb_scripts.js"></script>
        <link href="greybox/greybox/gb_styles.css" rel="stylesheet" type="text/css" />

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
    <body onload="city_select_my(<?print($user[country])?>); document.register_form.city.options[t] = new Option('<?print($user[city])?>','<?print($user[city])?>',false,true)">
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
            <div id="myaccount_main_content">
                <?
                if ($user_signed_in == true) {
                if ($lin == "main") {
                ?>
                <div class="form-header-group">
                    <h2 class="form-header"><?echo MY_ACCOUNT;?></h2>
                </div>
                <h2 class="salutation"><?echo HELLO;?> <?print($_SESSION['username'].",")?></h2>
                <center>
                <div id="myaccount_settings">
                    <table align="center">
                        <tr>
                            <td class="settings_icon"><a href="?lin=edit"><img class="my_icons" src="resimler/icons/micro.png" /><br/><?echo PERSONAL_INFORMATION?></a></td>
                            <td class="settings_icon"><a href="?lin=myads"><img class="my_icons" src="resimler/icons/scrool.png" /><br/><?echo MY_ADVERTISEMENTS?></a></td>
                            <td class="settings_icon"><a href="?lin=favs"><img class="my_icons" src="resimler/icons/phone.png" /><br/><?echo MY_FAVS?></a></td>
                        </tr>
                    </table>
                </div>
                </center>
                <? } if($lin == "edit") {?>
                <div class="form-header-group">
                    <h2 class="form-header"><?echo PERSONAL_INFORMATION;?></h2>
                </div>
                <div id="myaccount_icon" style="padding-left:40px">
                    
                    <? if($user[human] == 0) echo "<img src='resimler/icons/profi.png' />";
                    else { ?>
                        <form action="logo_change.php" enctype="multipart/form-data" method="post">
                            <?if($user[logo_url] != "") {?><img id='logo_image' style='width:180px' src='<?print($user[logo_url])?>' /> <? } ?>
                            <br/><img style="height:12px; margin-right:4px" src="resimler/icons/yildiz.png">
                            <a style="cursor:pointer" onclick="document.getElementById('logon').style.display='block';document.getElementById('logon_s').style.display='block'; style.display='none'"><? if($user[logo_url] != "") echo CHANGE_LOGO; else echo ADD_LOGO; ?></a>
                            <input id="logon" type="file" name="logo" style="display:none"/>
                            <input id="logon_s" type="submit" name="logon_s" value="<?echo SUBMIT;?>" style="display:none"/>
                        </form>
                    <? } ?>
                </div>
                <div id="myaccount_edit2">
                    <form action="myaccount_submit.php" name="register_form" method="post" onsubmit="return validateMyAccountRegisterForm(this)">
                        <table>
                            <tr>
                                <td width="200"><?if($user[human] == 0) echo USERNAME; else echo FIRM_NAME;?>:</td>
                                <td><input type="text" name="username" disabled="true" value="<?print($user[username])?>"/></td>
                            </tr>
                            <tr>
                                <td><?echo SALUTATION;?>:</td>
                                <td>
                                    <select name="salutation">
                                        <option <?if($user[salutation] == "") echo "selected='selected'"?>></option>
                                        <option value="MR" <?if($user[salutation] == "MR") echo "selected='selected'"?>><?echo MR;?></option>
                                        <option value="MRS" <?if($user[salutation] == "MRS") echo "selected='selected'"?>><?echo MRS;?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?echo FIRST_NAME;?>:</td>
                                <td><input type="text" name="firstname" value="<?print($user[firstname])?>"/></td>
                            </tr>
                            <tr>
                                <td><?echo LAST_NAME;?>:</td>
                                <td><input type="text" name="lastname" value="<?print($user[lastname])?>"/></td>
                            </tr>
                            <tr>
                                <td><?echo PASSWORD;?>:</td>
                                <td><input type="password" name="password" value="<?print($user[password])?>"/></td>
                            </tr>
                            <tr>
                                <td><?echo PASSWORD_AGAIN;?>:</td>
                                <td><input type="password" name="password2" value="<?print($user[password])?>"/></td>
                            </tr>
                            <tr>
                                <td><?echo ADDRESS;?>:</td>
                                <td><input type="text" name="street" value="<?print($user[street])?>"/> <input type="text" name="number" size="1" value="<?print($user[number])?>"/></td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td><input type="text" name="postcode" size="5" value="<?print($user[postcode])?>"/> <select name="city"></select> </td>
                            </tr>
                            <tr>
                                <td><?echo COUNTRY;?>:</td>
                                <td>
                                    <select name="country" onchange="city_select_my(this.value)">
                                        <option selected="selected" value="<?print($user[country])?>"><?print($user[country])?></option>
                                        <option value="Deutschland"> Deutschland </option>
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
										<option value="Turkey"> Turkey </option>
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

                                        <option value="other"> <?echo OTHER;?> </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?echo TELEPHONE?>:</td>
                                <td>(<input type="text" name="areacode" size="1" value="<?print($user[areacode])?>">) - <input type="text" name="phone" size="5" value="<?print($user[phone])?>"></td>
                            </tr>
                            <tr>
                                <td><?echo FAX;?>:</td>
                                <td>(<input type="text" name="fareacode" size="1" value="<?print($user[fareacode])?>">) - <input type="text" name="fax" size="5" value="<?print($user[fax])?>" </td>
                            </tr>
                            <tr>
                                <td><?echo MOBILE;?>:</td>
                                <td>(<input type="text" name="mareacode" size="1" value="<?print($user[mareacode])?>">) - <input type="text" name="mobile" size="5" value="<?print($user[mobile])?>" </td>
                            </tr>
                            <?if($user[human] == 1) {?>
                            <tr>
                                <td><? echo WEB_PAGE; ?>:</td>
                                <td><input type="text" name="webpage" value="<?print($user[webpage])?>" /></td>
                            </tr>
                            <tr>
                                <td><? echo IMPRESSUM; ?>:</td>
                                <td><textarea class="jquery_ckeditor" name="impressum" rows="8"><?print($user[impressum])?></textarea></td>
                            </tr>
                            <? } ?>
                            <tr>
                                <td></td>
                                <td><input name="edit_profile" type="submit" value="Onayla"/></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <? } if($lin == "myads") {?>
                <div class="form-header-group">
                    <h2 class="form-header"><?echo MY_ADVERTISEMENTS;?></h2>
                </div>
                <div id="myaccount_myads">
                    <? if(count($property) > 0) { ?>
                    <table width="100%">
                        <tr>
                            <th><?echo PHOTOS;?></th>
                            <th><?echo CATEGORY;?></th>
                            <th><?echo TITLE;?></th>
                            <th><?echo NUMBER_OF_ROOMS;?></th>
                            <th><?echo NUMBER_OF_BATHROOMS;?></th>
                            <th><?echo PRICE;?></th>
                            <th><?echo AD_DATE;?></th>
                            <th><?echo CITY;?></th>
                            <th><?echo VIEW;?></th>
                            <th><?echo MODIFY;?></th>
                            <th><?echo DELETE;?></th>
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
                            <td><a href="ad.php?id=<?print($p[id])?>"><?echo VIEW;?></a></td>
                            <td><a href="?lin=pedit&pid=<?echo $p[id]?>"><?echo MODIFY;?></a></td>
                            <td><a href="?lin=pelete&pdid=<?echo $p[id]?>&udid=<?echo $p[users_id]?>" onclick="return confirm('<?echo ARE_YOU_SURE?>?')"><?echo DELETE;?></a></td>
                        </tr>
                        <?}?>
                    </table>
                    <? } else echo "<h3 style='padding:10px'>".YOU_DONT_HAVE_AD."</h3>" ?>
                </div>
                <? } if($lin == "favs") { ?>
                <div class="form-header-group">
                    <h2 class="form-header"><?echo MY_FAVS;?></h2>
                </div>
                <div id="myaccount_myads">
                    <? if(count($property) > 0) { ?>
                    <table width="100%">
                        <tr>
                            <th><?echo PHOTOS;?></th>
                            <th><?echo CATEGORY;?></th>
                            <th><?echo TITLE;?></th>
                            <th><?echo NUMBER_OF_ROOMS;?></th>
                            <th><?echo NUMBER_OF_BATHROOMS;?></th>
                            <th><?echo PRICE;?></th>
                            <th><?echo AD_DATE;?></th>
                            <th><?echo CITY;?></th>
                            <th><?echo VIEW;?></th>
                            <th><?echo DELETE;?></th>
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
                            <td><a href="ad.php?id=<?print($p[id])?>"><?echo VIEW;?></a></td>
                            <td><a href="?lin=felete&pdid=<?echo $p[id]?>&udid=<?echo $_SESSION[id]?>" onclick="return confirm('<?echo ARE_YOU_SURE?>?')"><?echo DELETE;?></a></td>
                        </tr>
                        <?}?>
                    </table>
                    <? } else echo "<h3 style='padding:10px'>".YOU_DONT_HAVE_FAVS."</h3>" ?>
                </div>
                <? } if($lin == "pedit") {
                        if($_SESSION[id] == $property[users_id]) {
                ?>
                <div class="form-header-group">
                    <h2 class="form-header"><?echo MODIFY_AD;?></h2>
                </div>
                <?$_SESSION[insert_id] = $pid;?>
                <div id="myaccount_icon2">
                    <img src="resimler/icons/bprint.png" style="padding-bottom:25px"/>
                    <a href="insert_main.php?insert=<?print($pid)?>&i=main" rel="gb_page_center[800,600]"><?echo PHOTO_ADD_DELETE;?></a>
                    <a href="insert_video.php?insert=<?print($pid)?>" rel="gb_page_center[600,500]"><?echo VIDEO_ADD_DELETE?></a>
                    <a href="new_ad3.php"><?echo MODIFY_PROPERTIES;?></a>
                </div>
                <div id="myaccount_edit">
                    <form action="myaccount_submit.php" name="pedit_form" method="post" onsubmit="return validatePeditForm(this)">
                        <table>
                            <tr>
                                <td><?echo CATEGORY;?>:</td>
                                <td>
                                    <input id="mieten" type="radio" name="type" value="vermieten" <?if($property[category] == "vermieten") echo "checked='true'"?>/> <label class="label" for="vermieten"><?echo FOR_RENT;?></label>
                                    <input id="kaufen" type="radio" name="type" value="verkaufen" <?if($property[category] == "verkaufen") echo "checked='true'"?>/> <label class="label" for="verkaufen"><?echo FOR_SALE;?></label>
                                </td>
                            </tr>
                            <tr>
                                <td width="160"><?echo TITLE;?>:</td>
                                <td><input type="text" name="title" size="50" value="<?print($property[title])?>"/></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top"><?echo ADDRESS;?>:</td>
                                <td>
                                    <?print($property[street]." ".$property[house_no].",")?> <br/>
                                    <?print($property[postcode]." ".$property[city])?> <br/>
                                    <?print($property[country])?>
                                </td>
                            </tr>
							<tr>
								<td style="vertical-align:top"><?echo HIDE_ADDRESS;?>:</td>
								<td>
									<input id="show" type="radio" name="secrecy" value="show" <?if($property[address_sec] == 0) echo "checked='true'"?> /> <label class="label" for="show"><?echo SHOW;?></label>
									<input id="hide" type="radio" name="secrecy" value="hide" <?if($property[address_sec] == 1) echo "checked='true'"?> /> <label class="label" for="hide"><?echo HIDE;?></label>
								</td>
							</tr>
                            <tr>
                                <td style="vertical-align:top"><?echo DESCRIPTION;?>:</td>
                                <td>
                                    <div class="form-input" style="width:460px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; border:1px solid #4682B4">
                                    <textarea class="jquery_ckeditor" name="description" rows="10" cols="55"><?print($property[description])?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top"><?echo LOCATION;?>:</td>
                                <td>
                                    <div class="form-input" style="width:460px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; border:1px solid #93DFB8">
                                    <textarea class="jquery_ckeditor" name="location" rows="10" cols="55"><?print($property[location])?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top"><?echo FURNITURE;?>:</td>
                                <td>
                                    <div class="form-input" style="width:460px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; border:1px solid #FFBF00">
                                    <textarea class="jquery_ckeditor" name="equipment" rows="10" cols="55"><?print($property[equipment])?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top"><?echo OTHER;?>:</td>
                                <td>
                                    <div class="form-input" style="width:460px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; border:1px solid #FF2400">
                                    <textarea class="jquery_ckeditor" name="other" rows="10" cols="55"><?print($property[other])?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?echo NUMBER_OF_ROOMS;?>:</td>
                                <td> 
                                    <input type="text" name="nb_rooms" size="1" value="<?print($property[nb_rooms])?>"/>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?echo NUMBER_OF_BATHROOMS?>: &nbsp;&nbsp;&nbsp;<input type="text" name="nb_bathrooms" size="1" value="<?print($property[nb_bathrooms])?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td> <?echo FLOOR;?>: </td>
                                <td> 
                                    <input type="text" name="floor" size="1" value="<?print($property[floor])?>"/>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?echo LIVING_SPACE;?>: &nbsp;&nbsp;<input type="text" name="living_space" size="2" value="<?print($property[living_space])?>"/>m<sup>2</sup>
                                </td>
                            </tr>
                            <tr>
                                <td><?echo HEATING;?>:</td>
                                <td>
                                    <select name="heating">
                                        <option value=""><?echo SELECT;?>:</option>
                                        <option <?if($property[heating] == 'NONE') echo "selected='true'"?> value="NONE"><?echo NONE;?></option>
                                        <option <?if($property[heating] == 'NATURAL_GAS') echo "selected='true'"?> value="NATURAL_GAS"><?echo NATURAL_GAS?></option>
                                        <option <?if($property[heating] == 'CEN_SYSTEM') echo "selected='true'"?>value="CEN_SYSTEM"><?echo CEN_SYSTEM?></option>
                                        <option <?if($property[heating] == 'AIR_CONDITIONER') echo "selected='true'"?>value="AIR_CONDITIONER"><?echo AIR_CONDITIONER?></option>
                                        <option <?if($property[heating] == 'SOLAR_ENERGY') echo "selected='true'"?>value="SOLAR_ENERGY"><?echo SOLAR_ENERGY?></option>
                                    </select>
                                </td>
                            </tr>
                            <?/*
                            $pos = strpos($property[price], " ");
                            $nprice = substr($property[price], 0, $pos);
                            $currency = trim(substr($property[price], $pos));
                            */?>
                            <tr>
                                <td><?echo PRICE;?>:</td>
                                <td>
                                    <input type="text" name="price" size="7" value="<?print($property[price])?>" />EUR
                                    <!--<select name="currency1">
                                        <option <?/*if($currency == 'EUR') echo "selected='true'"?> value="EUR">EUR</option>
                                        <option <?if($currency == 'TRY') echo "selected='true'"?> value="TRY">TRY</option>
                                        <option <?if($currency == 'USD') echo "selected='true'"?> value="USD">USD</option>
                                        <option <?if($currency == 'GBP') echo "selected='true'"*/?> value="GBP">GBP</option>
                                    </select>-->
                                </td>
                            </tr>
							<tr>
                                <td><?echo COMMISSION;?>:</td>
                                <td>
                                    <input type="text" name="commission" size="7" value="<?print($property[commission])?>" />EUR
                                </td>
                            </tr>
                            <? 
                            if($property[category] == "vermieten") {
                                /*$pos = strpos($property[deposit], " ");
                                $ndeposit = substr($property[deposit], 0, $pos);
                                $currency2 = trim(substr($property[deposit], $pos));

                                $pos = strpos($property[charges], " ");
                                $ncharges = substr($property[charges], 0, $pos);
                                $currency3 = trim(substr($property[charges], $pos));
                            */?>
                            <tr>
                                <td><?echo DEPOSIT;?>:</td>
                                <td>
                                    <input type="text" name="deposit" size="7" value="<?print($property[deposit])?>" />EUR
                                    <!--<select name="currency2">
                                        <option <?/*if($currency2 == 'EUR') echo "selected='true'"?> value="EUR">EUR</option>
                                        <option <?//if($currency2 == 'TRY') echo "selected='true'"?> value="TRY">TRY</option>
                                        <option <?if($currency2 == 'USD') echo "selected='true'"?> value="USD">USD</option>
                                        <option <?if($currency2 == 'GBP') echo "selected='true'"*/?> value="GBP">GBP</option>
                                    </select>-->
                                </td>
                            </tr>
                            <tr>
                                <td><?echo CHARGES;?>:</td>
                                <td>
                                    <input type="text" name="charges" size="7" value="<?print($property[charges])?>" />EUR
                                    <!--<select name="currency3">
                                        <option <?/*if($currency3 == 'EUR') echo "selected='true'"?> value="EUR">EUR</option>
                                        <option <?if($currency3 == 'TRY') echo "selected='true'"?> value="TRY">TRY</option>
                                        <option <?if($currency3 == 'USD') echo "selected='true'"?> value="USD">USD</option>
                                        <option <?if($currency3 == 'GBP') echo "selected='true'"*/?> value="GBP">GBP</option>
                                    </select>-->
                                </td>
                            </tr>
                            <? } ?>
                            <tr>
                                <td></td>
                                <td align="right"><input type="submit" name="edit_property" value="<?echo SUBMIT;?>" /></td>
                            </tr>
                        </table>
                        <input type="hidden" name="pid" value="<?print($pid)?>">
                        <input type="hidden" name="p_userid" value="<?print($property[users_id])?>"
                    </form>
                </div>
                <? }else die(YOURE_NOT_AUTHORIZED); }  } else { ?>
                <form id="signin_form" action="check_login.php" method="post" style="padding-bottom:50px">
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
            <? } ?>
            </div>
        </div>
    </body>
</html>
<?ob_end_flush()?>