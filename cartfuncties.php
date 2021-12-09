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