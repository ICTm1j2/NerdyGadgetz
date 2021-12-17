<?php
include ('database.php');

date_default_timezone_set('Europe/Amsterdam');
$dateS = date('y-m-d h:i:s', time());
echo $dateS;

$temp = $_GET["temp"];

$SQL = "INSERT INTO demo_coldroomtemperatures (RecordedWhen, Temperature) VALUES ('$dateS',$temp)";

mysqli_query($dbTemp, $SQL);
?>