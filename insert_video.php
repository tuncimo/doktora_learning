<?php
        session_start();
        ob_start();
        include_once 'connection.php';
        include_once 'common.php';
        $insert = $_GET['insert'];

        $query = mysql_query("SELECT * FROM videos WHERE property_id=$insert");
        $prev_video = mysql_fetch_assoc($query);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="flowplayer/flowplayer-3.2.0.min.js"></script>
    </head>
    <body>
        <div>
            <?if($prev_video != null) {?>
            <p align="center" style="font-size:16px; font-family:arial,helvetica,verdana; font-weight:bold"><?echo VIDEO_ALREADY_DELETE;?>!</p>
            <object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="370" height="315" style="margin-left:20px">
                <param name="movie" value="jwplayer/player.swf" />
                <param name="allowfullscreen" value="true" />
                <param name="allowscriptaccess" value="always" />
                <param name="flashvars" value="file=<?echo $prev_video[url]?>" />
                <embed
                        type="application/x-shockwave-flash"
                        id="player2"
                        name="player2"
                        src="jwplayer/player.swf"
                        width="550"
                        height="398"
                        allowscriptaccess="always"
                        allowfullscreen="true"
                        flashvars="file=<?echo "$prev_video[url]"?>"
                />
            </object>
            <form action="video_delete.php" method="post" name="video_delete" style="margin-top:10px; margin-left:100px">
                <input name="previd" type="hidden" value="<?echo $prev_video[id]?>" />
                <input name="submit" type="submit" value="<?echo DELETE_VIDEO;?>" style="font-size:20px" onclick="return confirm('Emin Misiniz?')"/>
                <input type="button" value="<?echo CLOSE_WINDOW;?>" onclick="parent.parent.GB_hide()" style="font-size:20px"/>
            </form>
            <? } else { if(!isset($_POST['Submit']) || $errors) { ?>
            <form name="video_form" method="post" enctype="multipart/form-data"  action="" style="width:490px">
                <table border="0" style="margin-left:130px; bottom:30px; position:absolute">
                    <tr><td><input type="file" name="video"></td></tr>
                    <tr>
                        <td>
                            <input name="Submit" type="submit" value="<?echo UPLOAD?>">
                            <input type="button" value="<?echo CLOSE?>" onclick="parent.parent.GB_hide();" />
                        </td>
                    </tr>
                </table>
            </form>
            <? } } ?>
        </div>
    </body>
</html>


<?
//yüklenecek resmin maksimum boyutu (kilobyte)
 define ("MAX_SIZE","20000");

//Bu fonksiyon dosyanın uzantısını okuyarak video olup olmadığına karar verir.
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
 	$video=$_FILES['video']['name'];
 	//if it is not empty
 	if ($video)
 	{
 	//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['video']['name']);
 	//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 	//if it is not a known extension, we will suppose it is an error and will not  upload the file,
	//otherwise we will do more tests
 if (($extension != "flv") && ($extension != "swf") && ($extension != "mp4") && ($extension != "m4v") && ($extension != "mov"))
 		{
		//print error message
 			echo "<h1>".UNKNOWN_EXTENSION."</h1>";
                        echo "<a href='insert_video.php?insert=$insert'>";
                        echo TRY_AGAIN;
                        echo "</a>";
 			$errors=1;
 		}
 		else
 		{
//get the size of the image in bytes
 //$_FILES['image']['tmp_name'] is the temporary filename of the file
 //in which the uploaded file was stored on the server
 $size=filesize($_FILES['video']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger
if ($size > MAX_SIZE*1024)
{
	echo "<h1>".MAX_SIZE_LIMIT2."</h1>";
        echo "<a href='insert_video.php?insert=$insert'>";
        echo TRY_AGAIN;
        echo "</a>";
	$errors=1;
}

//we will give an unique name, for example the time in unix time format
$video_name=time().'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
$newname="jwplayer/videolar/".$video_name;
$url_name ="videolar/".$video_name;
//we verify if the image has been uploaded, and print error instead
$copied = copy($_FILES['video']['tmp_name'], $newname);
if (!$copied)
{
	echo "<h1>".PROCESS_FAILED2."</h1>";
        echo "<a href='insert_video.php?insert=$insert'>";
        echo TRY_AGAIN;
        echo "</a>";
	$errors=1;
}}}}

//If no errors registred, print the success message
 if(isset($_POST['Submit']) && !$errors)
 {
        mysql_query("INSERT INTO videos VALUES(null, '$insert', '$url_name')");
        $last_video = mysql_insert_id();
 	echo "<h3 style='text-align:center'>".VIDEO_UPLOADED."</h3>";
        ?>
        <object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="370" height="315" style="margin-left:20px">
            <param name="movie" value="jwplayer/player.swf" />
            <param name="allowfullscreen" value="true" />
            <param name="allowscriptaccess" value="always" />
            <param name="flashvars" value="file=<?echo $url_name?>" />
            <embed
                    type="application/x-shockwave-flash"
                    id="player2"
                    name="player2"
                    src="jwplayer/player.swf"
                    width="550"
                    height="398"
                    allowscriptaccess="always"
                    allowfullscreen="true"
                    flashvars="file=<?echo $url_name?>"
            />
        </object>
<? } ?>