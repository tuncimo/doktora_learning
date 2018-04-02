<?php
//mysql_set_charset("utf-8");
include 'connection.php';
require_once('class.phpgmailer.php');

$query = mysql_query("SELECT * FROM newsletter");
while($row = mysql_fetch_assoc($query)) {
    $request[] = $row;
}
foreach ($request as $r) {
    if(isset ($properties)) unset ($properties);
    $oneWeek = time()-86400*7;
    $prevWeek = date("Y-m-d", $oneWeek);
    $query2 = mysql_query("SELECT * FROM property WHERE category = '$r[category]' AND property_category = '$r[property_category]' AND
                           nb_rooms BETWEEN $r[min_nb_rooms] AND $r[max_nb_rooms] AND nb_bathrooms BETWEEN $r[min_nb_bathrooms] AND
                           $r[max_nb_bathrooms] AND floor BETWEEN $r[min_floor] AND $r[max_floor] AND living_space BETWEEN $r[min_living_space] AND
                           $r[max_living_space] AND price BETWEEN $r[min_price] AND $r[max_price] AND country = '$r[country]' AND city = '$r[city]'");
    while($row = mysql_fetch_assoc($query2)) { if($row[ad_date] > $prevWeek) $properties[] = $row; }
    
    if(count($properties) > 0) {
        $query3 = mysql_query("SELECT * FROM users WHERE id=$r[users_id]");
        $user = mysql_fetch_assoc($query3);
        
        $my_mail  = "<html><body style='font-family:calibri,helvetica,verdana'>";
        $my_mail .= "<h1>Hallo ".$user[username].",</h1>";
        foreach ($properties as $p) $my_mail .= "http://www.tdb-immo.de/tdb_web/ad.php?id=$p[id]";
        $my_mail .= "<br/><br/> Mit Freundlichen Grüßen, <br/> TDB Immobilien GmbH"."</body><html>";

        $mail = new PHPGMailer();
        $mail->ContentType = "text/html; charset=utf-8";
        $mail->Username   = 'noreply@tdb-immo.com';
        $mail->Password   = 'jangomango';
        $mail->From       = 'noreply@tdb-immo.com';
        $mail->FromName   = 'TDB Immobilien GmbH';
        $mail->Subject    = 'Immobilien Newsletter';
        $mail->Body       = $my_mail;
        $mail->AddAddress($user[email]);
        $mail->Send();
    }
}
?>
