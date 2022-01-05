<?php
include __DIR__ . "/header.php";
$reviews = getReviews(1, $databaseConnection);
if($reviews != false){
    while($row = mysqli_fetch_assoc($reviews)){
        print_r($row);
        print($row['ReviewText']);
        print("<br>");
    }
}


?>