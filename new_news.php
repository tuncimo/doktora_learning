<?
    include 'connection.php';

    if($_POST["submit"]) {
        $header = $_POST['header'];
        $ntext = $_POST['ntext'];
        $dater = date("Y-m-d H:i:s");
        mysql_query("INSERT INTO news VALUES (null, '$header','$ntext','$dater')");
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="" method="post" name="news">
            <table>
                <tr>
                    <td><?echo TITLE?> </td>
                    <td><input size="50" type="text" name="header" /></td>
                </tr>
                <tr>
                    <td width="100px" style="vertical-align:top"><?echo NEWS?> </td>
                    <td><textarea cols="45" rows="25" name="ntext"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="submit" value="<?echo SUBMIT;?>"/></td>
                </tr>
            </table>
        </form>
    </body>
</html>
