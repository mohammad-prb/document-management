<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$arrNatijeh = array(["ok"], []);

$sql = "select id, barchasb from tbl_barchasb order by barchasb";
$result = $con->query($sql);
if ($result !== false && $result->num_rows > 0)
{
    while ($row = $result->fetch_assoc())
    {
        array_push($arrNatijeh[1], array("id"=>$row["id"], "barchasb"=>$row["barchasb"]));
    }
}
$con->close();

echo json_encode($arrNatijeh);