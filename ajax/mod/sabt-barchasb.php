<?php
session_start();
date_default_timezone_set("Asia/Tehran");
include ("../../code/config.php");
include ("../../code/taeed-etebar-modir.php");
include ("../../code/lib.php");
include ("../../code/etesal-db.php");
include ("../../code/jdf.php");

$arrEtelaat = json_decode($_POST["q"]);

$barchasb = htmlspecialchars(filter_var(stripcslashes(trim($arrEtelaat[0])), FILTER_SANITIZE_STRING));
$arrDastehha = $arrEtelaat[1];

if ($barchasb == "" || !farsiAst($barchasb)) die(["er:barchasb"]);
for ($i=0; $i<count($arrDastehha); $i++)
{
    if ((float)$arrDastehha[$i] == 0) die();
}

$tarikhSabt = jdate("Y-m-d", "", "", "Asia/Tehran", "en");
$zamanSabt = jdate("H:i:s", "", "", "Asia/Tehran", "en");

$natijeh = ["er"];

$sql = "insert into tbl_barchasb (barchasb, tarikhSabt, zamanSabt) values (?,?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sss", $barchasb, $tarikhSabt, $zamanSabt);
if ($stmt->execute() == true)
{
    if (count($arrDastehha) > 0)
    {
        $idBarchasb = $stmt->insert_id;
        $stmt->free_result();

        $sql = "insert into tbl_barchasb_matlab (dastehID, barchasbID) values (" . (float)$arrDastehha[0] . ", " . $idBarchasb . ")";
        for ($i=1; $i<count($arrDastehha); $i++)
        {
            $sql .= ", (" . (float)$arrDastehha[$i] . ", " . $idBarchasb . ")";
        }

        if ($con->query($sql) === true)
        {
            $natijeh = ["ok"];
        }
        else
        {
            $sql = "delete from tbl_barchasb where id = " . $idBarchasb;
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
