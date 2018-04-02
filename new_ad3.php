<?php
        session_start();
        ob_start();
        /* if(isset($_SESSION[username]))
            $user_signed_in = true;
        else
            $user_signed_in = false;
        */
        include_once 'connection.php';
        include_once 'common.php';
        $insert = $_SESSION[insert_id];
        unset($_SESSION[insert_id]);

        $query = mysql_query("SELECT url FROM photos WHERE property_id=$insert");
        if(!$query) die('PLEASE DO NOT REFRESH');
        while ($row = mysql_fetch_assoc($query))
            $photo[] = $row['url'];

        $query = mysql_query("SELECT * FROM detail");
        while ($row =  mysql_fetch_assoc($query)) {
            if ($row['type'] == "İç Özellikler") $ic_ozellik[] = $row;
            if ($row['type'] == "Dış Özellikler") $dis_ozellik[] = $row;
            if ($row['type'] == "Ulaşım") $ulasim[] = $row;
            if ($row['type'] == "Manzara") $manzara[] = $row;
            if ($row['type'] == "Konut Tipi") $konut_tipi[] = $row;
            if ($row['type'] == "Cephe") $cephe[] = $row;
        }
        
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?echo ADVERTISE;?></title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css"> <!--<![endif]-->

        <script type="text/javascript">
            var GB_ROOT_DIR = "greybox/greybox/";
        </script>

        <script type="text/javascript" src="greybox/greybox/AJS.js"></script>
        <script type="text/javascript" src="greybox/greybox/AJS_fx.js"></script>
        <script type="text/javascript" src="greybox/greybox/gb_scripts.js"></script>
        <link href="greybox/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" type="image/x-icon" href="resimler/hou.ico">
        <link rel="stylesheet" type="text/css" href="stylesheets/menu_style.css">
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
                <li><a href="contact.php" title="Kontakt"><?echo CONTACT;?></a></li>
                <li class="current"><a href="new_ad.php" title="İlan Ver"><?echo ADVERTISE;?></a>
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
            <div id="new_ad3_main_content">
                <form class="jotform-form" action="new_ad3_submit.php?insert=<?echo $insert?>" method="post" name="new_ad3" accept-charset="utf-8">
                <div class="form-all">
                    <ul class="form-section">
                        <li class="form-input-wide">
                            <div class="form-header-group">
                                <h2 class="form-header">İlan Ver</h2>
                            </div>
                        </li>
                        <br/>
                        <h3 style="margin-left:13px"><?echo STEP_ONE;?> -> <?echo STEP_TWO;?> -> <?echo STEP_THREE;?></h3>
                        <!--<li class="form-line">
                            <label class="form-label-left">
                                Kategori:<span class="form-required">*</span>
                            </label>
                        </li> -->
                        <li class="form-line">
                            <h3> <?echo INDOOR_PROPERTIES;?> </h3>
                            <table id="table_prop">
                            <?
                            $table_divider = 0;
                            foreach ($ic_ozellik as $x) {
                            if (mysql_num_rows(mysql_query("SELECT property_id FROM property_has_detail WHERE property_id=$insert AND detail_id=$x[id]")) == 1) $litmus = "checked"; else $litmus = null;
                            if($table_divider%4==0) echo "<tr>";
                                echo "<td style='width:160px'><input type='checkbox' value='$x[id]' name='$x[id]' $litmus/><label>".constant($x[description])."</label></td>";
                            if($table_divider%4==3) echo "</tr>";
                            $table_divider++;
                            }
                            ?>
                            </table><br/>
                            <h3> <?echo OUTDOOR_PROPERTIES;?> </h3>
                            <table id="table_prop">
                            <?
                            $table_divider = 0;
                            foreach ($dis_ozellik as $x) {
                            if (mysql_num_rows(mysql_query("SELECT property_id FROM property_has_detail WHERE property_id=$insert AND detail_id=$x[id]")) == 1) $litmus = "checked"; else $litmus = null;
                            if($table_divider%4==0) echo "<tr>";
                                echo "<td style='width:160px'><input type='checkbox' value='$x[id]' name='$x[id]' $litmus/><label>".constant($x[description])."</label></td>";
                            if($table_divider%4==3) echo "</tr>";
                            $table_divider++;
                            }
                            ?>
                            </table><br/>
                            <h3> <?echo TRANSPORTATION;?> </h3>
                            <table id="table_prop">
                            <?
                            $table_divider = 0;
                            foreach ($ulasim as $x) {
                            if (mysql_num_rows(mysql_query("SELECT property_id FROM property_has_detail WHERE property_id=$insert AND detail_id=$x[id]")) == 1) $litmus = "checked"; else $litmus = null;
                            if($table_divider%4==0) echo "<tr>";
                                echo "<td style='width:160px'><input type='checkbox' value='$x[id]' name='$x[id]' $litmus /><label>".constant($x[description])."</label></td>";
                            if($table_divider%4==3) echo "</tr>";
                            $table_divider++;
                            }
                            ?>
                            </table><br/>
                            <h3> <?echo LANDSCAPE;?> </h3>
                            <table id="table_prop">
                            <?
                            $table_divider = 0;
                            foreach ($manzara as $x) {
                            if (mysql_num_rows(mysql_query("SELECT property_id FROM property_has_detail WHERE property_id=$insert AND detail_id=$x[id]")) == 1) $litmus = "checked"; else $litmus = null;
                            if($table_divider%4==0) echo "<tr>";
                                echo "<td style='width:160px'><input type='checkbox' value='$x[id]' name='$x[id]' $litmus /><label>".constant($x[description])."</label></td>";
                            if($table_divider%4==3) echo "</tr>";
                            $table_divider++;
                            }
                            ?>
                            </table><br/>
                            <h3> <?echo PROPERTY_TYPE;?> </h3>
                            <table id="table_prop">
                            <?
                            $table_divider = 0;
                            foreach ($konut_tipi as $x) {
                            if (mysql_num_rows(mysql_query("SELECT property_id FROM property_has_detail WHERE property_id=$insert AND detail_id=$x[id]")) == 1) $litmus = "checked"; else $litmus = null;
                            if($table_divider%4==0) echo "<tr>";
                                echo "<td style='width:160px'><input type='checkbox' value='$x[id]' name='$x[id]' $litmus /><label>".constant($x[description])."</label></td>";
                            if($table_divider%4==3) echo "</tr>";
                            $table_divider++;
                            }
                            ?>
                            </table><br/>
                            <h3> <?echo FRONTAGE;?> </h3>
                            <table id="table_prop">
                            <?
                            $table_divider = 0;
                            foreach ($cephe as $x) {
                            if (mysql_num_rows(mysql_query("SELECT property_id FROM property_has_detail WHERE property_id=$insert AND detail_id=$x[id]")) == 1) $litmus = "checked"; else $litmus = null;
                            if($table_divider%4==0) echo "<tr>";
                                echo "<td style='width:160px'><input type='checkbox' value='$x[id]' name='$x[id]' $litmus/><label>".constant($x[description])."</label></td>";
                            if($table_divider%4==3) echo "</tr>";
                            $table_divider++;
                            }
                            ?>
                            </table>
                        </li>
                        <li class="form-line">
                            <a href="insert_image.php?insert=<?print($insert)?>" title="Fotoğraf Ekle" rel="gb_page_center[800,600]"><?echo ADD_PHOTOS;?>!</a>
                        </li>
                        <li class="form-line">
                            <a href="insert_video.php?insert=<?print($insert)?>" title="Video Ekle" rel="gb_page_center[600,500]"><?echo ADD_VIDEOS;?>!</a>
                        </li>
                        <? if (count($photo) > 0) {
                            echo "<li class='form-line'>";
                            foreach ($photo as $p){
                                echo "<a href='$p' rel= 'gb_imageset[nice_pics]' title='yok'><img src='$p' style='width:200px; height:auto'></a>";
                            }
                            echo "</li>";
                        }
                        ?>
                        <li class="form-line">
                            <input type="submit" value="<?echo SUBMIT;?>" />
                        </li>
                    </ul>
                </div>
                </form>
            </div>
        </div>
    </body>
</html>

<?php ob_end_flush() ?>