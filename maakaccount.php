<?php
include __DIR__ . "/header.php";

if(isset($_POST['']))
?>

<div class="container container-sm">
    <h1>Account Maken</h1>
    <form class="row g-3 needs-validation" novalidate>
        <div class="col-md-4">
            <label for="inputFirstname" class="form-label">Voornaam</label>
            <input type="text" class="form-control" id="inputFirstname" placeholder="Voornaam" required>
        </div>
        <div class="col-md-4">
            <label for="inputLastname" class="form-label">Achternaam</label>
            <input type="text" class="form-control" id="inputLastname" placeholder="Achternaam" required>
        </div>
        <div class="col-md-4">
            <label for="inputUsername" class="form-label">Gebruikersnaam</label>
            <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="text" class="form-control" id="inputUsername" aria-describedby="inputGroupPrepend" placeholder="Gebruikersnaam" required>
                <div class="invalid-feedback">
                    Kies een unieke gebruikersnaam.
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label for="inputEmail" class="form-label">Email-adres</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Email-adres" required>
        </div>
        <div class="col-md-8">
            <label for="inputPassword" class="form-label">Wachtwoord</label>
            <input type="password" class="form-control" id="inputPassword" placeholder="Wachtwoord" aria-describedby="helpPassword" required>
            <div id="helpPassword" class="form-text text-muted">Kies een wachtwoord tussen 6-100 tekens.</div>
        </div>
        <div class="col-md-6">
            <label for="inputStreet" class="form-label">Straat</label>
            <input type="text" class="form-control" id="inputStreet" placeholder="Straatnaam" required>
        </div>
        <div class="col-md-2">
            <label for="inputHousenumber" class="form-label">Huisnummer</label>
            <input type="text" class="form-control" id="inputHousenumber" required>
        </div>
        <div class="col-md-4">
            <label for="inputState" class="form-label">Provincie</label>
            <select class="form-select" id="inputState" required>
                <option selected disabled value="">Kies een provincie</option>
                <option>Noord-Holland</option>
                <option>Zuid-Holland</option>
                <option>Zeeland</option>
                <option>Utrecht</option>
                <option>Groningen</option>
                <option>Friesland</option>
                <option>Noord-Brabant</option>
                <option>Overijssel</option>
                <option>Gelderland</option>
                <option>Limburg</option>
                <option>Flevoland</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="inputCity" class="form-label">Woonplaats</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Email-adres" required>
        </div>
        <div class="col-md-4">
            <label for="inputEmail" class="form-label">Email-adres</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Email-adres" required>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                <label class="form-check-label" for="invalidCheck">
                    Agree to terms and conditions
                </label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
    </form>
</div>

</body>

</html>


<?php
include __DIR__ . "/footer.php";
?>