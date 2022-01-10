<?php

//hier wordt connectie gemaakt met de database en een person aangemaakt
function createPerson($connection, $firstName, $lastName, $email, $password, $streetName, $houseNumber, $phoneNumber, $city, $zipCode) {
    $statement = mysqli_prepare($connection, "INSERT INTO people_gebruiker (FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, HashedPassword, PhoneNumber, EmailAddress, ValidFrom, ValidTo, LastEditedBy) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, now(), ?, ?);");
    $name = $firstName . " " . $lastName;
    $searchName = $firstName . " " . $name;
    $validto = '9999-12-31 23:59:59';
    $ding = 1;
    mysqli_stmt_bind_param($statement, 'sssisssssi', $name, $firstName, $searchName, $ding, $email, $password, $phoneNumber, $email, $validto, $ding);
    mysqli_stmt_execute($statement);
    $result1 = mysqli_stmt_affected_rows($statement);
    $date = date("Y-m-d");
    $address = $streetName . " " . $houseNumber;
    if($result1 == 1){
        $peopleId = $connection->insert_id;
        $resultCustomer = createCustomer($connection, $peopleId, $name, $date, $phoneNumber, $address, $zipCode, $validto);
        if($resultCustomer == 1){
            return 1;
        }
    }else{
        return 0;
    }
    return 0;
}

//hier wordt connectie gemaakt met de database en een customer aangemaakt
function createCustomer($connection, $peopleId, $name, $date, $phoneNumber, $address, $zipCode, $validto){
    $statement = mysqli_prepare($connection, "INSERT INTO customers_gebruiker (CustomerName, PrimaryContactPersonID, AccountOpenedDate, PhoneNumber, DeliveryAddressLine1, DeliveryPostalCode, PostalAddressLine1, PostalPostalCode, ValidFrom, ValidTo) 
                                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, now(), ?);");
    mysqli_stmt_bind_param($statement, 'sisssssss', $name, $peopleId, $date, $phoneNumber, $address, $zipCode, $address, $zipCode, $validto);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement);
}

//hier wordt connectie gemaakt met de database en een customer aangemaakt, en het bijbehorende UserID gereturned als dat mogelijk is
function createCustomerGetId($connection, $name, $date, $phoneNumber, $address, $zipCode, $validto){
    $statement = mysqli_prepare($connection, "INSERT INTO customers_gebruiker (CustomerName, PrimaryContactPersonID, AccountOpenedDate, PhoneNumber, DeliveryAddressLine1, DeliveryPostalCode, PostalAddressLine1, PostalPostalCode, ValidFrom, ValidTo) 
                                                        VALUES (?, null, ?, ?, ?, ?, ?, ?, now(), ?);");
    mysqli_stmt_bind_param($statement, 'ssssssss', $name, $date, $phoneNumber, $address, $zipCode, $address, $zipCode, $validto);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_affected_rows($statement);
    if($result == 1){
        return $connection->insert_id;
    }else return null;
}

//hier wordt connectie gemaakt met de database en gecontrolleerd of de gegeven username en password overeen komt wat er in de database staat
function checkDetails($connection, $username, $password){
    $statement = mysqli_prepare($connection, "SELECT * FROM people_gebruiker WHERE LogonName = ? AND HashedPassword = ?");
    mysqli_stmt_bind_param($statement, 'ss', $username, $password);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_get_result($statement);
}

//hier wordt connectie gemaakt met de database en de voornaam van een klant gegeven die bij de meegegeven klantID behoort
function getFirstname($connection, $klantId){
    $statement = mysqli_prepare($connection, "SELECT PreferredName FROM people_gebruiker WHERE PersonID = ? LIMIT 0,1");
    mysqli_stmt_bind_param($statement, 'i', $klantId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }else{
        return null;
    }
}

//hier wordt connectie gemaakt met de database en de email van een klant gegeven die bij de meegegeven klantID behoort
function getEmail($connection, $klantId){
    $statement = mysqli_prepare($connection, "SELECT LogonName FROM people_gebruiker WHERE PersonID = ? LIMIT 0,1");
    mysqli_stmt_bind_param($statement, 'i', $klantId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }else{
        return null;
    }
}

//hier wordt connectie gemaakt met de database en gekeken hoeveel producten er in de cart zitten
function getAantalInWinkelmand($cart){
    if(empty($cart)) return null;
    $totaal = 0;
    foreach ($cart as $item=>$aantal){
        $totaal = $totaal + 1*$aantal;
    }

    if($totaal == 0) return null;
    return "<div class='badge badge-danger'>" . $totaal . "</div>";
}

//hier wordt connectie gemaakt met de database en de CustomerID gereturned na het meegeven van de PersonID
function getCustomerIdFromAccount($connection, $PersonID){
    $statement = mysqli_prepare($connection, "SELECT CustomerID FROM Customers_gebruiker WHERE PrimaryContactPersonID = ?;");
    mysqli_stmt_bind_param($statement, 'i', $PersonID);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows != 1){
        return 0;
    }
    return $result->fetch_row()[0];

}

