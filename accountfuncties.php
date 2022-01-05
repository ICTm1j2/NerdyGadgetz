<?php

function createPerson($connection, $firstName, $lastName, $email, $password, $streetName, $houseNumber, $phoneNumber, $city, $zipCode) {
    $statement = mysqli_prepare($connection, "INSERT INTO people (FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, HashedPassword, PhoneNumber, EmailAddress, ValidFrom, ValidTo, LastEditedBy) 
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

function createCustomer($connection, $peopleId, $name, $date, $phoneNumber, $address, $zipCode, $validto){
    $statement = mysqli_prepare($connection, "INSERT INTO customers (CustomerName, PrimaryContactPersonID, AccountOpenedDate, PhoneNumber, DeliveryAddressLine1, DeliveryPostalCode, PostalAddressLine1, PostalPostalCode, ValidFrom, ValidTo) 
                                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, now(), ?);");
    mysqli_stmt_bind_param($statement, 'sisssssss', $name, $peopleId, $date, $phoneNumber, $address, $zipCode, $address, $zipCode, $validto);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement);
}

function createCustomerGetId($connection, $name, $date, $phoneNumber, $address, $zipCode, $validto){
    $statement = mysqli_prepare($connection, "INSERT INTO customers (CustomerName, PrimaryContactPersonID, AccountOpenedDate, PhoneNumber, DeliveryAddressLine1, DeliveryPostalCode, PostalAddressLine1, PostalPostalCode, ValidFrom, ValidTo) 
                                                        VALUES (?, null, ?, ?, ?, ?, ?, ?, now(), ?);");
    mysqli_stmt_bind_param($statement, 'ssssssss', $name, $date, $phoneNumber, $address, $zipCode, $address, $zipCode, $validto);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_affected_rows($statement);
    if($result == 1){
        return $connection->insert_id;
    }else return null;
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

function getEmail($connection, $klantId){
    $statement = mysqli_prepare($connection, "SELECT LogonName FROM people WHERE PersonID = ? LIMIT 0,1");
    mysqli_stmt_bind_param($statement, 'i', $klantId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
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

function getCustomerIdFromAccount($connection, $PersonID){
    $statement = mysqli_prepare($connection, "SELECT CustomerID FROM Customers WHERE PrimaryContactPersonID = ?;");
    mysqli_stmt_bind_param($statement, 'i', $PersonID);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows != 1){
        return 0;
    }
    return $result->fetch_row()[0];

}

function getCustomerDetailsFromPerson($connection, $klantId){
    $statement = mysqli_prepare($connection, "SELECT CustomerName, PhoneNumber, DeliveryAddressLine1, DeliveryPostalCode FROM Customers WHERE PrimaryContactPersonID = ?;");
    mysqli_stmt_bind_param($statement, 'i', $klantId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row();
    }else{
        return null;
    }
}

function getAccountDetails($connection, $klantid){
    $statement = mysqli_prepare($connection, "SELECT P.PersonID, P.FullName, P.LogonName, P.PhoneNumber, P.ValidFrom, C.DeliveryAddressLine1, C.DeliveryPostalCode FROM People P JOIN Customers C ON P.PersonID = C.PrimaryContactPersonID
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

function changeDetails($connection, $klantid, $email, $name, $phonenumber, $address, $zipcode){
    $statement = mysqli_prepare($connection, "UPDATE Customers SET CustomerName = ?, PhoneNumber = ?, DeliveryAddressLine1 = ?, DeliveryPostalCode = ?, PostalAddressLine1 = ?, PostalPostalCode = ?
                                                    WHERE PrimaryContactPersonID = ?;");
    mysqli_stmt_bind_param($statement, 'ssssssi', $name, $phonenumber, $address, $zipcode, $address, $zipcode, $klantid);
    mysqli_stmt_execute($statement);
    if(mysqli_affected_rows($connection) == 1){
        $statement = mysqli_prepare($connection, "UPDATE People SET FullName = ?, PhoneNumber = ?, EmailAddress = ?
                    WHERE PersonID = ?;");
        mysqli_stmt_bind_param($statement, 'sssi', $name, $phonenumber, $email, $klantid);
        mysqli_stmt_execute($statement);
        if(mysqli_affected_rows($connection) == 1){
            return true;
        }
    }
    return false;
}

function changePassword($connection, $klantid, $oldpassword, $newpassword){
    $statement = mysqli_prepare($connection, "SELECT HashedPassword FROM People WHERE PersonID = ?");
    mysqli_stmt_bind_param($statement, 'i', $klantid);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        if($result->fetch_row()[0] == $oldpassword){
            // ga verder met het wachtwoord aanpassen
            $statement = mysqli_prepare($connection, "UPDATE People SET HashedPassword = ? WHERE PersonID = ?");
            mysqli_stmt_bind_param($statement, 'si', $newpassword, $klantid);
            mysqli_stmt_execute($statement);
            if(mysqli_affected_rows($connection) == 1){
                return true;
            }
        }
    }

    return false;
}

function getOrdersFromAccount($connection, $klantid){
    $customer = getCustomerIdFromAccount($connection, $klantid);
    $statement = mysqli_prepare($connection, "SELECT OrderID, OrderDate FROM orders WHERE CustomerID = ? ORDER BY OrderID DESC;");
    mysqli_stmt_bind_param($statement, 'i', $customer);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows > 0){
        return $result;
    }else{
        return null;
    }

}

//function createReview ($connection, $stockItemID $PersonID, $review, $sterren) {
//    $statement = mysqli_prepare($connection, "INSERT INTO reviews (StockItemID, PersonID, Review, Sterren)
//                                                    Values (?, ?, ?, ?);");
//    mysqli_stmt_bind_param($statement, 'iisi', $name, $stockItemID, $sersonID, $review, $sterren);
//    mysqli_stmt_execute($statement);
//    return mysqli_stmt_affected_rows($statement);
//}