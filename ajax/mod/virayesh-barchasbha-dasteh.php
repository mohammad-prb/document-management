<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");

$arrEtelaat = json_decode($_POST["q"]);

$idDasteh = (integer)htmlspecialchars(stripcslashes(trim($arrEtelaat[0])));
$arrBarchasbha = $arrEtelaat[1];

if (!adadiAst($idDasteh) || $idDasteh == 0) die();

for ($i=0; $i<count($arrBarchasbha); $i++)
{
    if ((float)$arrBarchasbha[$i] == 0) die();
}

$natijeh = ["er"];

$sql = "delete from tbl_barchasb_matlab where dastehID = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idDasteh);
if ($stmt->execute() == true)
{
    if (count($arrBarchasbha) > 0)
    {
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
    }
    else
    {
        $natijeh = ["ok"];
    }
}
$stmt->close();
$con->close();

echo json_encode($natijeh);
