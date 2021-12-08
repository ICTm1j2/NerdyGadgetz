<?php
include __DIR__ . "/header.php";

$voornaam = "";
$achternaam = "";
$email = "";
$straat = "";
$huisnummer = "";
$provincie = "";
$woonplaats = "";
$postcode = "";
if(isset($_SESSION['login'])){
    $gegevens = getGegevens($databaseConnection, $_SESSION['login']);
    $voornaam = $gegevens[0];
    $achternaam = $gegevens[1];
    $email = $gegevens[2];
    $straat = $gegevens[3];
    $huisnummer = $gegevens[4];
    $provincie = $gegevens[5];
    $woonplaats = $gegevens[6];
    $postcode = $gegevens[7];
}
?>

<div class="container container-sm">
    <?php if(isset($_SESSION['login'])){ ?>
    <h1>Gegevens Wijzigen</h1>
    <?php
    }else {
    ?>
    <br>
    <h1>Gegevens Invullen</h1>
    <?php } ?>
    <form class="row g-3" method="post" action="betalen.php" novalidate>
        <div class="col-md-4">
            <label for="inputFirstname" class="form-label">Voornaam</label>
            <input name="firstname" type="text" class="form-control" id="inputFirstname" placeholder="Voornaam" value="<?php print($voornaam); ?>" required>
        </div>
        <div class="col-md-4">
            <label for="inputLastname" class="form-label">Achternaam</label>
            <input name="lastname" type="text" class="form-control" id="inputLastname" placeholder="Achternaam" value="<?php print($achternaam); ?>" required>
        </div>
        <div class="col-md-4">
            <label for="inputEmail" class="form-label">E-mailadres</label>
            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="E-mailadres" value="<?php print($email); ?>" required>
            <br>
        </div>
        <div class="col-md-6">
            <label for="inputStreet" class="form-label">Straat</label>
            <input name="streetname" type="text" class="form-control" id="inputStreet" placeholder="Straatnaam" value="<?php print($straat); ?>" required>
        </div>
        <div class="col-md-2">
            <label for="inputHousenumber" class="form-label">Huisnummer</label>
            <input name="housenumber" type="text" class="form-control" id="inputHousenumber" placeholder="Huisnummer" value="<?php print($huisnummer); ?>" required>
        </div>
        <div class="col-md-4">
            <label for="inputState" class="form-label">Provincie</label>
            <select name="state" class="form-select" id="inputState" required>
                <option value="" disabled>Kies een provincie</option>
                <?php if(isset($_SESSION['login'])) print("<option value='$provincie' selected>$provincie</option>"); ?>
                <option value="Noord-Holland">Noord-Holland</option>
                <option value="Zuid-Holland">Zuid-Holland</option>
                <option value="Zeeland">Zeeland</option>
                <option value="Utrecht">Utrecht</option>
                <option value="Groningen">Groningen</option>
                <option value="Friesland">Friesland</option>
                <option value="Noord-Brabant">Noord-Brabant</option>
                <option value="Overijssel">Overijssel</option>
                <option value="Gelderland">Gelderland</option>
                <option value="Limburg">Limburg</option>
                <option value="Flevoland">Flevoland</option>
            </select>
        </div>
        <div class="col-md-4">
            <br>
            <label for="inputCity" class="form-label">Woonplaats</label>
            <input name="city" type="text" class="form-control" id="inputCity" placeholder="Woonplaats" value="<?php print($woonplaats); ?>" required>
        </div>
        <div class="col-md-4">
            <br>
            <label for="inputZip" class="form-label">Postcode</label>
            <input name="zip" type="text" class="form-control" id="inputZip" placeholder="1111AA" value="<?php print($postcode); ?>" required>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <label class="form-check-label" for="invalidCheck">
                    <br>
                    <br>Bij het aanmaken van een account ga je akkoord met onze <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Algemene Voorwaarden</a>
                </label>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <br><button class="btn btn-lg btn-success" type="submit">Naar betaalpagina gaan</button>
        </div>
    </form>
</div>

<?php
include __DIR__ . "/footer.php";
?>
