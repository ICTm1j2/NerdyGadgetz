<?php
include __DIR__ . "/header.php";
date_default_timezone_set('Europe/Amsterdam');

$dateS = date('y-m-d h:i:s', time());
$temp = $_GET["temp"];
$validto = '9999-12-31 23:59:59';
$sensorNumber = rand(1,4);

if (getTemperatureCount($databaseConnection_admin) > 4) {
    archiveTemperature($databaseConnection_admin);
}
    $SQL = "INSERT INTO coldroomtemperatures (RecordedWhen, ColdRoomSensorNumber, Temperature, ValidFrom, ValidTo) VALUES ('$dateS', $sensorNumber,$temp, '$dateS', '$validto')";
    mysqli_query($dbTemp, $SQL);
?>


