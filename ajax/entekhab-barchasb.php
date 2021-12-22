<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../code/config.php");
include ("../code/taeed-etebar-user.php");
include ("../code/lib.php");
include ("../code/etesal-db.php");
include ("../code/jdf.php");

if (!isset($_SESSION["sathFard"]) || $_SESSION["sathFard"] > 3 || $_SESSION["sathFard"] < 1)
{
    include("../code/login.php");
    die();
}

$idBarchasb = (integer)htmlspecialchars(stripcslashes(trim($_POST["b"])));
if ($idBarchasb === "" || $idBarchasb < 0) die();

$arrDasteh = array();

if ($idBarchasb === 0)
{
    $sql = "select * from tbl_dasteh where vaziat = 1 and sath >= " . $_SESSION['sathFard'] . " order by dasteh";
}
else
{
    $sql = @"select tbl_dasteh.id as id, dasteh from tbl_dasteh
        inner join tbl_barchasb_matlab on tbl_dasteh.id = dastehID
        inner join  tbl_barchasb on tbl_barchasb.id = barchasbID
        where vaziat = 1 and barchasbID = " . $idBarchasb . " and tbl_dasteh.sath >= " . $_SESSION['sathFard'] . " order by dasteh";
}

$result = $con->query($sql);
if ($result !== false && $result->num_rows > 0)
{
    while ($row = $result->fetch_assoc())
    {
        array_push($arrDasteh, array($row["id"] ,$row["dasteh"]));
    }
    echo json_encode($arrDasteh);
}
elseif ($result !== false)
{
    echo json_encode(["er"]);
}