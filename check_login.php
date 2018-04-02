<?php
    ob_start();
    $host="db1683.1und1.de";
    $username="dbo268365201";
    $password="jangomango";
    $db_name="db268365201"; // Database name
    $tbl_name="users"; // Table name

    // Connect to server and select databse.
    $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect");
    mysql_select_db("$db_name")or die("cannot select DB");
    mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);

    // Define $myusername and $mypassword
    $myusername=$_POST['myusername'];
    $mypassword=$_POST['mypassword'];

    // To protect MySQL injection (more detail about MySQL injection)
    $myusername = stripslashes($myusername);
    $mypassword = stripslashes($mypassword);
    $myusername = mysql_real_escape_string($myusername);
    $mypassword = mysql_real_escape_string($mypassword);

    $sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword' and approved=1";
    $result=mysql_query($sql);

    // Mysql_num_row is counting table row
    $count=mysql_num_rows($result);
    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count==1 && $myusername != "TDB Immobilien GmbH"){
    // Register $myusername, $mypassword and redirect to file "login_success.php"
    $myid = mysql_result($result, 0, 'id');
    session_start();
    $_SESSION[username]=$myusername;
    $_SESSION[password]=$mypassword;
    $_SESSION[id]=$myid;
    $referrer = $_SERVER['HTTP_REFERER'];
    header("Location: $referrer");
    }
    else { ?>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <script language="javascript">
        alert("Benutzername oder Passwort falsch");
        gonderen = document.referrer;
        window.location=gonderen;
        </script>
    <?
    //$referrer = $_SERVER['HTTP_REFERER'];
    //header("Location: $referrer");
    }
    ob_end_flush();
    ?>
