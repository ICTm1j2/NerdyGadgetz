<?php
include __DIR__ . "/header.php";

if(!(isset($_GET['customer']))){
    die("<div class='alert alert-danger'>Er gaat iets mis. (Login)</div>");
}

if(!isset($_SESSION['cart'])){
    die("<div class='alert alert-danger'>Er gaat iets mis. (Winkelmand)</div>");
}

$products = getRandomProducts($databaseConnection);
$items = array();

if(isset($_POST['betaal'])){
    $order = placeOrder($databaseConnection, $_SESSION['cart'], $_GET['customer']);
    unset($_SESSION['cart']);
}
?>

    <div class="container container-sm">
    <div class="text-center">
<?php if(!isset($_POST['betaal'])){ ?>
    <img width="750" src="Public\Img\ideal.png">
    <form method="post">
        <input type="hidden" name="betaal" value="yes">
        <br><button class="btn btn-lg btn-success" type="submit">Betalen</button>
    </form>
<?php }else { ?>
    <h1>Bedankt voor je bestelling!</h1>
    <h3>We gaan zo snel mogelijk voor je aan de slag!</h3>
    <div class="alert alert-success">Je bestelling is geplaatst. <strong>Ordernummer: <?php print($order); ?></strong></div>
    <div id="CenteredContent">
        <?php
        foreach($products as $product) {
            foreach ($product as $producten) {
                $StockItem = getStockItem($producten, $databaseConnection);
                $StockItemImage = getStockItemImage($producten, $databaseConnection);
                $StockItem['ImagePath'] = $StockItemImage;
                array_push($items, $StockItem);
            }
        }
        ?>
    </div>
    <div id="ResultsArea" class="container container-sm">
    <div class="row">
    <div class="col-8">
    <h4>Kijk hier ook eens naar!</h4>
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

        </div>

    <?php }} ?>
    </div>
    </div>

<?php

include __DIR__ . "/footer.php";

?>