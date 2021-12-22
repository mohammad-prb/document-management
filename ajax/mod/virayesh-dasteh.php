<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$idDasteh = (float)htmlspecialchars(stripcslashes(trim($_POST["id"])));
$daseh = htmlspecialchars(filter_var(stripcslashes(trim($_POST["ds"])), FILTER_SANITIZE_STRING));
$sathID = (integer)htmlspecialchars(stripcslashes(trim($_POST["st"])));

if (!adadiAst($idDasteh)) die();
if ($daseh == "") die(["er:daseh"]);
if (!adadiAst($sathID) || $sathID < 2 || $sathID > 4) die();

$natijeh = ["er"];

$sql = "update tbl_dasteh set dasteh = ?, sath = ? where id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("sii", $daseh, $sathID, $idDasteh);
if ($stmt->execute() == true) $natijeh = ["ok", $daseh, $sathID, $idDasteh];
$stmt->close();
$con->close();

echo json_encode($natijeh);