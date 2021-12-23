<?php
session_start();
include ("code/config.php");
include ("code/lib.php");
include ("code/jdf.php");

if (!isset($_SERVER["HTTP_REFERER"]) || parse_url($_SERVER["HTTP_REFERER"], PHP_URL_HOST) != parse_url(ADDRESS_SITE, PHP_URL_HOST))
{
    header("HTTP/1.0 404 Not Found");
    die();
}

if (isset($_GET["tkA"]))
{
    $token = (string)htmlspecialchars(stripcslashes(trim($_GET["tkA"])));
    if (!isset($_SESSION["tokenA"]) || $_SESSION["tokenA"] != $token)
    {
        header("HTTP/1.0 404 Not Found");
        die();
    }
}
else
{
    header("HTTP/1.0 404 Not Found");
    die();
}

if (isset($_GET["id"]) && isset($_SESSION["sathFard"]))
{
    $idFile = (float)htmlspecialchars(stripcslashes(trim($_GET["id"])));
    if ($idFile == 0 || !adadiAst($idFile))
    {
        header("HTTP/1.0 404 Not Found");
        die();
    }

    if (!adadiAst($_SESSION["sathFard"]))
    {
        header("HTTP/1.0 404 Not Found");
        die();
    }
}
else
{
    header("HTTP/1.0 404 Not Found");
    die();
}

include ("code/etesal-db.php");

$sql = @"select tbl_pdf.id as idPDF from tbl_pdf
        inner join tbl_dasteh on dastehID = tbl_dasteh.id
        where tbl_pdf.id = " . $idFile . " and sath >= " . $_SESSION["sathFard"];
$result = $con->query($sql);
if ($result !== false && $result->num_rows > 0)
{
    if ($row = $result->fetch_assoc())
    {
        $addressFile = $row["idPDF"];
    }
}
else
{
    header("HTTP/1.0 404 Not Found");
    die();
}

header('Content-Type: application/pdf');

$file = fopen("pdf/" . $addressFile . ".pdf", "r");
$reshtehFile = fread($file, filesize("pdf/" . $addressFile . ".pdf"));
echo $reshtehFile . encodeTarikhVaSaatVaCode(jdate("YmdHi", "", "", "Asia/Tehran", "en"), $_SESSION["codePerseneli"]);