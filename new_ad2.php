<?php
        session_start();
        ob_start();
        if(isset($_SESSION[username])) {
            $user_signed_in = true;
        }
        else {
            $user_signed_in = false;
        }
        include_once 'connection.php';
        include_once 'common.php';

        if($_POST['abroad'] == "abroad") $abroad = true; else $abroad=false;
        $category = $_POST['category'];
        $selector = $_POST['property_category'];
        $main_category = substr($selector, 0, 1);
        if($main_category == "P") $main_category = "PRIVAT";
        else if($main_category == "G") $main_category = "WORKPLACE";
        else if($main_category == "K") $main_category = "CAPITAL";
        else if($main_category == "A") $main_category = "ABROAD";
        $property_category = substr($selector,1);

        if($property_category == "APARTMENT") $subcategory = array("ATTIC_APARTMENT", "GROUND_FLOOR", "FLAT", "STUDIO", "DUPLEX", "RESIDANCE", "SOUTERRAIN", "COUNTRY_HOUSE", "GALLERY_APARTMENT", "ROOM","OTHER_APARTMENT");
		else if($property_category == "HOUSE") $subcategory = array("FARM_HOUSE", "SPECIAL_HOUSE", "SEMI_DETACHED_HOUSE", "BUNGALOW", "DETACHED_HOUSE", "TOWNHOUSE", "CITYHOUSE", "MANSION", "FAMILY_DUPLEX", "OTHER_HOUSE");
		else if($property_category == "LOT") $subcategory = array("APARTMENT_LOT", "WORKPLACE_LOT", "FOREST", "LEISURE_LOT", "SPECIAL_USE", "INDUSTRY", "OTHER");
        else if($property_category == "GARAGE") $subcategory = array("GARAGE","CARPORT","OTHER");
		else if($property_category == "OFFICE") $subcategory = array("OFFICE_SPACE","OFFICE_HOUSE","PRACTICE_AREA","PRACTICE_HOUSE","OTHER");
		else if($property_category == "RETAIL_STORE") $subcategory = array("EXHIBITION_AREA","RETAIL_LOAD","SHOPPING_CENTER","FACTORY_OUTLET","KIOSK","SALES_AREA","DEPARTMENT_STORE","OTHER");
		else if($property_category == "HOTEL") $subcategory = array("BAR","CAFE","DISCO","RESTAURANT","HOTEL_PENSION","CLUB","OTHER");
		else if($property_category == "HALL_MARKET") $subcategory = array("HALL","COLD_STORAGE","WORKSHOP","STORE","OTHER");
		else if($property_category == "LEISURE") $subcategory = array("RECREATION","SPORTS_FACILITY","OTHER");
		else if($property_category == "APARTMENT_TOWNHOUSE") $subcategory = array("OFFICE_BLOCK","APARTMENT_BUILDING","OTHER");
		else if($property_category == "OTHER") $subcategory = array("GAS_STATION","AUTOPARK","INDUSTRIAL_PARK","OTHER");
		
		
		$query = mysql_query("SELECT * FROM users WHERE username='$_SESSION[username]'");
        $user = mysql_fetch_assoc($query);
        $username = $user['firstname']." ";
        $username .= $user['lastname'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo ADVERTISE;?></title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/form_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/form.css"> <!--<![endif]-->
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
        <link rel="shortcut icon" type="image/x-icon" href="resimler/hou.ico">
        <script type="text/javascript" src="scripts/city_select.js"></script>
        <script type="text/javascript" src="scripts/form_validate.js"></script>

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
    <body <?if($abroad) {?> onload="city_select_newad(document.getElementById('country_input').value)" <?} else {?> onload="city_select_newad2(document.getElementById('state_input').value)" <? } ?>>
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
            <div id="new_ad2_main_content">
                <form class="jotform-form" action="new_ad2_submit.php" method="post" name="new_ad3" onsubmit="return validateNewAdSubmit(this)">
                <div class="form-all">
                    <ul class="form-section">
                        <li class="form-input-wide">
                            <div class="form-header-group">
                                <h2 class="form-header"><?echo ADVERTISE;?></h2>
                            </div>
                        </li>
                        <br/>
                        <h3 style="margin-left:13px"><?echo STEP_ONE?> -> <?echo STEP_TWO;?> </h3>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo CATEGORY;?>:
                            </label>
                            <? print(constant($category)." > ".constant($main_category)." > ".constant($property_category)) ?>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo ADVERTISER;?>:
                            </label>
                            <? print($username) ?>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo PROPERTY_SUBCATEGORY;?>:
                            </label>
                            <div class="form-input">
                                <select>
                                    <?foreach ($subcategory as $s) {?>
                                    <option value="<?echo $s?>"><?echo constant($s)?></option>
                                    <?}?>
                                </select>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo TITLE;?>:<span class="form-required">*</span>
                            </label>
                            <div class="form-input">
                                <input type="text" id="title" name="title" size="60" /> <br/>
                                <label class="form-sub-label"> <?echo EXAMPLE_TITLE;?></label></span>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo ADDRESS;?>:<span class="form-required">*</span>
                            </label>
                            <div class="form-input">
                                <input type="text" id="street" name="street" size="30" /><label class="form-sub-label"><?echo STREET;?></label>
                            </div> &nbsp;
                            <div class="form-input">
                                <input type="text" id="house_no" name="house_no" size="2" /><label class="form-sub-label"><?echo NUMBER;?></label>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                            </label>
                            <div class="form-input">
                                <input type="text" id="postcode" name="postcode" size="8"/><label class="form-sub-label"><?echo POSTCODE;?></label>
                            </div>&nbsp;&nbsp;
                            <div class="form-input">
                                <select name="city" id="city_input"> </select>
                                <label class="form-sub-label"><?echo CITY;?></label>
                            </div>
                        </li>
                        
                        <li class="form-line">
                            <label class="form-label-left">
                            </label>
                            <div class="form-input">
                                <? if($abroad) { ?>
                                <select name="country" id="country_input" onchange="city_select_newad(this.value)">
                                <option value="Afghanistan"> Afghanistan </option>
                                <option value="Albania"> Albania </option>
                                <option value="Algeria"> Algeria </option>

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
                            <label class="form-sub-label"><?echo COUNTRY;?></label>
                            <? } else { ?>
                            <input type="hidden" name="country" value="Deutschland" />
                            <select name="state" id="state_input" onchange="city_select_newad2(this.value)">
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
                            <? } ?>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo HIDE_ADDRESS;?>:
                            </label>
                            <div class="form-input">
                                <?echo SHOW;?><input type="radio" name="secrecy" value="show" checked/>
                                <?echo HIDE;?><input type="radio" name="secrecy" value="hide"/>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo NUMBER_OF_ROOMS;?>:<span class="form-required">*</span>
                            </label>
                            <div class="form-input">
                                <input type="text" name="nb_rooms" id="nb_rooms" size="1" />
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?echo NUMBER_OF_BATHROOMS;?>:<span class="form-required">*</span>
                            <div class="form-input">
                                <input type="text" name="nb_bathrooms" id="nb_bathrooms" size="1" />
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?echo FLOOR;?>:<span class="form-required">*</span>
                            <div class="form-input">
                                <input type="text" name="floor" id="floor" size="1" />
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo LIVING_SPACE;?>:<span class="form-required">*</span>
                            </label>
                            <div class="form-input">
                                <input type="text" name="living_space" id="living_space" size="2" /> m<sup>2</sup>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo HEATING;?>:<span class="form-required">*</span>
                            </label>
                            <div class="form-input">
                                <select name="heating">
                                    <option value="NONE"><?echo CHOOSE;?></option>
                                    <option value="NONE"><?echo NONE;?></option>
                                    <option value="NATURAL_GAS"><?echo NATURAL_GAS;?></option>
                                    <option value="CEN_SYSTEM"><?echo CEN_SYSTEM?></option>
                                    <option value="AIR_CONDITIONER"><?echo AIR_CONDITIONER;?></option>
                                    <option value="SOLAR_ENERGY"><?echo SOLAR_ENERGY;?></option>
                                </select>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo PRICE;?>:<span class="form-required">*</span>
                            </label>
                            <div class="form-input">
                                <input type="text" name="price" id="price" size="7" />EUR
                                <!--<select name="currency1">
                                    <option value="EUR">EUR</option>
                                    <option value="TRY">TRY</option>
                                    <option value="USD">USD</option>
                                    <option value="GBP">GBP</option>
                                </select>-->
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo COMMISSION;?>:
                            </label>
                            <div class="form-input">
                                <input type="text" name="price" id="price" size="7" />EUR
                            </div>
                        </li>
                        <? if($category == 'vermieten') { ?>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo DEPOSIT;?>:<span class="form-required">*</span>
                            </label>
                            <div class="form-input">
                                <input type="text" name="deposit" id="deposit" size="7" />EUR
                                <!--<select name="currency2">
                                    <option value="EUR">EUR</option>
                                    <option value="TRY">TRY</option>
                                    <option value="USD">USD</option>
                                    <option value="GBP">GBP</option>
                                </select>-->
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo CHARGES;?>:<span class="form-required">*</span>
                            </label>
                            <div class="form-input">
                                <input type="text" name="charges" id="charges" size="7" />EUR
                                <!--<select name="currency3">
                                    <option value="EUR">EUR</option>
                                    <option value="TRY">TRY</option>
                                    <option value="USD">USD</option>
                                    <option value="GBP">GBP</option>
                                </select>-->
                                <label class="form-sub-label"> <?echo EXAMPLE_CHARGES;?></label>
                            </div>
                        </li>
                        <? } ?>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo DESCRIPTION;?>:<span class="form-required">*</span>
                            </label>
                            <div id="new_ad2_box" class="form-input" style="border:1px solid #4682B4">
                                <textarea class="jquery_ckeditor" name="description" rows="10" cols="55"></textarea>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo LOCATION;?>:<span class="form-required"></span>
                            </label>
                            <div id="new_ad2_box" class="form-input" style="border:1px solid #93DFB8">
                                <textarea class="jquery_ckeditor" name="location" rows="8" cols="55"> </textarea>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo FURNITURE;?>:<span class="form-required"></span>
                            </label>
                            <div id="new_ad2_box" class="form-input" style="border:1px solid #FFBF00">
                                <textarea class="jquery_ckeditor" name="equipment" rows="8" cols="55"> </textarea>
                            </div>
                        </li>
                        <li class="form-line">
                            <label class="form-label-left">
                                <?echo OTHER;?>:<span class="form-required"></span>
                            </label>
                            <div id="editor4" class="form-input" style="display:none; border:1px solid #FF2400">
                                <textarea class="jquery_ckeditor" name="other" rows="8" cols="55"> </textarea>
                            </div>
                            <input id="editor4_open" onclick="openEditor('editor4');" type="button" value="<?echo ADD_MORE_INFO?>" />
                            <input id="editor4_close" onclick="closeEditor('editor4');" type="button" value="<?echo CLOSE?>" style="display:none"/>
                        </li>
                        
                        <li class="form-line">
                            <input type="submit" value="<?echo SUBMIT;?>" />
                        </li>
                    </ul>
                </div>
                    <input type="hidden" name="date" value="<?print(date('Y-m-d'))?>">
                    <input type="hidden" name="category" value="<?print($category)?>">
                    <input type="hidden" name="property_category" value="<?print($property_category)?>">
                    <input type="hidden" name="property_subcategory" value="<?print($property_subcategory)?>">
					<input type="hidden" name="main_category" value="<?print($main_category)?>">
                </form>
            </div>
        </div>
    </body>
</html>

<? ob_end_flush() ?>

<script language="JavaScript" type="text/javascript">
    function openEditor(name){
        document.getElementById(name).style.display = '';
        document.getElementById(name+"_open").style.display = 'none';
        document.getElementById(name+"_close").style.display = '';
    }
    function closeEditor(name){
        document.getElementById(name).style.display = 'none';
        document.getElementById(name+"_open").style.display = '';
        document.getElementById(name+"_close").style.display = 'none';
    }
</script>