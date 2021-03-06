<?php


// Onderstaande functie haalt de reviews op uit de database.
function getReviews($id ,$databaseConnection) {
    $Query = "
                SELECT P.PreferredName, R.Review, R.Stars
                FROM reviews_gebruiker R
                JOIN people_gebruiker P ON R.PersonID = P.PersonID
                WHERE R.StockItemID = ?
                ORDER BY R.ReviewID DESC
                LIMIT 0,3";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    if($result->num_rows >= 1){
        return $result;
    }
    return false;

}
// De volgende functie haalt het gemiddeld aantal sterren op. Deze gemiddelde rating wordt weergegeven bij het desbetreffende product.
function getAvgRating($connection, $stockitemid){
    $statement = mysqli_prepare($connection, "SELECT AVG(stars) 'avg' FROM Reviews_gebruiker WHERE StockItemID = ?");
    mysqli_stmt_bind_param($statement, 'i', $stockitemid);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }
    return 0;
}

// Onderstaande functie maakt het mogelijk om een review te schrijven.
function createReview($connection, $stockitemid, $personid, $review, $stars){
    $statement = mysqli_prepare($connection, "INSERT INTO Reviews_gebruiker (StockItemID, PersonID, Review, Stars) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($statement, 'iisi', $stockitemid, $personid, $review, $stars);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

// De volgende functie haalt de naam op van een product. Zo is zichtbaar over welk product je een review plaatst.
function getProductName($connection, $stockitemid){
    $statement = mysqli_prepare($connection, "SELECT StockItemName FROM Stockitems_gebruiker WHERE StockItemID = ?");
    mysqli_stmt_bind_param($statement, 'i', $stockitemid);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }
    return 0;
}