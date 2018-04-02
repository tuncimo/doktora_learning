<?
        $connection = mysql_connect("db1683.1und1.de","dbo268365201","jangomango");
        if (!$connection) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("db268365201",$connection);
        mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connection);
?>