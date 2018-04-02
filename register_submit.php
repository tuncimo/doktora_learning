<?
    session_start();
    ob_start();
    //require_once 'connection.php';
    //mysql_set_charset("utf-8");

    require_once('recaptcha/recaptchalib.php');
    require_once 'connection.php';
    require_once('class.phpgmailer.php');
    //$publickey = "6Lex77kSAAAAAOPELQB-XUEoCzFPi43Rli9SJxu9";
    $publickey = "6LeLlrsSAAAAAHX_uYZTeoETCFCNidW-NuZDPjlC";
    //$privatekey = "6Lex77kSAAAAAJsgdADN9BCehL9CetbBN1lnBHn4";
    $privatekey = "6LeLlrsSAAAAAJmH4gG0Y87ApXRsJciH8yqsGn8P";

    if($_POST['user_status'] == "firm") $reg_userstatus = 1; else $reg_userstatus = 0;
    $reg_username = $_POST['username'];
    $reg_email = $_POST['email'];
    $reg_password = $_POST['password'];
    $reg_password2 = $_POST['password2'];
    $reg_salutation = $_POST['salutation'];
    $reg_firstname = $_POST['firstname'];
    $reg_lastname = $_POST['lastname'];
    $reg_street = $_POST['street'];
    $reg_number = $_POST['number'];
    $reg_postcode = $_POST['postcode'];
    $reg_city = $_POST['city'];
    $reg_country = $_POST['country'];
    $reg_year = $_POST['year'];
    $reg_month = $_POST['month'];
    $reg_day = $_POST['day'];
    $reg_areacode = $_POST['areacode'];
    $reg_phone = $_POST['phone'];
    $reg_fareacode = $_POST['fareacode'];
    $reg_fax = $_POST['fax'];
    $reg_mareacode = $_POST['mareacode'];
    $reg_mobile = $_POST['mobile'];
    $reg_website = $_POST['website'];
    $reg_impressum = $_POST['impressum'];

    if($reg_areacode == null) $reg_areacode = 0;
    if($reg_phone == null) $reg_phone = 0;
    if($reg_fareacode == null) $reg_fareacode = 0;
    if($reg_fax == null) $reg_fax = 0;
    if($reg_mareacode == null) $reg_mareacode = 0;
    if($reg_mobile == null) $reg_mobile = 0;

    $today = date('Y-m-d');
    $birthdate = $reg_year."/".$reg_month."/".$reg_day;
    if($birthdate == "//") $birthdate = "1900/01/01";
    $newname = null;

    $mail = new PHPGMailer();

    # the response from reCAPTCHA
    $resp = null;
    # the error code from reCAPTCHA, if any
    $error = null;

    # was there a reCAPTCHA response?
    if ($_POST["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer ($privatekey,
                                            $_SERVER["REMOTE_ADDR"],
                                            $_POST["recaptcha_challenge_field"],
                                            $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {
                $username_query = mysql_query("SELECT username FROM users WHERE username='$reg_username'");
                if(mysql_num_rows($username_query) == 0){
                    if($reg_userstatus == 1) {
                        define ("MAX_SIZE","1000");
                        $errors = 0;

                        function getExtension($str) {
                            $i = strrpos($str,".");
                            if (!$i) { return ""; }
                            $l = strlen($str) - $i;
                            $ext = substr($str,$i+1,$l);
                            return $ext;
                        }
                        $logo=$_FILES['logo']['name'];
                        if($logo) {
                            $filename = stripslashes($_FILES['logo']['name']);
                            $extension = getExtension($filename);
                            $extension = strtolower($extension);
                            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                                $error = UNKNOWN_FILE_EXTENSION;
                                header("Location:register.php?error=$error");
                                $errors = 1;
                            }
                            else {
                                $tmpName = $_FILES['logo']['tmp_name'];
                                $size=filesize($_FILES['logo']['tmp_name']);
                                if ($size > MAX_SIZE*1024) {
                                    $error = MAX_SIZE_LIMIT;
                                    header("Location:register.php?error=$error");
                                    $errors=1;
                                }
                                $image_name=time().'.'.$extension;
                                $newname="photos/logos/".$image_name;
                                $copied = copy($_FILES['logo']['tmp_name'], $newname);
                                if (!$copied) {
                                    $error = PROCESS_FAILED;
                                    header("Location:register.php?error=$error");
                                    $errors=1;
                                }
                            }
                        }
                    }
                    if(!$errors || $reg_userstatus == 0) {
                        mysql_query("INSERT INTO users VALUES(null, '$reg_email', '$reg_username','$reg_password','$reg_salutation','$reg_firstname','$reg_lastname',
                                                                    '$reg_areacode','$reg_phone','$reg_fareacode','$reg_fax','$reg_mareacode','$reg_mobile','$reg_website',
                                                                    '$reg_impressum','$today','$reg_street','$reg_number','$reg_postcode','$reg_city','$reg_country','$newname','$birthdate',0,'$reg_userstatus')");

                        $last_insert = mysql_insert_id();
                        if($last_insert != 0) {
                            $mail->Username   = 'noreply@tdb-immo.com';
                            $mail->Password   = 'jangomango';
                            $mail->From       = 'noreply@tdb-immo.com';
                            $mail->FromName   = 'TDB Immobilien GmbH';
                            $mail->Subject    = 'Aktivasyon';
                            $mail->AddAddress($reg_email);
                            $mail->Body       = "wenn Sie den untenstehenden Link klicken, wird Ihr Konto aktiviert werden \n http://www.tdb-immo.de/tdb_web/validate_account.php?con=1&email=$reg_email&id=$last_insert";
                            $mail->Send();
                            header("Location:validate_account.php?con=0&fn=$reg_firstname&ln=$reg_lastname");
                        }
                        else {
                            $error = AN_ERROR_OCCURED;
                            header("Location:register.php?error=$error");
                        }
                    }
                }
                else{
                    $error = USERNAME_IN_USE;
                    header("Location:register.php?error=$error");
                }
            }
            else{
                # set the error code so that we can display it
                $error = SECURITY_CODE_INCORRECT;
                header("Location:register.php?error=$error");
            }
    }
    ob_end_flush();
?>