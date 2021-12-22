<?php
if (!isset($_SERVER["HTTP_REFERER"]) || parse_url($_SERVER["HTTP_REFERER"], PHP_URL_HOST) != parse_url(ADDRESS_SITE, PHP_URL_HOST)) die();

if (isset($_POST["tkA"]))
{
    $tokenA = (string)htmlspecialchars(stripcslashes(trim($_POST["tkA"])));
    if (!isset($_SESSION["tokenA"]) || $_SESSION["tokenA"] != $tokenA) die();
}
else
{
    die();
}