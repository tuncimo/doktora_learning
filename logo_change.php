<?
session_start();
ob_start();

include_once 'connection.php';
include_once 'common.php';

$query = mysql_query("SELECT id FROM users WHERE username='$_SESSION[username]'");
$row = mysql_fetch_assoc($query);
$user_id = $row[id];
mysql_set_charset("utf-8");

if($user_id == null) die ("This php file is not for direct access!");

if($_POST['logon_s']) {
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
            echo "<h1>".UNKNOWN_EXTENSION."</h1>";
            $errors=1;
            echo "<a href='myaccount.php?lin=main'>".BACK_TO_MYACCOUNT."</a>";
        }
        else {
            $tmpName = $_FILES['logo']['tmp_name'];
            $size=filesize($_FILES['logo']['tmp_name']);
            if ($size > MAX_SIZE*1024) {
                echo "<h1>".MAX_SIZE_LIMIT."</h1>";
                $errors=1;
                echo "<a href='myaccount.php?lin=main'>".BACK_TO_MYACCOUNT."</a>";
            }
            $image_name=time().'.'.$extension;
            $newname="photos/logos/".$image_name;
            $copied = copy($_FILES['logo']['tmp_name'], $newname);
            if (!$copied) {
                echo "<h1>".PROCESS_FAILED."</h1>";
                $errors=1;
                echo "<a href='myaccount.php?lin=main'>".BACK_TO_MYACCOUNT."</a>";
            }
        }
    }
    if(!$errors) {
        mysql_query("UPDATE users SET logo_url='$newname' WHERE id=$user_id");
        header("location:myaccount.php?lin=edit");
    }
}
?>
