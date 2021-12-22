<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$idDasteh = (float)htmlspecialchars(stripcslashes(trim($_POST["id"])));
$vaziat = (integer)htmlspecialchars(stripcslashes(trim($_POST["v"])));
if (!adadiAst($idDasteh) || !adadiAst($vaziat) || $vaziat > 1) die();

$natijeh = ["er"];

$sql = "update tbl_dasteh set vaziat = ? where id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $vaziat, $idDasteh);
if ($stmt->execute() == true) $natijeh = ["ok"];
$stmt->close();
$con->close();

echo json_encode($natijeh);