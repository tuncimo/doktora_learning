<?php
        session_start();
        ob_start();

        $insert = $_GET['insert'];

        include_once 'connection.php';
        $query = mysql_query("SELECT id FROM detail");
        while ($row = mysql_fetch_assoc($query))
            $id[] = $row['id'];

        foreach ($id as $x) {
            if (isset($_POST[$x])) mysql_query("INSERT INTO property_has_detail VALUES ($insert,$x)");
            if (!isset($_POST[$x]) && mysql_num_rows(mysql_query("SELECT * FROM property_has_detail WHERE property_id=$insert AND detail_id=$x")) == 1) mysql_query("DELETE FROM property_has_detail WHERE property_id=$insert AND detail_id=$x");
        }

        header("Location:index.php");

?>