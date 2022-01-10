<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

$deleteMelding = 0;
if(isset($_GET['action'])){
    if($_GET['action'] == "delete" && isset($_GET['productid'])){
        if(deleteProduct($_GET['productid'])){
            $deleteMelding = "<div class='container container-sm'><div class='alert alert-danger'>Je hebt een product verwijderd uit je winkelmand.</div></div>";
        }
    }
}

if(isset($_POST['updateQuantity']) && isset($_POST['updateQuantityProductId'])){
    $maxAmount = getMaxAmount($databaseConnection, $_POST['updateQuantityProductId']);
    $update = updateProduct($_POST['updateQuantityProductId'], $_POST['updateQuantity'], $maxAmount);
    if($update == 1){
        $deleteMelding = "<div class='container container-sm'><div class='alert alert-info'>Het aantal is bijgewerkt.</div></div>";
    }else if ($update == 2){
        $deleteMelding = "<div class='container container-sm'><div class='alert alert-danger'>Je hebt een product verwijderd uit je winkelmand.</div></div>";
    }else if ($update == 3){
        $deleteMelding = "<div class='container container-sm'><div class='alert alert-warning'>Het aantal is niet bijgewerkt.</div></div>";
    }else if ($update == 4){
        $deleteMelding = "<div class='container container-sm'><div class='alert alert-warning'>Sorry, je kunt niet meer dan ".$maxAmount." bestellen.</div></div>";
    }
}

$cart = getCart();
$items = array();
$amounts = array();

foreach($cart as $id=>$amount){
    $StockItem = getStockItem($id, $databaseConnection);
    $StockItemImage = getStockItemImage($id, $databaseConnection);
    $StockItem['ImagePath'] = $StockItemImage;
    array_push($items, $StockItem);
    $amounts[$id] = $amount;
}

$discount = 0;
$discountPercentage = 0;

if(isset($_POST['couponCode'])){
    $coupon = trim($_POST['couponCode']);
    (int)$result = checkCoupon($databaseConnection, $coupon);
    $discountPercentage = $result;

    if ($result == 0){
        print("<div class='container container-sm'><div class='alert alert-danger'>De ingevoerde kortingscode is helaas niet geldig, probeer het opnieuw.</div></div>");
        $discount = 0;
    }
    if ($result > 0){
        print("<div class='container container-sm'><div class='alert alert-success'>De ingevoerde kortingscode is succesvol toegepast!</div></div>");
        //zet de discount naar de factor die nog betaal moet worden, dus bijvoorbeeld 0,75.
        $discount = (100 - $result) * 0.01;
    }
}


