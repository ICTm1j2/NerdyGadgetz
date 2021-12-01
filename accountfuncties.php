<?php

function createAccount($connection, $firstName, $lastName, $userName, $email, $password, $streetName, $houseNumber, $state, $city, $zipCode) {
    $statement = mysqli_prepare($connection, "INSERT INTO klanten (voornaam, achternaam, gebruikersnaam, email, wachtwoord, straatnaam, huisnummer, provincie, woonplaats, postcode) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($statement, 'ssssssssss', $firstName, $lastName, $userName, $email, $password, $streetName, $houseNumber, $state, $city, $zipCode);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

function checkDetails($connection, $username, $password){
    $statement = mysqli_prepare($connection, "SELECT * FROM Klanten WHERE gebruikersnaam = ? AND wachtwoord = ?");
    mysqli_stmt_bind_param($statement, 'ss', $username, $password);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_get_result($statement);
}

function getGebruikersnaam($connection, $klantId){
    $statement = mysqli_prepare($connection, "SELECT gebruikersnaam FROM Klanten WHERE klantid = ? LIMIT 0,1");
    mysqli_stmt_bind_param($statement, 'i', $klantId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }else{
        return null;
    }
}