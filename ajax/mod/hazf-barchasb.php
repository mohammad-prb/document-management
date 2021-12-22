<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$idBarchasb = (float)htmlspecialchars(stripcslashes(trim($_POST["id"])));
if (!adadiAst($idBarchasb)) die();

$natijeh = ["er"];

$sql = "delete from tbl_barchasb where id = " . $idBarchasb . "; delete from tbl_barchasb_matlab where barchasbId = " . $idBarchasb;
if ($con->multi_query($sql) === true) $natijeh = ["ok"];
$con->close();

echo json_encode($natijeh);