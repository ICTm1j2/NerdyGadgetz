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
    $update = updateProduct($_POST['updateQuantityProductId'], $_POST['updateQuantity']);
    if($update == 1){
        $deleteMelding = "<div class='container container-sm'><div class='alert alert-info'>Het aantal is bijgewerkt.</div></div>";
    }else if ($update == 2){
        $deleteMelding = "<div class='container container-sm'><div class='alert alert-danger'>Je hebt een product verwijderd uit je winkelmand.</div></div>";
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
//    array_push($amounts, $id[$amount]);
    $amounts[$id] = $amount;
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
<h1 class="winkelmand-center">Winkelmand</h1>
<div>
<?php
$leeg = false;

if($deleteMelding != 0){
    print($deleteMelding);
}else if(count($items) < 1){
    $leeg = true;
    print("<div class='container container-sm'><div class='alert alert-danger'>Je hebt nog niks in je winkelmand.</div></div>");
    }

?>

<?php
$total = 0;
foreach($items as $item){
//    print("<tr>");
//    print("<td>" . $item['StockItemID'] . "</td>");
//    print("<td><a href='view.php?id=" . $item['StockItemID'] . "'>" . $item['StockItemName'] . "</a></td>");
//    print("<td>" . sprintf("€ %.2f", $item['SellPrice']). "</td>");
//    print("<td>" . $amounts[$item['StockItemID']] . "</td>");
//    print("<td>" . sprintf("€ %.2f",$item['SellPrice'] * $amounts[$item['StockItemID']]) . "</td>");
//    print("</tr>");

    $total = $total + $item['SellPrice'] * $amounts[$item['StockItemID']];
}

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
                    <div id="StockItemFrameRight">
                        <div class="CenterPriceLeftChild">
                            <h1 class="StockItemPriceText"><?php
                                if($item['SellPrice'] == -1){
                                    print("Niet leverbaar");
                                }else{
                                    print sprintf(" %0.2f", $item['SellPrice']);
                                    print("</h1> <h6>Per stuk (incl. BTW) </h6>");
                                }
                                ?>
                        </div>
                    </div>
                    <h1 class="StockItemID">Artikelnummer: <?php print($item['StockItemID']) ?></h1>
                    <p class="StockItemName"><?php print($item['StockItemName']) ?></p>
                    <p class="StockItemComments"><a role="button" class="btn btn-sm btn-danger text-light" href="cart.php?action=delete&productid=<?php print($item['StockItemID']); ?>">Verwijder</a></p>
                    <form method="post">
                        <input type="hidden" name="updateQuantityProductId" value="<?php print($item['StockItemID']) ?>">
                    <h4 class="ItemQuantity">Aantal: <input type="number" name="updateQuantity" class="form-control form-control-sm" value="<?php print($amounts[$item['StockItemID']]); ?>" min="0"></h4>
                    </form>
                </div>
        <?php
        }
        ?>
            </div>
        <div class="col-4">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Totaal: <?php
                        if(!(count($items) < 1)){
                            print(sprintf("€ %.2f", $total));
                        }
                        ?></h5>
                    <?php if($leeg) {print("<p class=\"card-text\">Er zit nog niks in je winkelmand.</p>");}?>
                    <p id="text-test"></p>
                    <a href="afrekeninfo.php" class="btn btn-primary winkelmand-toevoegen-knop">Afrekenen</a>
                </div>
            </div>
        </div>
        </div></div>
</div>
<hr>
<center><p><a href='index.php'>Terug naar start</a></p></center>
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
?>