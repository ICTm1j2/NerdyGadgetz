<?php

function getReviews ($id ,$databaseConnection) {

    $Query = "
                SELECT P.PreferredName, R.Review, R.Stars
                FROM reviews R
                JOIN people P ON R.PersonID = P.PersonID
                WHERE R.StockItemID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    if($result->num_rows >= 1){
        return $result;
    }
    return false;

}

function getAvgRating($connection, $stockitemid){
    $statement = mysqli_prepare($connection, "SELECT AVG(stars) 'avg' FROM Reviews WHERE StockItemID = ?");
    mysqli_stmt_bind_param($statement, 'i', $stockitemid);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }
    return 0;
}

function createReview($connection, $stockitemid, $personid, $review, $stars){
    $statement = mysqli_prepare($connection, "INSERT INTO Reviews (StockItemID, PersonID, Review, Stars) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($statement, 'iisi', $stockitemid, $personid, $review, $stars);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}