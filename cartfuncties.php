<?php

function getCart(){
    if(isset($_SESSION['cart'])){               //controleren of winkelmandje (=cart) al bestaat
        $cart = $_SESSION['cart'];                  //zo ja:  ophalen
    } else{
        $cart = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                               // resulterend winkelmandje terug naar aanroeper functie
}

function saveCart($cart){
    $_SESSION["cart"] = $cart;                  // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addProductToCart($stockItemID){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if(array_key_exists($stockItemID, $cart)){  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += 1;                   //zo ja:  aantal met 1 verhogen
    }else{
        $cart[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}

function deleteProduct($stockItemID){
    $cart = getCart();

    if(array_key_exists($stockItemID, $cart)){
        unset($cart[$stockItemID]);
        saveCart($cart);
        return true;
    }else{
        return false;
    }
}

function updateProduct($stockItemID, $quantity){
    if(($quantity == null)) {
        return 3;
    }

    $cart = getCart();
    if(array_key_exists($stockItemID, $cart)){
        $cart[$stockItemID] = $quantity;
        saveCart($cart);
        return 1;
    }else{
        return 0;
    }
}

function getMaxAmount($connection, $stockitemid) {
    $Query = "    SELECT QuantityOnHand
                FROM stockitemholdings_gebruiker 
                WHERE StockItemID = ?";
    $Statement = mysqli_prepare($connection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $stockitemid);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);

    return $result->fetch_row()[0];
}

//check of de couponcode in de databse staat, als die er in staat returned die het percentage aan korting, zo niet dan returned die null.
function checkCoupon($connection, $coupon){
    $statement = mysqli_prepare($connection, "SELECT Percentage 
                                                    FROM coupons_gebruiker 
                                                    WHERE Coupon = ?");
    mysqli_stmt_bind_param($statement, 's', $coupon);
    mysqli_stmt_execute($statement);
    $result =  mysqli_stmt_get_result($statement);
    if($result->num_rows == 1){
        return $result->fetch_row()[0];
    }else{
        return null;
    }
}