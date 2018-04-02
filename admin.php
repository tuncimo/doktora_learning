<?php
        session_start();

        include 'connection.php';
        include_once 'common.php';

        if(isset($_GET['lin'])) $lin = $_GET['lin'];
        if(isset ($_POST['lin'])) $lin = $_POST['lin'];
        else $lin  = "main";

        if(isset ($_POST['admin_name'])) $user = $_POST['admin_name'];
        if(isset ($_POST['password'])) $pass = $_POST['password'];

        $ref = $_SERVER['HTTP_REFERER'];
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <title><?echo ADMIN_LOGIN?></title>
        <!--[if IE]> <link rel="stylesheet" type="text/css" href="stylesheets/main_ie.css" /> <![endif]-->
        <!--[if !IE]>><!--> <link rel="stylesheet" type="text/css" href="stylesheets/main.css" /> <!--<![endif]-->
        <link rel="stylesheet" type="text/css" href="stylesheets/form.css" />

        <script type="text/javascript">
            var GB_ROOT_DIR = "greybox/greybox/";
        </script>

        <script type="text/javascript" src="greybox/greybox/AJS.js"></script>
        <script type="text/javascript" src="greybox/greybox/AJS_fx.js"></script>
        <script type="text/javascript" src="greybox/greybox/gb_scripts.js"></script>
        <link href="greybox/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <? if($lin == "main") { ?>
        <div id="distance"></div>
        <div id="admin_login">
            <center>
                <form action="" method="post" name="admin_log">
                    <table id="admin_table">
                        <tr>
                            <td colspan="2" align="center" style="padding-bottom:30px"> <img src="resimler/logo_orta.jpg" /> </td>
                        </tr>
                        <tr>
                            <td><?echo USERNAME;?>:</td>
                            <td><input type="text" name="admin_name" /></td>
                        </tr>
                        <tr>
                            <td><?echo PASSWORD;?>:</td>
                            <td><input type="password" name="password" autocomplete="off"/></td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="submit" value="<?echo SUBMIT?>" /></td>
                        </tr>
                    </table>
                    <input type="hidden" name="lin" value="enter" />
                </form>
            </center>
        </div>
        <? } if($lin == "enter") {
               if($user == "admin" && $pass == "jangomango") { ?>
        <div id="distance"></div>
        <div id="admin_page">
            <div class="form-header-group">
                <h2 class="form-header"><?echo ADMIN?> - TDB</h2>
            </div>
            <h2 class="salutation"><?echo HELLO?> <?print($user.",")?></h2>
            <center>
            <div id="myaccount_settings">
                <table align="center">
                    <tr>
                        <td class="settings_icon"><a href="admin_submission.php"><img class="my_icons" src="resimler/icons/tick2.png" /><br/><?echo AD_APPROVAL?></a></td>
                        <td class="settings_icon"><a href="new_ad.php"><img class="my_icons" src="resimler/icons/npad.png" /><br/><?echo ADVERTISE?></a></td>
                        <td class="settings_icon"><a href="admin_ads.php"><img class="my_icons" src="resimler/icons/news.png" /><br/>TDB - <?echo ADVERTISEMENTS?></a></td>
                        <td class="settings_icon"><a href="new_news.php" title="Haber - Duyuru Ekle" rel="gb_page[500,500]"><img class="my_icons" src="resimler/icons/kblogger.png" /><br/><?echo ADD_NEWS?></a></td>
                    </tr>
                </table>
            </div>
            </center>
        </div>
        <? $_SESSION[username]="TDB Immobilien GmbH";
           $_SESSION[id]="18";
                 }
               else echo USERNAME_OR_PASSWORD_INCORRECT."<a href='$ref'>".GO_BACK."</a>";
        } ?>
    </body>
</html>

<style type="text/css">
    #admin_login {
        font-family:calibri,helvetica,verdana;
        border:1px solid silver;
        clear:left;
        height:15em;
        margin:0 auto;
        position:relative;
        width:25em;
        padding-top:20px;
        -moz-border-radius: 5px;
        -khtml-border-radius: 5px; 
    }
    #admin_page {
        font-family:calibri,helvetica,verdana;
        border:1px solid silver;
        clear:left;
        height:20em;
        margin:0 auto;
        position:relative;
        width:50em;
        -moz-border-radius: 5px;
        -khtml-border-radius: 5px;
    }
    #distance {
        float:left;
        height:50%;
        margin-bottom:-9.00em;
        width:1px;
    }
</style>
<!--[if IE]>
<style type="text/css">
    #admin_login {
        height:13.5em;
    }
</style>
<![endif]-->