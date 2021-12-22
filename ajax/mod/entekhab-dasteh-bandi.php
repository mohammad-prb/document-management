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

    $sql = @"select tbl_dasteh.id as id, dasteh, sath, namSath from tbl_dasteh
            inner join tbl_sath on sath = tbl_sath.id
            where vaziat = " . $vaziat . " order by sath, dasteh limit " . ($shomSaf-1) * TEDAD_NAMAYESH_MODIRIAT . " , " . TEDAD_NAMAYESH_MODIRIAT;

    $sqlTedad = "select count(*) as tedad from tbl_dasteh where vaziat = " . $vaziat;
}
elseif ($arrEtelaat[1] == "search")
{
    $matnSearch = htmlspecialchars(filter_var(stripcslashes(trim($arrEtelaat[2])), FILTER_SANITIZE_STRING));
    $vaziat = (integer)$arrEtelaat[0];
    $shomSaf = (integer)$arrEtelaat[3];
    if ($shomSaf == 0) die();

    $sql = @"select tbl_dasteh.id as id, dasteh, sath, namSath from tbl_dasteh
            inner join tbl_sath on sath = tbl_sath.id
            where vaziat = " . $vaziat . " and dasteh LIKE '%" . $matnSearch . "%' order by sath, dasteh limit " . ($shomSaf-1) * TEDAD_NAMAYESH_MODIRIAT . " , " . TEDAD_NAMAYESH_MODIRIAT;

    $sqlTedad = "select count(*) as tedad from tbl_dasteh where vaziat = " . $vaziat . " and dasteh LIKE '%" . $matnSearch . "%'";
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
        array_push($arrNatijeh[1], array("id"=>$row["id"], "dasteh"=>$row["dasteh"], "sath"=>$row["sath"], "namSath"=>$row["namSath"]));
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
