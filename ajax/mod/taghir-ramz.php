<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$idOzv = (integer)htmlspecialchars(stripcslashes(trim($_POST["id"])));
if (!adadiAst($idOzv)) die();

$natijeh = ["er"];
$ramzJadid = getPassword();

$sql = "update tbl_aza set pass = ? where vaziat = 1 and id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("si", hash("md5", $ramzJadid), $idOzv);
if ($stmt->execute() == true) $natijeh = ["ok", $ramzJadid];
$stmt->close();
$con->close();

echo json_encode($natijeh);
