<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

if (!isset($_POST["q"])) die();

$arrEtelaat = json_decode($_POST["q"]);
if ($arrEtelaat[0] == "hameh")
{
    $shomSaf = (integer)$arrEtelaat[2];
    if ($shomSaf == 0) die();

    $sql = @"select id, barchasb from tbl_barchasb order by barchasb limit " . ($shomSaf-1) * 15 . " , " . 15;

    $sqlTedad = "select count(*) as tedad from tbl_barchasb";
}
elseif ($arrEtelaat[0] == "dasteh")
{
    $matnSearch = (integer)$arrEtelaat[1];
    $shomSaf = (integer)$arrEtelaat[2];
    if ($shomSaf == 0) die();

    $sql = @"select tbl_barchasb.id as id, barchasb from tbl_barchasb 
            inner join tbl_barchasb_matlab on tbl_barchasb.id = barchasbID
            where dastehID = " . $matnSearch . " order by barchasb limit " . ($shomSaf-1) * 15 . " , " . 15;

    $sqlTedad = "select count(*) as tedad from tbl_barchasb where tbl_barchasb.id = " . $matnSearch;
}
elseif ($arrEtelaat[0] == "search")
{
    $matnSearch = htmlspecialchars(filter_var(stripcslashes(trim($arrEtelaat[1])), FILTER_SANITIZE_STRING));
    $shomSaf = (integer)$arrEtelaat[2];
    if ($shomSaf == 0 || !farsiAst($matnSearch)) die();

    $sql = @"select id, barchasb from tbl_barchasb where barchasb LIKE '%" . $matnSearch . "%' order by barchasb limit " . ($shomSaf-1) * 15 . " , " . 15;

    $sqlTedad = "select count(*) as tedad from tbl_barchasb where barchasb LIKE '%" . $matnSearch . "%'";
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
        array_push($arrNatijeh[1], array("id"=>$row["id"], "barchasb"=>$row["barchasb"]));
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