//hier wordt connectie gemaakt met de database en de CustomerName, Phonenumber, DeleveryAdressLine1 en
// DeliveryPostalCode gereturned na het meegeven van de KlantID
function getCustomerDetailsFromPerson($connection, $klantId){
    $statement = mysqli_prepare($connection, "SELECT CustomerName, PhoneNumber, DeliveryAddressLine1, DeliveryPostalCode FROM Customers_gebruiker WHERE PrimaryContactPersonID = ?;");
    mysqli_stmt_bind_param($statement, 'i', $klantId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row();
    }else{
        return null;
    }
}

//hier wordt connectie gemaakt met de database en de gegevens van een klant weeergeven die bij de meegegeven KlantID hoort.
function getAccountDetails($connection, $klantid){
    $statement = mysqli_prepare($connection, "SELECT P.PersonID, P.FullName, P.LogonName, P.PhoneNumber, P.ValidFrom, C.DeliveryAddressLine1, C.DeliveryPostalCode FROM People_gebruiker P JOIN Customers_gebruiker C ON P.PersonID = C.PrimaryContactPersonID
                WHERE P.PersonID = ?");
    mysqli_stmt_bind_param($statement, 'i', $klantid);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row();
    }else{
        return null;
    }

}

//hier wordt connectie gemaakt met de database en een klant zijn gegevens aangepast, dit gebeurt dan in zowel
//de customers_gebruiker tabel als in de People_gebruiker tabel
function changeDetails($connection, $klantid, $email, $name, $phonenumber, $address, $zipcode){
    $statement = mysqli_prepare($connection, "UPDATE Customers_gebruiker SET CustomerName = ?, PhoneNumber = ?, DeliveryAddressLine1 = ?, DeliveryPostalCode = ?, PostalAddressLine1 = ?, PostalPostalCode = ?
                                                    WHERE PrimaryContactPersonID = ?;");
    mysqli_stmt_bind_param($statement, 'ssssssi', $name, $phonenumber, $address, $zipcode, $address, $zipcode, $klantid);
    mysqli_stmt_execute($statement);
    if(mysqli_affected_rows($connection) == 1){
        $statement = mysqli_prepare($connection, "UPDATE People_gebruiker SET FullName = ?, PhoneNumber = ?, EmailAddress = ?
                    WHERE PersonID = ?;");
        mysqli_stmt_bind_param($statement, 'sssi', $name, $phonenumber, $email, $klantid);
        mysqli_stmt_execute($statement);
        if(mysqli_affected_rows($connection) == 1){
            return true;
        }
    }
    return false;
}

//hier wordt connectie gemaakt met de database en eerst gecontrolleerd of het meegegeven oude wachtwoord overeenkomt met de bijbehorende
//klantId, mocht dit fout zijn returned die false, mocht dit correct zijn gaat die verder met het updaten van het oude wachtwoord naar
//het nieuwe wachtwoord, en wordt er een true gereturned.
function changePassword($connection, $klantid, $oldpassword, $newpassword){
    $statement = mysqli_prepare($connection, "SELECT HashedPassword FROM People_gebruiker WHERE PersonID = ?");
    mysqli_stmt_bind_param($statement, 'i', $klantid);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        if($result->fetch_row()[0] == $oldpassword){
            // ga verder met het wachtwoord aanpassen
            $statement = mysqli_prepare($connection, "UPDATE People_gebruiker SET HashedPassword = ? WHERE PersonID = ?");
            mysqli_stmt_bind_param($statement, 'si', $newpassword, $klantid);
            mysqli_stmt_execute($statement);
            if(mysqli_affected_rows($connection) == 1){
                return true;
            }
        }
    }

    return false;
}

//hier wordt connectie gemaakt met de database en worden alle rows aan orders van een bijbehorende klantID gereturned als die er zijn
function getOrdersFromAccount($connection, $klantid){
    $customer = getCustomerIdFromAccount($connection, $klantid);
    $statement = mysqli_prepare($connection, "SELECT OrderID, OrderDate FROM orders_gebruiker WHERE CustomerID = ? ORDER BY OrderID DESC;");
    mysqli_stmt_bind_param($statement, 'i', $customer);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows > 0){
        return $result;
    }else{
        return null;
    }

}