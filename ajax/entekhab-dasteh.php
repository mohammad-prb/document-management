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

$idDasteh = (float)htmlspecialchars(stripcslashes(trim($_POST["d"])));
$shomSaf = (integer)htmlspecialchars(stripcslashes(trim($_POST["ss"])));

if (!adadiAst($idDasteh) || $idDasteh == 0) die();
if (!adadiAst($shomSaf) || $shomSaf == 0) die();

$arrPDF = array("er");

$sql = @"select tbl_pdf.id as id, tarikhErsal, zamanErsal from tbl_pdf
         inner join tbl_dasteh on tbl_dasteh.id = dastehID 
         where tbl_pdf.vaziat = 1 and dastehID = " . $idDasteh . " and sath >= " . $_SESSION['sathFard'] . @" 
         order by tbl_pdf.id desc limit " . ($shomSaf-1) * TEDAD_NAMAYESH_PDF . " , " . TEDAD_NAMAYESH_PDF;
$result = $con->query($sql);
if ($result !== false && $result->num_rows > 0)
{
    $arrPDF = array("er", array());
    while ($row = $result->fetch_assoc())
    {
        array_push($arrPDF[1], array($row["id"] ,$row["tarikhErsal"] ,$row["zamanErsal"]));
    }

    $result->free_result();

    $sql = @"select count(*) as tedad from tbl_pdf
             inner join tbl_dasteh on tbl_dasteh.id = dastehID 
             where tbl_pdf.vaziat = 1 and dastehID = " . $idDasteh . " and sath >= " . $_SESSION['sathFard'];
    $result = $con->query($sql);
    if ($result !== false && $result->num_rows > 0)
    {
        $arrPDF[0] = "ok";
        if ($row = $result->fetch_assoc())
        {
            $arrPDF[2] = $row["tedad"];
        }
    }
}

echo json_encode($arrPDF);