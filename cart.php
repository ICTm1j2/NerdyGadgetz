<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

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
<h1 class="winkelmand-center">Winkelmand</h1>
<div>
<?php
    if(count($items) < 1){
        print("<div class='alert alert-danger'>Je hebt nog niks in je winkelmand.</div>");
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
        <?php
        foreach ($items as $item){?>
            <a class="ListItem" href='view.php?id=<?php print($item['StockItemID']) ?>'>
                <div id="ProductFrame">
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
                    <p class="StockItemComments">Comment</p>
                    <h4 class="ItemQuantity">Aantal: <?php print($amounts[$item['StockItemID']]); ?></h4>
                </div>
            </a>
        <?php
        }
        ?>
    </div>
    <?php
    if(!(count($items) < 1)){
        print("<strong>" . sprintf("€ %.2f", $total) . "</strong>");
    }
    ?>

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