?>
    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <title>Winkelwagen</title>
    </head>
    <body>
    <br>
    <h1 class="winkelmand-center">Winkelmand </h1>
    <div>
        <?php
        $leeg = false;

        if($deleteMelding != 0){
            print($deleteMelding);
        }else if(count($items) < 1){
            $leeg = true;
            print("<div class='container container-sm'><div class='alert alert-danger'>Je hebt nog niks in je winkelmand.</div></div>");
        }

        $total = 0;
        $totalWithDiscount = 0;

        ?>
        <div id="ResultsArea" class="container container-sm">
            <div class="row">
                <div class="col-8">
                    <?php
                    foreach ($items as $item){?>
                        <div id="ProductFrame">
                            <a class="ListItem" href='view.php?id=<?php print($item['StockItemID']) ?>'>
                                <?php
                                if (isset($item['ImagePath11111'])) { ?>
                                    <div class="ImgFrame"
                                         style="background-image: url('<?php print "Public/StockItemIMG/" . $item['ImagePath']; ?>'); background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
                                <?php } else if (isset($item['BackupImagePath1111'])) { ?>
                                    <div class="ImgFrame"
                                         style="background-image: url('<?php print "Public/StockGroupIMG/" . $item['BackupImagePath'] ?>'); background-size: cover;"></div>
                                <?php }else{
                                    ?>
                                    <div class="ImgFrame"
                                         style="background-image: url('<?php print "Public/StockGroupIMG/" . $item['ImagePath'][0]['ImagePath'] ?>'); background-size: cover;"></div>
                                    <?php
                                }
                                ?>
                            </a>
                            <h1 class="StockItemID">Artikelnummer: <?php print($item['StockItemID']) ?></h1>
                            <p class="StockItemName"><?php print($item['StockItemName']) ?></p>
                            <p class="StockItemComments"><h6>€
                                <?php
                                print sprintf(" %0.2f", $item['SellPrice']);
                                print(" Per stuk (incl. BTW)");
                                ?></h6>
                            <a role="button" class="btn btn-sm btn-danger text-light" href="cart.php?action=delete&productid=<?php print($item['StockItemID']); ?>">Verwijder</a>
                            <h4> <?php if(filter_var($item['QuantityOnHand'], FILTER_SANITIZE_NUMBER_INT) < ($amounts[$item['StockItemID']])){
                                ?></h4><p><?php $amounts[$item['StockItemID']] = filter_var($item['QuantityOnHand'], FILTER_SANITIZE_NUMBER_INT);print ("Sorry, er zijn niet meer dan " . filter_var($item['QuantityOnHand'], FILTER_SANITIZE_NUMBER_INT) . " stuks leverbaar."); $teVeelBesteld = true;?></p> <?php } ?>
                            <form method="post">
                                <input type="hidden" name="updateQuantityProductId" value="<?php print($item['StockItemID']) ?>">
                                <h4 class="ItemQuantity">Aantal: <input type="number" name="updateQuantity" class="form-control form-control-sm" value="<?php print($amounts[$item['StockItemID']]); ?>" min="1"></h4>
                            </form>
                            <div id="StockItemFrameRight">
                                <div class="CenterPriceLeftChild">
                                    <h1 class="StockItemPriceText"><?php
                                        if($item['SellPrice'] == -1){
                                            print("Niet leverbaar");
                                        }else{
                                            print sprintf(" €%0.2f", $item['SellPrice'] * $amounts[$item['StockItemID']]);
                                            print("</h1> <h6>Subtotaal (incl. BTW) </h6>");
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }

                    foreach ($items as $item) {
                        $total = $total + $item['SellPrice'] * $amounts[$item['StockItemID']];
                    }

                    foreach ($items as $item) {
                        $totalWithDiscount = $totalWithDiscount + $item['SellPrice'] * $amounts[$item['StockItemID']];
                        $totalWithDiscount = $totalWithDiscount * $discount;
                    }

                    ?>
                </div>
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Totaal: <?php
                                if ($discount == 0) {
                                    if (!(count($items) < 1)) {
                                        print(sprintf("€%.2f", $total));
                                    }
                                } elseif ($discount > 0) {
                                    if (!(count($items) < 1)) {
                                        print(sprintf("€%.2f", $total));
                                        print("<br><br><small><i>De korting van ". $discountPercentage ."% is toegevoegd! </i></small><br>Nieuw totaal: ");
                                        print(sprintf("€%.2f", $totalWithDiscount));

                                    }
                                }
                                ?></h5>
                            <?php if($leeg) {print("<p class=\"card-text\">Er zit nog niks in je winkelmand.</p>");}?>
                            <p id="text-test"></p>
                            <?php if(count($items) > 0) 
                            {
                                print("<p>Verzending: <b>gratis</b></p>");
                            } 
                            else {
                                print("");
                            }
                            ?>

                            <form method="post">
                                <input name="couponCode" type="text" class="form-control" id="couponCode" placeholder="Kortingscode" >
                                <br>
                                <input value="Toepassen" type="submit" class="btn btn-primary winkelmand-toevoegen-knop text-light">
                                <br><br><br>
                            </form>

                            <a href="afronden.php" class="btn btn-primary winkelmand-toevoegen-knop">Bestelling Afronden</a>
                        </div>
                    </div>
                </div>
            </div></div>
    </div>
    <hr>
    <center><p><a href='index.php'>Verder winkelen</a></p></center>
    </body>
    </html>
<?php
function berekenVerkoopPrijs($adviesPrijs, $btw) {
    $verkoopPrijs = $btw * $adviesPrijs / 100 + $adviesPrijs;
    if (($verkoopPrijs) < 0) {
        return -1;
    } else {
        return $verkoopPrijs;
    }
}


include "footer.php";
?>
