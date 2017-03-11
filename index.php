<!DOCTYPE html>
<?php
$uploadDir = plugins_url().'/sqlifier/sqlify.php';
require 'sqlify.php';

if (isset($_POST['submit'])) {
    $file = basename($_FILES["fileToUpload"]["name"]);
    $xtos = new Sqlifier();
    $xtos->uploadxml($file);
}
?>
<html lang="en">
    <head></head>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
                Please specify a file:</br>
                <input type="file" name="fileToUpload" id="fileToUpload"></br>
                <input type="submit" value="Submit" name="submit">
        </form>
    </body>
</html>


