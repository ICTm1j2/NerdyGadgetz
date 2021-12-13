<?php
include __DIR__ . "/header.php";

$melding = 0;

if(isset($_POST['firstname'] )){
    $firstName = trim($_POST['firstname']);
    $lastName = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = sha1(trim($_POST['password']) . "NERDY");
    $streetName = trim($_POST['streetname']);
    $houseNumber = trim($_POST['housenumber']);
    $phoneNumber = trim($_POST['phonenumber']);
    $city = trim($_POST['city']);
    $zipCode = trim($_POST['zip']);
    if(createAccount($databaseConnection, $firstName, $lastName, $email, $password, $streetName, $houseNumber, $phoneNumber, $city, $zipCode)){
        $melding = 1;
    }else $melding = 2;
}
?>

<div class="container container-sm">
    <br>
    <h1>Aanmaken Account</h1>
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
            <label for="inputEmail" class="form-label">E-mailadres</label>
            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="E-mailadres" required>
        </div>
        <div class="col-md-8">
            <label for="inputPassword" class="form-label">Wachtwoord</label>
            <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Kies een wachtwoord tussen 6-100 tekens" required>
        </div>
        <div class="col-md-4">
            <label for="inputPhonenumber" class="form-label">Telefoonnummer</label>
            <input name="phonenumber" type="text" class="form-control" id="inputPhonenumber" placeholder="Telefoonnummer" required>
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
            <label for="inputZip" class="form-label">Postcode</label>
            <input name="zip" type="text" class="form-control" id="inputZip" placeholder="1111AA" required>
        </div>
        <div class="col-md-6">
            <label for="inputCity" class="form-label">Woonplaats</label>
            <input name="city" type="text" class="form-control" id="inputCity" placeholder="Woonplaats" required>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <label class="form-check-label" for="invalidCheck">
                    <br>Bij het aanmaken van een account ga je akkoord met onze <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Algemene Voorwaarden</a>
                </label>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <br><button class="btn btn-lg btn-success" type="submit">Account Maken</button>
        </div>
    </form>
</div>

<?php
include __DIR__ . "/footer.php";
?>