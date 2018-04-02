<?php
session_start();
ob_start();

include_once 'connection.php';

if($_POST['edit_profile'] == true){
    $username = $_SESSION[username];
    $salutation = $_POST['salutation'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $postcode = $_POST['postcode'];
    $areacode = $_POST['areacode'];
    $phone = $_POST['phone'];
    $fareacode = $_POST['fareacode'];
    $fax = $_POST['fax'];
    $mareacode = $_POST['mareacode'];
    $mobile = $_POST['mobile'];
    $webpage = $_POST['webpage'];
    $impressum = $_POST['impressum'];
    if($areacode == null) $areacode = 0;
    if($phone == null) $phone = 0;
    if($fareacode == null) $fareacode = 0;
    if($fax == null) $fax = 0;
    if($mareacode == null) $mareacode = 0;
    if($mobile == null) $mobile = 0;

    mysql_query("UPDATE users SET salutation='$salutation', firstname='$firstname', lastname='$lastname', webpage='$webpage', impressum='$impressum',
                 password='$password', country='$country', city='$city', number='$number', postcode='$postcode', street='$street', areacode='$areacode',
                 phone='$phone', fareacode='$fareacode', fax='$fax', mareacode='$mareacode', mobile='$mobile' WHERE username='$username'");

    header("location:myaccount.php?lin=main");
}

if ($_POST['edit_property'] == true) {
    $users_id = $_POST['p_userid'];
    $id = $_POST['pid'];
	$type = $_POST['type'];
	if($POST['secrecy'] == "show") $secrecy=0 else $secrecy =1;
	$title = ucwords(mb_strtolower($_POST['title'],"UTF-8"));
	$description = $_POST['description'];
	$location = $_POST['location'];
	$equipment = $_POST['equipment'];
	$other = $_POST['other'];
	$nb_rooms = $_POST['nb_rooms'];
	$nb_bathrooms = $_POST['nb_bathrooms'];
	$floor = $_POST['floor'];
	$living_space = $_POST['living_space'];
	$heating = $_POST['heating'];
	$price = $_POST['price'];
	$commission = $_POST['commission'];
	$deposit = $_POST['deposit'];
	$charges = $_POST['charges'];

	if($_SESSION[username] == "TDB Immobilien GmbH") {
		mysql_query("UPDATE property SET title='$title', category='$type',
				 description='$description', location='$location', equipment='$equipment',
				 other='$other', nb_rooms='$nb_rooms', nb_bathrooms='$nb_bathrooms',
				 floor='$floor', living_space='$living_space', heating='$heating',
				 price='$price', deposit='$deposit', address_sec='$secrecy', charges='$charges', commission='$commission' WHERE id='$id'");

		header("location:admin_ads.php");
	}
	else {
		$dom = new DomDocument('1.0');
		$property = $dom->appendChild($dom->createElement('property'));

		$nid = $property->appendChild($dom->createElement('id'));
		$nid->appendChild($dom->createTextNode($id));
		$ntype = $property->appendChild($dom->createElement('type'));
		$ntype->appendChild($dom->createTextNode($type));
		$nsecrecy = $property->appendChild($dom->createElement('secrecy'));
		$nsecrecy->appendChild($dom->createTextNode($secrecy));
		$ntitle = $property->appendChild($dom->createElement('title'));
		$ntitle->appendChild($dom->createTextNode($title));
		$ndescription = $property->appendChild($dom->createElement('description'));
		$ndescription->appendChild($dom->createTextNode($description));
		$nlocation = $property->appendChild($dom->createElement('location'));
		$nlocation->appendChild($dom->createTextNode($location));
		$nequipment = $property->appendChild($dom->createElement('equipment'));
		$nequipment->appendChild($dom->createTextNode($equipment));
		$nother = $property->appendChild($dom->createElement('other'));
		$nother->appendChild($dom->createTextNode($other));
		$nnb_rooms = $property->appendChild($dom->createElement('nb_rooms'));
		$nnb_rooms->appendChild($dom->createTextNode($nb_rooms));
		$nnb_bathrooms = $property->appendChild($dom->createElement('nb_bathrooms'));
		$nnb_bathrooms->appendChild($dom->createTextNode($nb_bathrooms));
		$nfloor = $property->appendChild($dom->createElement('floor'));
		$nfloor->appendChild($dom->createTextNode($floor));
		$nliving_space = $property->appendChild($dom->createElement('living_space'));
		$nliving_space->appendChild($dom->createTextNode($living_space));
		$nheating = $property->appendChild($dom->createElement('heating'));
		$nheating->appendChild($dom->createTextNode($heating));
		$nprice = $property->appendChild($dom->createElement('price'));
		$nprice->appendChild($dom->createTextNode($price));
		$ncommission = $property->appendChild($dom->createElement('commission'));
		$ncommission->appendChild($dom->createTextNode($commission));
		$ndeposit = $property->appendChild($dom->createElement('deposit'));
		$ndeposit->appendChild($dom->createTextNode($deposit));
		$ncharges = $property->appendChild($dom->createElement('charges'));
		$ncharges->appendChild($dom->createTextNode($charges));

		$dom->formatOutput = true; // set the formatOutput attribute of
		$test1 = $dom->saveXML(); // put string in test1
		$dom->save('xml_data/'.$id.'.xml'); // save as file

		mysql_query("UPDATE property SET updated=1 WHERE id='$id'");

		header("location:myaccount.php?lin=main");
	}
}


mysql_close($connection);
ob_end_flush();
?>
