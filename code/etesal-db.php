<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "db_safa";
$con = new mysqli($serverName, $userName, $password, $dbName);
if ($con->connect_error) die("مشکلی در بارگزاری پیش آمده");
$con->set_charset("utf8");