<?php
include __DIR__ . "/header.php";

if(!(isset($_POST['firstname']))){
    die("<div class='alert alert-danger'>Er gaat iets mis...</div>");
}

$cart = $_SESSION['cart'];
$voornaam = $_POST['firstname'];
$achternaam = $_POST['lastname'];
$email = $_POST['email'];
$straat = $_POST['streetname'];
$huisnummer = $_POST['housenumber'];
$provincie = $_POST['state'];
$woonplaats = $_POST['city'];
$postcode = $_POST['zip'];

if(isset($_POST['betaal'])){
    print("<br><div class='container container-sm'><div class='alert alert-success'>Bedankt voor je bestelling! We gaan zo snel mogelijk aan de slag!</div></div>");
}


?>

    <div class="container container-sm">
        <div class="text-center">
    <img width="750" src="Public\Img\ideal.png">
    <form method="post">
        <input type="hidden" value="<?php print($voornaam); ?>" name="firstname">
        <input type="hidden" value="<?php print($achternaam); ?>" name="lastname">
        <input type="hidden" value="<?php print($email); ?>" name="email">
        <input type="hidden" value="<?php print($straat); ?>" name="streetname">
        <input type="hidden" value="<?php print($huisnummer); ?>" name="housenumber">
        <input type="hidden" value="<?php print($provincie); ?>" name="state">
        <input type="hidden" value="<?php print($woonplaats); ?>" name="city">
        <input type="hidden" value="<?php print($postcode); ?>" name="zip">
        <input type="hidden" name="betaal" value="ja">
        <br><button class="btn btn-lg btn-success" type="submit">Betalen</button>
    </form>
        </div>
</div>

<?php
include __DIR__ . "/footer.php";
?>