<?php

function createAccount($connection, $firstName, $lastName, $email, $password, $streetName, $houseNumber, $phoneNumber, $city, $zipCode) {
    $statement = mysqli_prepare($connection, "INSERT INTO people (FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, HashedPassword, PhoneNumber, EmailAddress, ValidFrom, ValidTo, LastEditedBy) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?);");
    $name = $firstName . " " . $lastName;
    $searchName = $firstName . " " . $name;
    $validto = "9999-12-31 23:59:59";
    $ding = 1;
    mysqli_stmt_bind_param($statement, 'sssissssis', $name, $firstName, $searchName, $ding, $email, $password, $phoneNumber, $email, $validto, $ding);
    mysqli_stmt_execute($statement);
    $result1 = mysqli_stmt_affected_rows($statement);
    $date = date("Y-m-d");
    $address = $streetName . " " . $houseNumber;
    if($result1 == 1){
        $peopleId = $connection->insert_id;
        $statement = mysqli_prepare($connection, "INSERT INTO customers (CustomerName, PrimaryContactPersonID, AccountOpenedDate, PhoneNumber, DeliveryAddressLine1, DeliveryPostalCode, PostalAddressLine1, PostalPostalCode, ValidFrom, ValidTo) 
                                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, now(), ?);");
        mysqli_stmt_bind_param($statement, 'sisssssss', $name, $peopleId, $date, $phoneNumber, $address, $zipCode, $address, $zipCode, $validto);
        mysqli_stmt_execute($statement);
        $result2 = mysqli_stmt_affected_rows($statement);
        if($result2 == 1){
            return 1;
        }
    }else{
        return 0;
    }
    return 0;
}

function checkDetails($connection, $username, $password){
    $statement = mysqli_prepare($connection, "SELECT * FROM people WHERE LogonName = ? AND HashedPassword = ?");
    mysqli_stmt_bind_param($statement, 'ss', $username, $password);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_get_result($statement);
}

function getFirstname($connection, $klantId){
    $statement = mysqli_prepare($connection, "SELECT PreferredName FROM people WHERE PersonID = ? LIMIT 0,1");
    mysqli_stmt_bind_param($statement, 'i', $klantId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }else{
        return null;
    }
}

function getGegevens($connection, $klantId) {
    $statement = mysqli_prepare($connection, "SELECT voornaam, achternaam, email, straatnaam, huisnummer, provincie, woonplaats, postcode FROM Klanten WHERE klantid = ? LIMIT 0,1");
    mysqli_stmt_bind_param($statement, 'i', $klantId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row();
    }else{
        return null;
    }
}

function getAantalInWinkelmand($cart){
    if(empty($cart)) return null;
    $totaal = 0;
    foreach ($cart as $item=>$aantal){
        $totaal = $totaal + 1*$aantal;
    }

    if($totaal == 0) return null;
    return "<div class='badge badge-danger'>" . $totaal . "</div>";
}