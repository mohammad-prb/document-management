<?php
session_start();
include ("code/etesal-db.php");

$sql = "select id, adad from tbl_captcha order by rand() limit 1;";
$result = $con->query($sql);
if ($result !== false && $result->num_rows > 0)
{
    if ($row = $result->fetch_assoc())
    {
        $addressFile = $row["id"];
        $_SESSION["adadCaptcha"] = $row["adad"];
    }
    else die();
}
else die();

$con->close();
header('Content-Type: image/jpeg');

$file = fopen("pic/captcha/" . $addressFile . ".jpg", "r");
$reshtehFile = fread($file, filesize("pic/captcha/" . $addressFile . ".jpg"));
echo $reshtehFile;