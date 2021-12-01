<?php

session_start(); // altijd een sessie starten omdat dit nodig is voor accounts

function createAccount($connection, $firstName, $lastName, $userName, $email, $password, $streetName, $houseNumber, $state, $city, $zipCode) {
    $statement = mysqli_prepare($connection, "INSERT INTO klanten (voornaam, achternaam, gebruikersnaam, email, wachtwoord, straatnaam, huisnummer, provincie, woonplaats, postcode) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($statement, 'ssssssssss', $firstName, $lastName, $userName, $email, $password, $streetName, $houseNumber, $state, $city, $zipCode);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}