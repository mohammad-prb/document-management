<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");
include ("../../code/jdf.php");

$arrEtelaat = json_decode($_POST["q"]);

$dasteh = htmlspecialchars(filter_var(stripcslashes(trim($arrEtelaat[0])), FILTER_SANITIZE_STRING));
$sathID = (integer)htmlspecialchars(stripcslashes(trim($arrEtelaat[1])));
$arrBarchasbha = $arrEtelaat[2];

if (!adadiAst($sathID) || $sathID < 2 || $sathID > 4) die();
if ($dasteh == "") die(["er:dasteh"]);
for ($i=0; $i<count($arrBarchasbha); $i++)
{
    if ((float)$arrBarchasbha[$i] == 0) die();
}

$tarikhSabt = jdate("Y-m-d", "", "", "Asia/Tehran", "en");
$zamanSabt = jdate("H:i:s", "", "", "Asia/Tehran", "en");

$natijeh = ["er"];

$sql = "insert into tbl_dasteh (dasteh, sath, tarikhSabt, zamanSabt) values (?,?,?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("siss", $dasteh, $sathID, $tarikhSabt, $zamanSabt);
if ($stmt->execute() == true)
{
    if (count($arrBarchasbha) > 0)
    {
        $idDasteh = $stmt->insert_id;
        $stmt->free_result();

        $sql = "insert into tbl_barchasb_matlab (dastehID, barchasbID) values (" . $idDasteh . ", " . (float)$arrBarchasbha[0] . ")";
        for ($i=1; $i<count($arrBarchasbha); $i++)
        {
            $sql .= ", (" . $idDasteh . ", " . (float)$arrBarchasbha[$i] . ")";
        }

        if ($con->query($sql) === true)
        {
            $natijeh = ["ok"];
        }
        else
        {
            $sql = "delete from tbl_dasteh where id = " . $idDasteh;
            $con->query($sql);
        }
    }
    else
    {
        $natijeh = ["ok"];
    }
}
$stmt->close();
$con->close();

echo json_encode($natijeh);
