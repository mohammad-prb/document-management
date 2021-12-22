<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

if (!isset($_POST["q"])) die();

$arrEtelaat = json_decode($_POST["q"]);
if ($arrEtelaat[1] == "hameh")
{
    $vaziat = (integer)$arrEtelaat[0];
    $shomSaf = (integer)$arrEtelaat[3];
    if ($shomSaf == 0) die();

    $sql = @"select tbl_pdf.id as id, tarikhErsal, zamanErsal, dasteh from tbl_pdf
            inner join tbl_dasteh on dastehID = tbl_dasteh.id
            where tbl_pdf.vaziat = " . $vaziat . " order by tbl_pdf.id desc limit " . ($shomSaf-1) * TEDAD_NAMAYESH_MODIRIAT . " , " . TEDAD_NAMAYESH_MODIRIAT;

    $sqlTedad = "select count(*) as tedad from tbl_pdf where vaziat = " . $vaziat;
}
elseif ($arrEtelaat[1] == "dasteh")
{
    $matnSearch = (integer)$arrEtelaat[2];
    $vaziat = (integer)$arrEtelaat[0];
    $shomSaf = (integer)$arrEtelaat[3];
    if ($shomSaf == 0) die();

    $sql = @"select tbl_pdf.id as id, tarikhErsal, zamanErsal, dasteh from tbl_pdf
            inner join tbl_dasteh on dastehID = tbl_dasteh.id
            where tbl_pdf.vaziat = " . $vaziat . " and dastehID = " . $matnSearch . " order by tbl_pdf.id desc limit " . ($shomSaf-1) * TEDAD_NAMAYESH_MODIRIAT . " , " . TEDAD_NAMAYESH_MODIRIAT;

    $sqlTedad = "select count(*) as tedad from tbl_pdf where vaziat = " . $vaziat . " and dastehID = " . $matnSearch;
}
elseif ($arrEtelaat[1] == "search")
{
    $matnSearch = htmlspecialchars(filter_var(stripcslashes(trim($arrEtelaat[2])), FILTER_SANITIZE_STRING));
    $matnSearch = str_replace("/", "-", $matnSearch);
    $vaziat = (integer)$arrEtelaat[0];
    $shomSaf = (integer)$arrEtelaat[3];
    if ($shomSaf == 0) die();

    $sql = @"select tbl_pdf.id as id, tarikhErsal, zamanErsal, dasteh from tbl_pdf
            inner join tbl_dasteh on dastehID = tbl_dasteh.id
            where tbl_pdf.vaziat = " . $vaziat . " and tarikhErsal LIKE '%" . $matnSearch . "%' order by tbl_pdf.id desc limit " . ($shomSaf-1) * TEDAD_NAMAYESH_MODIRIAT . " , " . TEDAD_NAMAYESH_MODIRIAT;

    $sqlTedad = "select count(*) as tedad from tbl_pdf where vaziat = " . $vaziat . " and tarikhErsal LIKE '%" . $matnSearch . "%'";
}
else
{
    die();
}

$arrNatijeh = array(["er", "er"], [], 0);

$result = $con->query($sql);
if ($result !== false && $result->num_rows > 0)
{
    $arrNatijeh[0][0] = "ok";
    while ($row = $result->fetch_assoc())
    {
        array_push($arrNatijeh[1], array("id"=>$row["id"], "tarikhErsal"=>str_replace('-','/',$row["tarikhErsal"]), "zamanErsal"=>substr($row["zamanErsal"],0,5), "dasteh"=>$row["dasteh"]));
    }
}
elseif ($result !== false)
{
    $arrNatijeh[0][0] = "n0";
}
$result->free();

$result = $con->query($sqlTedad);
if ($result !== false && $result->num_rows > 0)
{
    $arrNatijeh[0][1] = "ok";
    if ($row = $result->fetch_assoc())
    {
        $arrNatijeh[2] = (integer)$row["tedad"];
    }
}
elseif ($result !== false)
{
    $arrNatijeh[0][1] = "n0";
}
$con->close();

echo json_encode($arrNatijeh);
