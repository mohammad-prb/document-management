<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");
include ("../../code/jdf.php");

$codePerseneli = (integer)htmlspecialchars(stripcslashes(trim($_POST["cp"])));
$sathID = (integer)htmlspecialchars(stripcslashes(trim($_POST["st"])));
$nam = htmlspecialchars(filter_var(stripcslashes(trim($_POST["na"])), FILTER_SANITIZE_STRING));
$famil = htmlspecialchars(filter_var(stripcslashes(trim($_POST["fa"])), FILTER_SANITIZE_STRING));

if (!adadiAst($codePerseneli) || $codePerseneli < 100 || $codePerseneli > 999999) die(["er:code"]);
if (!adadiAst($sathID) || $sathID < 2 || $sathID > 4) die();
if (!farsiAst($nam)) die(["er:nam"]);
if (!farsiAst($famil)) die(["er:famil"]);

$ramz = getPassword();
$tarikhSabt = jdate("Y-m-d", "", "", "Asia/Tehran", "en");
$zamanSabt = jdate("H:i:s", "", "", "Asia/Tehran", "en");

$natijeh = ["er"];

$sql = "insert into tbl_aza (codePerseneli, nam, famil, pass, sath, tarikhSabt, zamanSabt) values (?,?,?,?,?,?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("isssiss", $codePerseneli, $nam, $famil, hash("md5", $ramz), $sathID, $tarikhSabt, $zamanSabt);
if ($stmt->execute() == true) $natijeh = ["ok", $ramz];
$stmt->close();
$con->close();

echo json_encode($natijeh);
