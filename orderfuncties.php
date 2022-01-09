<?php

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


function makeOrder($connection, $CustomerID){
    $date = date("Y-m-d");
    $statement = mysqli_prepare($connection, "INSERT INTO orders (CustomerID, OrderDate) 
                                                        VALUES (?, ?);");
    mysqli_stmt_bind_param($statement, 'is', $CustomerID, $date);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_affected_rows($statement);
    if($result == 1) {
        return $connection->insert_id;
    }else return null;
}

function fillOrderLines($connection, $cart, $orderId){
    $error = 0;
    foreach ($cart as $item=>$quantity){
        $statement = mysqli_prepare($connection, "INSERT INTO orderlines (OrderID, StockItemID, Quantity, PickedQuantity) 
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

function getStock($connection, $itemId){
    $statement = mysqli_prepare($connection, "SELECT QuantityOnHand FROM stockitemholdings WHERE StockItemID = ?;");
    mysqli_stmt_bind_param($statement, 'i', $itemId);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }else{
        return null;
    }
}

function lowerStock($connection, $itemId, $lowerBy) {
    $current = getStock($connection, $itemId);
    if($current == null || $current == 0){
        return 0;
    }else{
        $newStock = $current - $lowerBy;
        $statement = mysqli_prepare($connection, "UPDATE stockitemholdings SET QuantityOnHand = ? WHERE StockItemID = ?");
        mysqli_stmt_bind_param($statement, 'ii', $newStock, $itemId);
        mysqli_stmt_execute($statement);
        return mysqli_stmt_affected_rows($statement) == 1;
    }
}

function getRandomProducts ($databaseConnection) {
    $Query = "SELECT StockItemID FROM stockitems ORDER BY RAND() LIMIT 3;";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
}
