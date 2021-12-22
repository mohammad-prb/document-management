<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$idDasteh = (float)htmlspecialchars(stripcslashes(trim($_POST["id"])));
if (!adadiAst($idDasteh)) die();

$arrNatijeh = array("er", [], []);

$sql = @"select id, barchasb, 1 as noe from tbl_barchasb
        union all
        select tbl_barchasb.id, barchasb, 2 from tbl_barchasb
        inner join tbl_barchasb_matlab on tbl_barchasb.id = barchasbID
        where dastehID = " . $idDasteh . " order by noe, barchasb";
$result = $con->query($sql);
if ($result !== false && $result->num_rows > 0)
{
    $arrNatijeh[0] = "ok";
    while ($row = $result->fetch_assoc())
    {
        if ($row["noe"] == 1) array_push($arrNatijeh[1], array("id"=>$row["id"], "barchasb"=>$row["barchasb"]));
        elseif ($row["noe"] == 2) array_push($arrNatijeh[2], array("id"=>$row["id"], "barchasb"=>$row["barchasb"]));
    }
}
$con->close();

echo json_encode($arrNatijeh);