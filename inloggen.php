<?php
include __DIR__ . "/header.php";
$success = 0;
$melding = 0;

if(isset($_GET['logout'])){
    session_destroy();
    die("<div class='alert alert-info'>Je bent nu uitgelogd. Klik <a href='index.php'>hier</a> om terug te gaan.</div>");
}

if(isset($_SESSION['login'])){
    $melding = 4;
}

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = trim($_POST['username']);
    $password = sha1(trim($_POST['password']) . "NERDY");

    $result = checkDetails($databaseConnection, $username, $password);
    if(!$result){
        $melding = 1;
    }else if ($result->num_rows == 1){
        $melding = 2;
        $success = 1;
        $_SESSION['login'] = $result->fetch_row()[0];
    }else {
        $melding = 3;
    }
}
?>
<div class="container container-sm">
    <br><h1>Inloggen</h1>
    <?php
    switch($melding){
        case 1:
            print("<div class='alert alert-danger'>Er is een fout opgetreden, je kunt niet worden ingelogd.</div>");
            break;
        case 2:
            print("<div class='alert alert-success'>Je bent nu ingelogd.</div>");
            die();
        case 3:
            print("<div class='alert alert-danger'>Je gebruikersnaam of wachtwoord is onjuist.</div>");
            break;
        case 4:
            print("<div class='alert alert-warning'>Je bent al ingelogd. Klik <a href='inloggen.php?logout=true'>hier</a> om uit te loggen.</div>");
            die();
    }

    ?>
    <form method="post">
        <div class="mb-3">
            <label for="inputUsername1" class="form-label">Gebruikersnaam</label>
            <input name="username" type="text" class="form-control" id="inputUsername1" placeholder="Gebruikersnaam" value="<?php print(printUsername()); ?>">
        </div>
        <div class="mb-3">
            <label for="inputPassword1" class="form-label">Wachtwoord</label>
            <input name="password" type="password" class="form-control" id="inputPassword1" placeholder="Wachtwoord" value="<?php print(printPassword()); ?>">
        </div>
        <!--<div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>-->
        <button type="submit" class="btn btn-success">Inloggen</button>
        <a href="maakaccount.php">Nog geen account? Maak er een!</a><br>
        <a href="index.php">Terug naar de winkel</a>
    </form>
</div>

</body>
</html>


<?php
include __DIR__ . "/footer.php";

function printUsername(){
    if(isset($_POST['username'])){
        return trim($_POST['username']);
    }else return null;
}

function printPassword(){
    if(isset($_POST['password'])){
        return trim($_POST['password']);
    }else return null;
}
?>