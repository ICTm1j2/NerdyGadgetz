<?php

// Onderstaande functie maakt verbinding met de database en maakt het mogelijk om een order te plaatsen.
function placeOrder($connection, $cart, $CustomerID){
    if($cart == null) return null;
    mysqli_query($connection, "START TRANSACTION;");
    $orderId = makeOrder($connection, $CustomerID);
    if($orderId == null) {
        mysqli_query($connection, "ROLLBACK;");
        return null;
    }

    if(fillOrderLines($connection, $cart, $orderId)){
        if(processStock($connection, $cart)){
            mysqli_query($connection, "COMMIT;");
            return $orderId;
        }
    }
    mysqli_query($connection, "ROLLBACK");
    return null;
}

// De volgende functie maakt verbinding met de database en creërt een order o.b.v. de CustomerID en OrderDate.
function makeOrder($connection, $CustomerID){
    $date = date("Y-m-d");
    $statement = mysqli_prepare($connection, "INSERT INTO orders_gebruiker (CustomerID, OrderDate) 
                                                        VALUES (?, ?);");
    mysqli_stmt_bind_param($statement, 'is', $CustomerID, $date);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_affected_rows($statement);
    if($result == 1) {
        return $connection->insert_id;
    }else return null;
}

// Onderstaande functie maakt verbinding met de database en voert de Orderdetails in, namelijk OrderID, StockItemID, Quantity en PickedQuantity.
function fillOrderLines($connection, $cart, $orderId){
    $error = 0;
    foreach ($cart as $item=>$quantity){
        $statement = mysqli_prepare($connection, "INSERT INTO orderlines_gebruiker (OrderID, StockItemID, Quantity, PickedQuantity) 
                                                        VALUES (?, ?, ?, ?);");
        mysqli_stmt_bind_param($statement, 'iiii', $orderId, $item, $quantity, $quantity);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_affected_rows($statement);
        if($result != 1){
            $error = $error + 1;
        }
    }
    if($error == 0){
        return true;
    } else return false;
}

//
function processStock($connection, $cart){
    $error = 0;
    foreach ($cart as $item=>$quantity){
        $result = lowerStock($connection, $item, $quantity);
        if($result == 0){
            $error = $error + 1;
        }
    }
    if($error == 0){
        return true;
    } else return false;
}

// Onderstaande functie maakt verbinding met de database en haalt de huidige voorraad op.
function getStock($connection, $itemId){
    $statement = mysqli_prepare($connection, "SELECT QuantityOnHand FROM stockitemholdings_gebruiker WHERE StockItemID = ?;");
    mysqli_stmt_bind_param($statement, 'i', $itemId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }else{
        return null;
    }
}

// De volgende functie maakt verbinding met de database en verminderd het aangegeven aantal artikelen.
function lowerStock($connection, $itemId, $lowerBy) {
    $current = getStock($connection, $itemId);
    if($current == null || $current == 0){
        return 0;
    }else{
        $newStock = $current - $lowerBy;
        $statement = mysqli_prepare($connection, "UPDATE stockitemholdings_gebruiker SET QuantityOnHand = ? WHERE StockItemID = ?");
        mysqli_stmt_bind_param($statement, 'ii', $newStock, $itemId);
        mysqli_stmt_execute($statement);
        return mysqli_stmt_affected_rows($statement) == 1;
    }
}

// Onderstaande functie haalt random producten op, deze producten worden weergegeven bij het bestellen.
function getRandomProducts ($databaseConnection) {
    $Query = "SELECT StockItemID FROM stockitems_gebruiker ORDER BY RAND() LIMIT 3;";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
}
