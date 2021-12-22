<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$idOzv = (float)htmlspecialchars(stripcslashes(trim($_POST["id"])));
$codePerseneli = (integer)htmlspecialchars(stripcslashes(trim($_POST["cp"])));
$sathID = (integer)htmlspecialchars(stripcslashes(trim($_POST["st"])));
$nam = htmlspecialchars(filter_var(stripcslashes(trim($_POST["na"])), FILTER_SANITIZE_STRING));
$famil = htmlspecialchars(filter_var(stripcslashes(trim($_POST["fa"])), FILTER_SANITIZE_STRING));

if (!adadiAst($idOzv)) die();
if (!adadiAst($codePerseneli) || $codePerseneli < 100 || $codePerseneli > 999999) die(["er:code"]);
if (!adadiAst($sathID) || $sathID < 2 || $sathID > 4) die();
if (!farsiAst($nam)) die(["er:nam"]);
if (!farsiAst($famil)) die(["er:famil"]);

$natijeh = ["er"];

$sql = "update tbl_aza set codePerseneli = ?, nam = ?, famil = ?, sath = ? where sath > 1 and id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("issii", $codePerseneli, $nam, $famil, $sathID, $idOzv);
if ($stmt->execute() == true) $natijeh = ["ok", $codePerseneli, $nam, $famil, $sathID, $idOzv];
$stmt->close();
$con->close();

echo json_encode($natijeh);