<?php
include __DIR__ . "/header.php";

if(!(isset($_GET['customer']))){
    die("<div class='alert alert-danger'>Er gaat iets mis. (Login)</div>");
}

if(!isset($_SESSION['cart'])){
    die("<div class='alert alert-danger'>Er gaat iets mis. (Winkelmand)</div>");
}

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

    <?php } ?>
        </div>
</div>

<?php
include __DIR__ . "/footer.php";

?>