<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$idOzv = (float)htmlspecialchars(stripcslashes(trim($_POST["id"])));
$vaziat = (integer)htmlspecialchars(stripcslashes(trim($_POST["v"])));
if (!adadiAst($idOzv) || !adadiAst($vaziat) || $vaziat > 1) die();

$natijeh = ["er"];

$sql = "update tbl_aza set vaziat = " . $vaziat ." where sath > 1 AND id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idOzv);
if ($stmt->execute() == true) $natijeh = ["ok"];
$stmt->close();
$con->close();

echo json_encode($natijeh);