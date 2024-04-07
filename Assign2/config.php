<?php
require_once("settings.php");
mysqli_report(MYSQLI_REPORT_OFF); //Turn off default messages
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
