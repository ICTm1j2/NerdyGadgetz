<?php
include __DIR__ . "/header.php";

$melding = "";
$type = "";

if(isset($_GET['type'])){
    $type = $_GET['type'];
    if($type == "guest"){
        // ga door als gast met afrekenen
        // gegevens moeten nog worden ingevuld.
    } else if($type == "account" && isset($_SESSION['login'])){
        $CustomerID = getCustomerIdFromAccount($databaseConnection, $_SESSION['login']);
        if($CustomerID == 0){
            $melding = "<div class='alert alert-danger'>Er is iets fout gegaan met je account, neem contact op met support.</div>";
        }
    }else{
        $melding = "<div class='alert alert-danger'>Er is iets fout gegaan met het laden van deze pagina, probeer het later opnieuw.</div>";
    }
} else if (isset($_POST['type'])){
    $type = "checkdetails";
} else {
    $melding = "<div class='alert alert-danger'>Er is iets misgegaan, probeer het later opnieuw.</div>";
}
?>

<div class="container container-sm">
    <h1 class="text-center">Afrekenen</h1>
    <?php
    if($melding != ""){
        print($melding);
        die();
    }
    if($type == "guest"){ ?>
        <form class="row g-3" method="post" action="afrekenen.php" novalidate>
            <div class="col-md-6">
                <label for="inputName" class="form-label">Volledige Naam</label>
                <input name="name" type="text" class="form-control" id="inputName" placeholder="Volledige Naam" required>
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
            <input name="type" type="hidden" value="checkdetails">
            <div class="col-md-6">
                <div class="form-check">
                    <label class="form-check-label" for="invalidCheck">
                        <br>Bij het plaatsen van een bestelling ga je akkoord met onze <a href="<?php print($termsOfService); ?>" target="_blank">Algemene Voorwaarden</a>
                    </label>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <br><button class="btn btn-lg btn-success" type="submit">Gegevens Controleren</button>
            </div>
        </form>
    <?php
    }else if ($type == "account"){
        $details = getCustomerDetailsFromPerson($databaseConnection, $_SESSION['login']);
        if($details == null){
            die("Dit gaat niet goed.");
        }?>
            <div>
    <h4>Kloppen deze gegevens <?php print(getFirstname($databaseConnection, $_SESSION['login'])) ?>?</h4>
                <p><strong>Volledige Naam:</strong> <?php print($details[0]); ?></p>
                <p><strong>Telefoonnummer:</strong> <?php print($details[1]); ?></p>
                <p><strong>Adres:</strong> <?php print($details[2]); ?></p>
                <p><strong>Postcode:</strong> <?php print($details[3]); ?></p>

        <a role="button" class="btn btn-success text-light" href="betalen.php?customer=<?php print(getCustomerIdFromAccount($databaseConnection, $_SESSION['login'])) ?>">Ga Door Naar Betalen</a>
        <a role="button" class="btn btn-primary text-light" href="index.php">Gegevens Wijzigen</a></div>
    <?php
    }else if ($type == "checkdetails"){
        $customer = createCustomerGetId($databaseConnection, 0, $_POST['name'], $date = date("Y-m-d"), $_POST['phonenumber'], $_POST['streetname'] . " " . $_POST['housenumber'], $_POST['zip'], "9999-12-31 23:59:59");
        if($customer == null){
            die("Er gaat iets mis.");
        }else if ($customer > 0){
            header("Location: betalen.php?customer=" . $customer);
            exit();
        }
        ?>
    <?php
    }
    ?>

</div>

<?php
include __DIR__ . "/footer.php";
?>
