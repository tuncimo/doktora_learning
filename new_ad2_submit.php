<?
        session_start();
        ob_start();

        include_once 'connection.php';

		if($_POST['secrecy'] == "hide") $reg_hide = 1; else $reg_hide = 0;
        $ad_date = $_POST['date'];
		$main_category = $_POST['main_category'];
        $category = $_POST['category'];
        $property_category = $_POST['property_category'];
        $property_subcategory = $_POST['property_subcategory'];
        $title = ucwords(mb_strtolower($_POST['title'],"UTF-8"));
        $country = $_POST['country'];
        //$state = $_POST['state'];
        $street = $_POST['street'];
        $postcode = $_POST['postcode'];
        $city = $_POST['city'];
        $house_no = $_POST['house_no'];
        $description = $_POST['description'];
        $nb_rooms = $_POST['nb_rooms'];
        $nb_bathrooms = $_POST['nb_bathrooms'];
        $floor = $_POST['floor'];
        $living_space = $_POST['living_space'];
        $heating = $_POST['heating'];
        //$price = $_POST['price']." ".$_POST['currency1'] ;
        $price = $_POST['price'];
		$commission = $_POST['commission'];
        //$deposit = $_POST['deposit']." ".$_POST['currency2'];
        $deposit = $_POST['deposit'];
        //$charges = $_POST['charges']." ".$_POST['currency3'];
        $charges = $_POST['charges'];
        $location = $_POST['location'];
        $equipment = $_POST['equipment'];
        $other = $_POST['other'];

		if($commission == null) $commission = 0;
        if($deposit == null) $deposit = 0;
        if($charges == null) $charges = 0;

        $query = mysql_query("SELECT * FROM users WHERE username='$_SESSION[username]'");
        $user = mysql_fetch_assoc($query);
        $user_id = $user['id'];

        $result = mysql_query("INSERT INTO property VALUES(null, '$user_id','$ad_date','$category','$main_category','$property_category',
                                                       '$property_subcategory','$heating','$title','$nb_rooms','$nb_bathrooms',
                                                       '$living_space','$floor','$price','$charges','$deposit','$house_no',
                                                       '$street','$postcode','$city','$country','$description','$location','$equipment','$other',0,0,'$reg_hide','$commission')");
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }

        $insert = mysql_insert_id();
        if($user['username'] == "TDB Immobilien GmbH") mysql_query("UPDATE property SET approved=1 WHERE id=$insert");
        $_SESSION[insert_id] = $insert;
        mysql_close($connection);
        header("Location:new_ad3.php");

        ob_end_flush();
        
?>