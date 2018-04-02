<?php
include 'connection.php';

if ($_POST['newsletter_submit']) {
    $user_id = $_POST['user_id'];
    $category = $_POST['category'];
    $property_category = $_POST['property_category'];
    $heating = $_POST['heating'];
    $min_rooms = $_POST['min_nb_rooms'];
    $max_rooms = $_POST['max_nb_rooms'];
    $min_bathrooms = $_POST['min_nb_bathrooms'];
    $max_bathrooms = $_POST['max_nb_bathrooms'];
    $min_floor = $_POST['min_floor'];
    $max_floor = $_POST['max_floor'];
    $min_living_space = $_POST['min_living_space'];
    $max_living_space = $_POST['max_living_space'];
    $min_price = $_POST['min_price'];
    $max_price = $_POST['max_price'];
    $country = $_POST['country'];
    $city = $_POST['city'];

    if($max_bathrooms == null) $max_bathrooms=99;
    if($max_rooms == null) $max_rooms=99;
    if($max_floor == null) $max_floor=99;
    if($max_living_space == null) $max_living_space=99999999;
    if($max_price == null) $max_price=99999999;
    if($min_bathrooms == null) $min_bathrooms = 0;
    if($min_rooms == null) $min_rooms = 0;
    if($min_floor == null) $min_floor = 0;
    if($min_living_space == null) $min_living_space = 0;
    if($min_price == null) $min_price = 0;

    $query = mysql_query("INSERT INTO newsletter VALUES (null, '$user_id','$category','$property_category','$heating','$min_rooms','$max_rooms','$min_bathrooms','$max_bathrooms',
                                                      '$min_floor','$max_floor','$min_living_space','$max_living_space','$min_price','$max_price','$country','$city')");

    if($query) $process ="success";
    mysql_close($connection);
    header("Location:newsletter_register.php?process=$process");

}
?>
