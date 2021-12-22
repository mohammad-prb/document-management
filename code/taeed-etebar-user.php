<?php
if (!isset($_SERVER["HTTP_REFERER"]) || parse_url($_SERVER["HTTP_REFERER"], PHP_URL_HOST) != parse_url(ADDRESS_SITE, PHP_URL_HOST)) die();

if (isset($_POST["tk"]))
{
    $token = (string)htmlspecialchars(stripcslashes(trim($_POST["tk"])));
    if (!isset($_SESSION["token"]) || $_SESSION["token"] != $token) die();
}
else
{
    die();
}