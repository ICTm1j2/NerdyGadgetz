<?php
include __DIR__ . "/header.php";

if(!isset($_POST['voornaam'])){
    die("<div class='alert alert-danger'>Er gaat iets mis...</div>");
}

$cart = $_SESSION['cart'];
$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$straat = $_POST['straat'];
$huisnummer = $_POST['huisnummer'];
$provincie = $_POST['provincie'];
$woonplaats = $_POST['woonplaats'];
$postcode = $_POST['postcode'];

if(isset($_POST['betaal'])){
    // betaald
}


?>

    <div class="container container-sm">
        <div class="text-center">
    <img width="750" src="Public\Img\ideal.png">
    <form>
        <input type="hidden" value="<?php print($voornaam); ?>" name="voornaam">
        <input type="hidden" value="<?php print($achternaam); ?>" name="achternaam">
        <input type="hidden" value="<?php print($email); ?>" name="email">
        <input type="hidden" value="<?php print($straat); ?>" name="straat">
        <input type="hidden" value="<?php print($huisnummer); ?>" name="huisnummer">
        <input type="hidden" value="<?php print($provincie); ?>" name="provincie">
        <input type="hidden" value="<?php print($woonplaats); ?>" name="woonplaats">
        <input type="hidden" value="<?php print($postcode); ?>" name="postcode">
        <input type="hidden" name="betaal" value="ja">
        <br><button class="btn btn-lg btn-success" type="submit">Betalen</button>
    </form>
        </div>
</div>

<?php
include __DIR__ . "/footer.php";
?>