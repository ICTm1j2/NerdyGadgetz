<?php
include __DIR__ . "/header.php";

if(!isset($_SESSION['login'])){
    header("Location: inloggen.php");
    die("<div class='alert alert-danger'>Er gaat iets mis. (Niet ingelogd)</div>");
}
$page = "";
if(!isset($_GET['page'])){
    $page = "none";
}else{
    $page = $_GET['page'];
}

?>

    <div class="container container-sm">
        <div class="text-center">
            <br><br><h1>Mijn Account - <?php print(getFirstname($databaseConnection, $_SESSION['login'])); ?></h1>
            <div class="row">
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Ingelogd als: <?php print(getEmail($databaseConnection, $_SESSION['login'])); ?></h5>


                                <a href="account.php?page=accountdetails">Mijn gegevens</a><br>
                                <a href="account.php?page=orders">Mijn bestellingen</a>

                            <p id="text-test"></p>
                            <a href="inloggen.php?logout=true" class="btn btn-primary winkelmand-toevoegen-knop">Uitloggen</a>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <?php
                    switch ($page){
                        case "orders":
                            ?>
                        <p>Hier komen je orders te staan!</p>


                        <?php
                            break;
                        case "none":
                        case "accountdetails":
                            ?>
                    <p>Hier komen je account details te staan.</p>

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