<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$natijeh = ["er"];

$sql = @"select count(*) as tedad from tbl_aza where vaziat = 1
        union all
        select count(*) from tbl_aza where vaziat = 1 and sath = 2
        union all
        select count(*) from tbl_aza where vaziat = 1 and sath = 3
        union all
        select count(*) from tbl_aza where vaziat = 1 and sath = 4
        union all
        select count(*) from tbl_dasteh where vaziat = 1
        union all
        select count(*) from tbl_dasteh where vaziat = 1 and sath = 2
        union all
        select count(*) from tbl_dasteh where vaziat = 1 and sath = 3
        union all
        select count(*) from tbl_dasteh where vaziat = 1 and sath = 4
        union all
        select count(*) from tbl_pdf where vaziat = 1
        union all
        select count(*) from tbl_barchasb
        union all
        select barchasb from (
            select barchasb, count(*) as tedad from tbl_barchasb_matlab
            inner join tbl_barchasb on tbl_barchasb.id = barchasbID
            group by barchasbID
            order by tedad desc limit 1) as porEstefadeh";
$result = $con->query($sql);
if ($result !== false && $result->num_rows > 0)
{
    $natijeh = ["ok", array()];
    while ($row = $result->fetch_assoc())
    {
        array_push($natijeh[1], $row["tedad"]);
    }
}
$con->close();

echo json_encode($natijeh);
