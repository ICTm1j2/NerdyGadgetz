<?php
include __DIR__ . "/header.php";

//hier wordt de login sessie gestart
if(!isset($_SESSION['login'])){
    header("Location: inloggen.php");
    die("<div class='alert alert-danger'>Er gaat iets mis. (Niet ingelogd)</div>");
}

//
$page = "";
if(!isset($_GET['page'])){
    $page = "none";
}else{
    $page = $_GET['page'];
}

//hier kunnen de gegevens worden gewijzigd, bij succesvol of niet krijg je bijpassende melding en wordt het in de databse aangepast
if(isset($_POST['changedetails'])){
    if(changeDetails($databaseConnection, $_SESSION['login'], $_POST['email'], $_POST['name'], $_POST['phonenumber'], $_POST['address'], $_POST['zipcode'])){
        print("<div class='alert alert-success'>Je gegevens zijn gewijzigd.</div>");
    }else{
        print("<div class='alert alert-danger'>Er is iets mis gegaan tijdens het wijzigen van je gegevens.</div>");
    }
//hier kan het wachtwoord worden gewijzigd, bij succesvol of niet krijg je bijpassende melding en wordt het in de databse aangepast
}else if (isset($_POST['changepassword'])){
    if(changePassword($databaseConnection, $_SESSION['login'], sha1(trim($_POST['oldPassword']) . "NERDY"), sha1(trim($_POST['newPassword']) . "NERDY"))){
        print("<div class='alert alert-success'>Je wachtwoord is gewijzigd.</div>");
    }else{
        print("<div class='alert alert-danger'>Je huidige wachtwoord komt niet overeen met het huidige wachtwoord of er is een andere fout opgetreden.</div>");
    }
}

?>

    <div class="container container-sm">
        <div class="text-center">
            <br><br><h1>Mijn Account - <?php print(getFirstname($databaseConnection, $_SESSION['login'])); ?></h1>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ingelogd als: <?php print(getEmail($databaseConnection, $_SESSION['login'])); ?></h5>


                                <a href="account.php?page=accountdetails">Mijn gegevens</a><br>
                                <a href="account.php?page=changepassword">Wachtwoord Wijzigen</a><br>
                                <a href="account.php?page=orders">Mijn bestellingen</a>

                            <p id="text-test"></p>
                            <a href="inloggen.php?logout=true" class="btn btn-primary winkelmand-toevoegen-knop">Uitloggen</a>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <?php
                    //switch case om te kijken op welke pagina de gebruiker zit
                    switch ($page){
                        //in case order, worden alle order uit de database gehaald van het bijbehorden account
                        case "orders":
                            $orders = getOrdersFromAccount($databaseConnection, $_SESSION['login']);
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Mijn Orders</h5>
                                    <p class="card-text"><?php
                                        //mochten er nog geen orders zijn, wordt dat aangegeven, zowel wordt alles onder elkaar uitgeprint
                                        if($orders == null) {
                                            print("<div class='alert alert-danger'>Je hebt nog geen orders geplaatst.</div>");
                                        }else {
                                            while ($row = mysqli_fetch_array($orders)){

                                                $bezorgdag = new DateTime($row['OrderDate']);
                                                $bezorgdag->modify("+1 days");

                                                if($bezorgdag <= new DateTime(date("Y-m-d"))){
                                                    print("<h1>Bestelnummer: " . $row['OrderID'] . " <div class='badge small badge-success'>Bezorgd</div></h1>");
                                                }else{
                                                    print("<h1>Bestelnummer: " . $row['OrderID'] . " <div class='badge small badge-warning text-light'>Betaald</div></h1>");
                                                }
                                                print("<p>Bestel Datum: " . $row['OrderDate'] . " </p>");
                                                echo "<p>Bezorgdag: " . $bezorgdag->format("Y-m-d") . "</p>";
                                                print("<br>");
                                            }
                                        }

                                        ?></p>
                                </div>
                            </div>


                        <?php
                            break;
                        case "none":
                        //in de case accountdetails wil de gebruiker zijn/haar gegevens inzien, deze worden dan dus uitgeprint
                        case "accountdetails":
                            $personalDetails = getAccountDetails($databaseConnection, $_SESSION['login']);
                            if($personalDetails == null){
                                print("<div class='alert alert-danger'>Er gaat iets mis, neem contact op met support.</div>");
                                break;
                            }

                            ?>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Gegevens Wijzigen</h5>
                                <p class="card-text">Account Gemaakt: <?php print($personalDetails[4]); ?></p>
                                <form method="post">
                                    <input type="hidden" name="changedetails" value="true">
                                    <div class="mb-3">
                                        <label for="inputCustomerId" class="form-label">Klantnummer</label>
                                        <input type="text" class="form-control" id="inputCustomerId" value="<?php print($personalDetails[0]); ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputEmail1" class="form-label">E-mailadres</label>
                                        <input name="email" type="email" class="form-control" id="inputEmail1" placeholder="E-mailadres" value="<?php print($personalDetails[2]); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputName1" class="form-label">Volledige Naam</label>
                                        <input name="name" type="text" class="form-control" id="inputName1" placeholder="Volledige Naam" value="<?php print($personalDetails[1]); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputPhoneNumber1" class="form-label">Telefoonnummer</label>
                                        <input name="phonenumber" type="text" class="form-control" id="inputPhoneNumber1" placeholder="Telefoonnummer" value="<?php print($personalDetails[3]); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputAddress1" class="form-label">Adres</label>
                                        <input name="address" type="text" class="form-control" id="inputAddress1" placeholder="Adres" value="<?php print($personalDetails[5]); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputZipcode1" class="form-label">Postcode</label>
                                        <input name="zipcode" type="text" class="form-control" id="inputZipcode1" placeholder="Postcode" value="<?php print($personalDetails[6]); ?>">
                                    </div>
                                    <button type="submit" class="btn btn-success">Opslaan</button>
                                    <a role="button" class="btn btn-primary" href="account.php?page=changepassword">Wachtwoord Wijzigen</a>
                                </form>
                            </div>
                        </div>
                    <?php
                            break;
                        //mocht de gebruiker op verander wachtwoord klikken, wordt deze case geactivate
                        case "changepassword":
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Wachtwoord Wijzigen</h5>
                                    <form method="post">
                                        <input type="hidden" name="changepassword" value="true">
                                        <div class="mb-3">
                                            <label for="inputOldPassword1" class="form-label">Huidig Wachtwoord</label>
                                            <input name="oldPassword" type="password" class="form-control" id="inputOldPassword1" placeholder="Huidige wachtwoord">
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputNewPassword1" class="form-label">Nieuw Wachtwoord</label>
                                            <input name="newPassword" type="password" class="form-control" id="inputNewPassword1" placeholder="Nieuwe wachtwoord">
                                        </div>
                                        <button type="submit" class="btn btn-success">Opslaan</button>
                                    </form>
                                </div>
                            </div>

                        <?php
                            break;
                        default:
                            print("<div class='alert alert-danger'>Die pagina kan niet worden gevonden.</div>");
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

<?php
include __DIR__ . "/footer.php";

?>