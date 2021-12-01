<?php
include __DIR__ . "/header.php";

$melding = 0;

if(isset($_POST['firstname']) && isset($_POST['tos-agree'])){
    $firstName = trim($_POST['firstname']);
    $lastName = trim($_POST['lastname']);
    $userName = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = sha1(trim($_POST['password']) . "NERDY");
    $streetName = trim($_POST['streetname']);
    $houseNumber = trim($_POST['housenumber']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $zipCode = trim($_POST['zip']);
    $tosAgree = trim($_POST['tos-agree']);
    if(createAccount($databaseConnection, $firstName, $lastName, $userName, $email, $password, $streetName, $houseNumber, $state, $city, $zipCode)){
        $melding = 1;
    }else $melding = 2;
}
?>

<div class="container container-sm">
    <h1>Account Maken</h1>
    <?php
    if($melding == 2){
        print("<div class='alert alert-danger'>Er gaat iets mis!</div>");
    }else if ($melding == 1){
        print("<div class='alert alert-success'>Je account is gemaakt, je kunt nu <a href='inloggen.php'>inloggen</a>.</div>");
    }
    ?>
    <form class="row g-3" method="post" novalidate>
        <div class="col-md-4">
            <label for="inputFirstname" class="form-label">Voornaam</label>
            <input name="firstname" type="text" class="form-control" id="inputFirstname" placeholder="Voornaam" required>
        </div>
        <div class="col-md-4">
            <label for="inputLastname" class="form-label">Achternaam</label>
            <input name="lastname" type="text" class="form-control" id="inputLastname" placeholder="Achternaam" required>
        </div>
        <div class="col-md-4">
            <label for="inputUsername" class="form-label">Gebruikersnaam</label>
            <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input name="username" type="text" class="form-control" id="inputUsername" aria-describedby="inputGroupPrepend" placeholder="Gebruikersnaam" required>
            </div>
        </div>
        <div class="col-md-4">
            <label for="inputEmail" class="form-label">Email-adres</label>
            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email-adres" required>
        </div>
        <div class="col-md-8">
            <label for="inputPassword" class="form-label">Wachtwoord</label>
            <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Kies een wachtwoord tussen 6-100 tekens" required>
        </div>
        <div class="col-md-6">
            <label for="inputStreet" class="form-label">Straat</label>
            <input name="streetname" type="text" class="form-control" id="inputStreet" placeholder="Straatnaam" required>
        </div>
        <div class="col-md-2">
            <label for="inputHousenumber" class="form-label">Huisnummer</label>
            <input name="housenumber" type="text" class="form-control" id="inputHousenumber" placeholder="Huisnummer" required>
        </div>
        <div class="col-md-4">
            <label for="inputState" class="form-label">Provincie</label>
            <select name="state" class="form-select" id="inputState" required>
                <option value="" selected disabled>Kies een provincie</option>
                <option value="NOORD_HOLLAND">Noord-Holland</option>
                <option value="ZUID_HOLLAND">Zuid-Holland</option>
                <option value="ZEELAND">Zeeland</option>
                <option value="UTRECHT">Utrecht</option>
                <option value="GRONINGEN">Groningen</option>
                <option value="FRIESLAND">Friesland</option>
                <option value="NOORD_BRABANT">Noord-Brabant</option>
                <option value="OVERIJSSEL">Overijssel</option>
                <option value="GELDERLAND">Gelderland</option>
                <option value="LIMBURG">Limburg</option>
                <option value="FLEVOLAND">Flevoland</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="inputCity" class="form-label">Woonplaats</label>
            <input name="city" type="text" class="form-control" id="inputCity" placeholder="Woonplaats" required>
        </div>
        <div class="col-md-4">
            <label for="inputZip" class="form-label">Postcode</label>
            <input name="zip" type="text" class="form-control" id="inputZip" placeholder="1111AA" required>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input name="tos-agree" class="form-check-input" type="checkbox" value="true" id="invalidCheck" required>
                <label class="form-check-label" for="invalidCheck">
                    Je moet akkoord gaan met onze <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Terms of Service</a>
                </label>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <br><button class="btn btn-lg btn-success" type="submit">Account Maken</button>
        </div>
    </form>
</div>

</body>

</html>


<?php
include __DIR__ . "/footer.php";
?>