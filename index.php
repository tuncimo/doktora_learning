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

        $query = mysql_query("SELECT property.id, photos.url FROM property,photos WHERE property.id=photos.property_id AND property.approved=1 GROUP BY property_id ORDER BY property.id desc LIMIT 0,3");
        while ($row = mysql_fetch_assoc($query)) {
            $property[] = $row;
        }

        if(count($property) != 0) {
            foreach ($property as $p) {
            $query = mysql_query("SELECT * FROM photos WHERE property_id=$p[id]");
            $row = mysql_fetch_assoc($query);
            $photos[] = $row;
            }
        }
        $query_news = mysql_query("SELECT * FROM news ORDER by date desc LIMIT 0,3");
        while ($row = mysql_fetch_assoc($query_news)) {
            $news[] = $row;
        }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> TDB Immobilien GmbH</title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="shortcut icon" type="image/x-icon" href="resimler/hou.ico">
        <script type="text/javascript" src="scripts/form_validate.js"></script>
        <script type="text/javascript" src="scripts/city_select.js"></script>

        <script type="text/javascript">
            var GB_ROOT_DIR = "greybox/greybox/";
        </script>

        <script type="text/javascript" src="greybox/greybox/AJS.js"></script>
        <script type="text/javascript" src="greybox/greybox/AJS_fx.js"></script>
        <script type="text/javascript" src="greybox/greybox/gb_scripts.js"></script>
        <link href="greybox/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
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
                <li class="current"><a href="index.php" title="<?echo MAIN_PAGE?>"><?echo MAIN_PAGE; ?></a></li>
                <li><a href="about_us.php" title="<?echo ABOUT_US?>"><?echo ABOUT_US_HEADER; ?></a></li>
                <li><a href="ads.php" title="<?echo ADVERTISEMENTS?>"><?echo ADVERTISEMENTS; ?></a></li>
                <li><a href="service.php" title="<?echo SERVICE?>"><?echo SERVICE; ?></a></li>
                <li><a href="contact.php" title="<?echo CONTACT?>"><?echo CONTACT; ?></a></li>
                <li><a href="new_ad.php" title="<?echo ADVERTISE?>"><?echo ADVERTISE; ?></a>
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
            <div id="index_sidebar_right">
                <div class="sidebar_content">
                    <div class="bar_header">
                        <h3><?echo USER_LOGIN;?></h3>
                    </div>
                    <div id="index_bar_content">
                        <? if($user_signed_in==false) {?>
                        <form class="sign_form" action="check_login.php" method="post">
                            <?echo USERNAME;?>:<input class="same_size" type="text" size="20" name="myusername"/> <br/>
                            <?echo PASSWORD;?>: <br/><input class="same_size" autocomplete="off" type="password" size="20" name="mypassword"/> <br/>
                            <input type="submit" value="<?echo SIGN_IN?>" /> <br/>
                            <a href="register.php" style="margin-left:108px"><?echo REGISTER?></a>
                        </form>
                        <? } else { ?>
                        <h2><center><?echo LOGGED_IN_AS." ";?><?print($_SESSION['username'])?> </center></h2>
                        <form id="giris_form" action="logout.php" method="post" style="margin:40px 0 0 60px">
                        <input id="index_log_out" type="submit" value="<?echo SIGN_OUT?>" name="log_out"/>
                        </form>
                        <? } ?>
                    </div>
                </div>
                <div class="sidebar_content" style="margin-top:10px">
                    <div class="bar_header">
                        <h3><?echo FOR_SALE;?></h3>
                    </div>
                    <div id="index_bar_content">
                        <ul>
                        <li style="list-style-image:url('resimler/icons/1.png')"><a href="ads.php?ptype=HOUSE&cat=verkaufen"><span><?echo HOUSE;?></span></a></li>
                        <li style="list-style-image:url('resimler/icons/apart.png')"><a href="ads.php?ptype=APARTMENT&cat=verkaufen"><span><?echo APARTMENT;?></span></a></li>
                        <li style="list-style-image:url('resimler/icons/yaprak.png')"><a href="ads.php?ptype=LOT&cat=verkaufen"><span><?echo LOT;?></span></a></li>
                        <li style="list-style-image:url('resimler/icons/office.png')"><a href="ads.php?ptype=WORKPLACE&cat=verkaufen"><span><?echo WORKPLACE;?></span></a></li>
                        <li style="list-style-image:url('resimler/icons/kapital.png')"><a href="ads.php?ptype=CAPITAL&cat=verkaufen"><span><?echo CAPITAL;?></span></a></li>
                        <li style="list-style-image:url('resimler/icons/dunya.png')"><a href="ads.php?ptype=ABROAD&cat=verkaufen"><span><?echo ABROAD;?></span></a></li>
                        </ul>
                    </div>
                    <div class="bar_header">
                        <h3><?echo FOR_RENT;?></h3>
                    </div>
                    <div id="index_bar_content">
                        <ul>
                        <li style="list-style-image:url('resimler/icons/1.png')"><a href="ads.php?ptype=HOUSE&cat=vermieten"><span><?echo HOUSE;?></span></a></li>
                        <li style="list-style-image:url('resimler/icons/apart.png')"><a href="ads.php?ptype=APARTMENT&cat=vermieten"><span><?echo APARTMENT;?></span></a></li>
                        <li style="list-style-image:url('resimler/icons/office.png')"><a href="ads.php?ptype=WORKPLACE&cat=vermieten"><span><?echo WORKPLACE;?></span></a></li>
                        </ul>
                    </div>
                    <div class="bar_header">
                        <h3><?echo SERVICE;?></h3>
                    </div>
                    <div id="index_bar_content">
                        <ul>
                        <li style="list-style-image:url('resimler/icons/avro.png')"><a href="service.php"><span><?echo FINANCE;?></span></a></li>
                        <li style="list-style-image:url('resimler/icons/avro2.png')"><a href="service.php"><span><?echo INSURANCE;?></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="sidebar_content" style="margin-top:10px">
                    <div class="bar_header">
                        <h3><?echo TDB_GUESTS?></h3>
                    </div>
                    <div id="index_bar_content" style="padding:10px">
                            <a href="http://s07.flagcounter.com/more/TZv9"><img src="http://s07.flagcounter.com/count/TZv9/bg=FFFFFF/txt=000000/border=FFFFFF/columns=2/maxflags=12/viewers=0/labels=0/" alt="free counters" border="0"></a>
                    </div>
                </div>
            </div>
            <div id="index_main_content">
                <div class="bar_header">
                    <h3><?echo SEARCH_H;?> - TDB Immobilien</h3>
                </div>
                <div id="index_search_div">
                    <div id="index_search_div_left">
                        <img src="resimler/icons/folder_home.png" />
                        <!--<a id="index_detail_header" href="detail_search.php"> &rArr; <?echo DETAILED_SEARCH?></a>-->
                    </div>
                    <div id="index_search_div_right">
                        <h4 id="index_sub_mainh"><?echo PROPERTY;?> | TDB Immobilien GmbH</h4>
                        <h4 id="index_sub_header"> <?echo SEARCH_PROPERTIES_WITH_YOUR_CRITERIA;?>!</h4>
                        <table id="index_search_table" border="0">
                            <form action="ads.php" name="search_form" method="post" onsubmit="return validateForm(this)">
                                <tr>
                                    <td colspan="3">
                                        <input id="index_search_input_title" name="title" size="30" type="text" style="" value="<?echo AD_TITLE;?>" onClick="javascript:this.form.title.focus();this.form.title.select()"/>
                                        <select id="index_search_select_pt" name="prop_type">
                                            <option value=""> <? echo CHOOSE; ?> </option>
                                            <option value="HOUSE"><?echo HOUSE;?></option>
                                            <option value="APARTMENT"><?echo APARTMENT;?></option>
                                            <option value="LOT"><?echo LOT;?></option>
                                            <option value="WORKPLACE"><?echo WORKPLACE;?></option>
                                        </select>
                                        <input id="index_search_submit" type="submit" name="search_submit" value="<?echo SEARCH;?>" style="font-size:11px"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="index_search_td" colspan="3">
                                        <label id="label_state" class="label"><?echo STATE;?></label><label id="label_country" class="label" style="display:none"><?echo COUNTRY;?> &nbsp;</label> <label id="cities_label" class="label"><?echo CITY?></label> <br/>
                                        <select id="index_search_select_state" name="state" onchange="city_select(this.value)">
                                            <option value=""></option>
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
                                        <select name="country" id="index_search_select_country" style="display:none" onchange="state_select2(this.value)">
                                            <option value=""> </option>
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

                                            <option value="other"> Other </option>
                                        </select>
                                        <select id="cities" name="city">
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="cursor:pointer">
                                        <a id="alm_dis" style="font-size:13px" onclick="document.getElementById('label_state').style.display='none'; document.getElementById('label_country').style.display='inline'; document.getElementById('index_search_select_state').style.display='none'; document.getElementById('index_search_select_country').style.display='inline'; state_select2(document.getElementById('index_search_select_country').value); document.getElementById('alm_dis').style.display='none'; document.getElementById('alm_ic').style.display='inline'; document.getElementById('index_search_select_state').value = null;  document.search_form.country.disabled = false "><?echo SEARCH_OUTSIDE_GERMANY?></a>
                                        <a id="alm_ic" style="font-size:13px; display:none" onclick="document.getElementById('label_country').style.display='none'; document.getElementById('label_state').style.display='inline'; document.getElementById('index_search_select_state').style.display='inline'; document.getElementById('index_search_select_country').style.display='none'; city_select(document.getElementById('index_search_select_state').value); document.getElementById('alm_ic').style.display='none'; document.getElementById('alm_dis').style.display='inline'; document.search_form.country.disabled = true " ><?echo SEARCH_INSIDE_GERMANY?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="index_search_td">
                                        <label class="label"> <?echo PRICE;?> (€) </label> <br><input class="index_search_input_type1" name="min_price" size="3"/> - <input class="index_search_input_type2" name="max_price" size="3"/>
                                    </td>
                                    <td class="index_search_td">
                                        <label class="label" style="margin-left:10px"> <?echo LIVING_SPACE;?> (m<sup style="font-size:8px">2</sup>) </label> <br><input class="index_search_input_type1" name="min_space" size="3" style="margin-left:10px" /> - <input class="index_search_input_type2" name="max_space" size="3"/>
                                    </td>
                                    <td class="index_search_td">
                                        <label class="label" style="margin-left:20px"> <?echo NUMBER_OF_ROOMS;?> </label> <br><input class="index_search_input_type1" name="min_rooms" size="3" style="margin-left:20px" /> - <input class="index_search_input_type2" name="max_rooms" size="3"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <input id="mieten" type="radio" name="type" value="vermieten" style="margin-top:20px"/> <label class="label" for="mieten"><b><?echo FOR_RENT;?></b></label>
                                        <input id="kaufen" type="radio" name="type" value="verkaufen"/> <label class="label" for="kaufen"><b><?echo FOR_SALE;?></b></label>
                                    </td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>
                <div id="index_info_div">
                    <div class="bar_header">
                        <h3><?echo LAST_INSERTED;?> - TDB Immobilien</h3>
                    </div>
                    <div id="index_info_content" style="overflow:hidden">
                        <? if (count($property) != 0) { ?>
                        <ul class="index_photos">
                            <?
                            foreach ($photos as $ph) {
                                $query = mysql_query("SELECT * FROM property WHERE id=$ph[property_id]");
                                $prop = mysql_fetch_assoc($query);
                            ?>
                            <li class="last_insert">
                                <span class="data">
                                    <table>
                                        <tr>
                                            <td class="prop_info" colspan="2"><b><?print(constant($prop[category])." ".constant($prop[property_category]))?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="prop_info"><?echo PRICE;?>:</td>
                                            <td class="prop_info"><?print(number_format($prop[price],0,'','.')." €")?></td>
                                        </tr>
                                        <tr>
                                            <td class="prop_info"><?echo LIVING_SPACE;?>:</td>
                                            <td class="prop_info"><?print($prop[living_space])?>m<sup>2</sup></td>
                                        </tr>
                                        <tr>
                                            <td class="prop_info"><?echo NUMBER_OF_ROOMS;?>:</td>
                                            <td class="prop_info"><?print($prop[nb_rooms])?></td>
                                        </tr>
                                        <tr>
                                            <td class="prop_info"><a href="ad.php?id=<?print($prop[id])?>"><?echo CLICK_FOR_INFORMATION;?></a><td>
                                        </tr>
                                    </table>
                                </span>
                                <span class="image">
                                    <img id="index_image" src="<?print($ph[url])?>"/>
                                </span>
                                <h2><? print($prop[city]) ?></h2>
                            </li>
                            <?}?>
                        </ul>
                        <? } else echo "<h3 style='padding:10px'>".NO_NEW_ADS."</h3>" ?>
                    </div>
                </div>
            </div>
            <div id="index_news">
                <div class="bar_header">
                    <h3> <?echo TDB_NEWS; ?> </h3>
                </div>
                <div id="news_table">
                    <table>
                        <tr>
                            <? foreach($news as $cnt => $n) { ?>
                            <td width="33%" <?if ($cnt!=2) echo "style='border-right:1px solid #DBDBDB'"?>>
                                <h3><? echo $n[header] ?></h3>
                                <?
                                    if(str_word_count($n[text]) > 20) {
                                        $words = explode(" ", $n[text]);
                                        for ($x=0; $x<20; $x++) echo $words[$x]." ";
                                        echo "... <br/> <br/>";
                                ?>
                                    <a href='news.php?nid=<?echo $n[id]?>' title="<?echo NEWS;?>" rel="gb_page[500,500]"><?echo SEE_MORE;?></a>
                                <?  }
                                    else echo $n[text];
                                ?>
                            </td>
                            <? } ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
