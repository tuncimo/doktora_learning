<?php
        session_start();
        ob_start();
        include_once 'connection.php';
        include_once 'common.php';

        $insert = $_GET['insert'];
        $query = mysql_query("SELECT url FROM photos WHERE property_id=$insert");
        while($row = mysql_fetch_assoc($query)) {
            $ph[] = $row;
        }

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div style="width:780px; height:auto; max-height:230px; border-bottom:2px solid; overflow:hidden">
            <h3 style="text-align:center"><?echo PHOTOS_OF_THIS_PROPERTY;?>:</h3>
            <? if(count($ph) == 0) { ?>
            <h3 style="text-align:center"><?echo NO_PHOTOS_ADDED_YET;?></h3>
            <? } else { ?>
            <?foreach($ph as $p) {?>
            <img height="80px" src="<?print($p[url])?>"/>
            <? } } ?>
        </div>
        <div style="bottom:10px; padding-top:10px; position:absolute; border-top:2px solid; width:780px">
            <form name="image_form" method="post" enctype="multipart/form-data"  action="" style="width:690px">
                <table border="0" style="margin-left:260px; width:auto">
                    <tr><td><?echo TITLE?>: <input type="text" name="title"></td></tr>
                    <tr><td><?echo FILE?>: <input type="file" name="image"></td></tr>
                    <tr>
                        <td style="padding-top:10px; padding-left:50px">
                            <input name="Submit" type="submit" value="<?echo UPLOAD?>">
                            <input type="button" value="<?echo CLOSE?>" onclick="parent.parent.GB_hide();" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>


<?
//yüklenecek resmin maksimum boyutu (kilobyte)
 define ("MAX_SIZE","1000");

//Bu fonksiyon dosyanın uzantısını okuyarak resim olup olmadığına karar verir.
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

//This variable is used as a flag. The value is initialized with 0 (meaning no error  found)
//and it will be changed to 1 if an error occures.
//If the error occures the file will not be uploaded.
 $errors=0;
//checks if the form has been submitted
 if(isset($_POST['Submit']))
 {
 	//reads the name of the file the user submitted for uploading
 	$image=$_FILES['image']['name'];
 	//if it is not empty
 	if ($image)
 	{
 	//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['image']['name']);
 	//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 	//if it is not a known extension, we will suppose it is an error and will not  upload the file,
	//otherwise we will do more tests
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))
 		{
		//print error message
                    echo "<h1>".UNKNOWN_FILE_EXTENSION."</h1>";
                    $errors=1;
 		}
 		else
 		{
                    //filigran'ın yerini belirlemek için!!!!!!!
                    $tmpName = $_FILES['image']['tmp_name'];
                    list($width, $height) = getimagesize($tmpName);
                    if($extension == jpg ||  $extension == jpeg) $basel = @imagecreatefromjpeg($tmpName);
                    if($extension == png) $basel = @imagecreatefrompng($tmpName);
                    if($extension == gif) $basel = @imagecreatefromgif($tmpName);

                    if(!is_resource($basel))
                    {
                         die('Fotoğrafın uzantısı tanındı; fakat biçimiyle ilgili bir sorun var');
                    }

                    $watermark = @imagecreatefrompng("resimler/watermark.png");
                    imagesavealpha($basel, true);
                    imagecopy($basel,$watermark,($width-325)/2,($height-60)/2,0,0,325,60);



//get the size of the image in bytes
 //$_FILES['image']['tmp_name'] is the temporary filename of the file
 //in which the uploaded file was stored on the server
 $size=filesize($_FILES['image']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger
if ($size > MAX_SIZE*1024)
{
	echo "<h1>".MAX_SIZE_LIMIT."</h1>";
	$errors=1;
}

//we will give an unique name, for example the time in unix time format
$image_name=time().'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
$newname="photos/".$image_name;
//we verify if the image has been uploaded, and print error instead

$copied = imagejpeg($basel,$newname);
//$copied = copy($_FILES['image']['tmp_name'], $newname);
if (!$copied)
{
	echo "<h1>".PROCESS_FAILED."</h1>";
	$errors=1;
}}}}

//If no errors registred, print the success message
 if(isset($_POST['Submit']) && !$errors)
 {
     if(mysql_num_rows(mysql_query("SELECT id FROM photos WHERE property_id=$insert")) > 9) {
        echo "<h3 style='text-align:center'>".MAX_TEN_PHOTOS."</h3>";
     }
     else {
        $title = $_POST['title'];
        mysql_query("INSERT INTO photos VALUES(null, '$insert', '$newname','$title')");
        $last_image = mysql_insert_id();
 	echo "<h3 style='text-align:center'>".PHOTO_UPLOADED_A_NEW_ONE."</h3>";
        echo "<img style='width:200; height:auto; margin-left:300px' src='$newname'/>";
     }
        
 }
    
?>