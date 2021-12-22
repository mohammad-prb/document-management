<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$idBarchasb = (float)htmlspecialchars(stripcslashes(trim($_POST["id"])));
$barchasb = htmlspecialchars(filter_var(stripcslashes(trim($_POST["bj"])), FILTER_SANITIZE_STRING));

if (!adadiAst($idBarchasb)) die();
if ($barchasb == "" || !farsiAst($barchasb)) die(["er:barchasb"]);

$natijeh = ["er"];

$sql = "update tbl_barchasb set barchasb = ? where id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("si", $barchasb, $idBarchasb);
if ($stmt->execute() == true) $natijeh = ["ok", $barchasb, $idBarchasb];
$stmt->close();
$con->close();

echo json_encode($natijeh);