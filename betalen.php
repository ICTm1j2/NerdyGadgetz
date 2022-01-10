<?php
include __DIR__ . "/header.php";

//dit is een foutmelding die naar voren komt als de customer niet goed ontvangen wordt
if(!(isset($_GET['customer']))){
    die("<div class='alert alert-danger'>Er gaat iets mis. (Login)</div>");
}

// dit is een foutmelding die naar voren komt als de cart niet goed ontvangen wort
if(!isset($_SESSION['cart'])){
    die("<div class='alert alert-danger'>Er gaat iets mis. (Winkelmand)</div>");
}

//deze functie zorgt ervoor dat er wilekeurige ID's worden gekozen
$products = getRandomProducts($databaseConnection);
$items = array();

//dit stukje hieronder zorgt ervoor dat de order in de database komt
if(isset($_POST['betaal'])){
    $order = placeOrder($databaseConnection, $_SESSION['cart'], $_GET['customer']);
    unset($_SESSION['cart']);
}


//Dit stukje hieronder haalt het ideal plaatje naar voren en de betaal knop
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
<?php // dit laat de pagina zien als de order in de database zit en geeft je je ordernummer ?>
    <h1>Bedankt voor je bestelling!</h1>
    <h3>We gaan zo snel mogelijk voor je aan de slag!</h3>
    <div class="alert alert-success">Je bestelling is geplaatst. <strong>Ordernummer: <?php print($order); ?></strong></div>
    <div id="CenteredContent">
<?php //dit hieronder zet de variabelen klaar voor de drie producten die we nog laten zien daarna. ?>
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
<?php //Dit deel hieronder zorgt ervoor dat de drie wilekeurige producten naar voren komen en de bijhorende informatie over de producten ?>
    </div>
    <div id="ResultsArea" class="container container-sm">
    <div class="row">
    <div class="col-8">
    <h4>Kijk hier ook eens naar!</h4>
    <?php
    foreach ($items as $item){?>
        <div id="ProductFrame">
            <?php //Dit deel hieronder zorgt ervoor dat er plaatjes komen bij de juiste producten ?>
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
            <?php //Dit deel geeft de wilekeurige items het artikel nummer, de naam en de sell prijs ?>
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