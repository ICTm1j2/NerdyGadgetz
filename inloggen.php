<?php
include __DIR__ . "/header.php";
$success = 0;
$melding = 0;

if(isset($_GET['logout'])){
    unset($_SESSION['login']);
    print("<div class='alert alert-info'>Je bent nu uitgelogd.</div>");
}
// Hier wordt er gekeken of er uitgelogd wordt, als dit het geval is wordt de sessie login ge unset en krijg je een melding die zegt dat je bent uigelogd

if(isset($_SESSION['login'])){
    $melding = 4;
}
// Als je bent ingelogd krijg je case 4 line: 46 te zien

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = trim($_POST['email']);
    $password = sha1(trim($_POST['password']) . "NERDY");
// Hier wordt het ingevulde wachtwoord en email getrimt en gehashed

    $result = checkDetails($databaseConnection, $email, $password);
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
// Het wachtwoord en email worden hier naar de database verzonden en geccontroleerd vervolgens wordt het resultaat terug gestuurt

?>
<div class="container container-sm">
    <br><h1>Inloggen</h1>
    <?php
    switch($melding){
        case 1:
            print("<div class='alert alert-danger'>Er is een fout opgetreden, je kunt niet worden ingelogd.</div>");
            break;
        case 2:
            header("Location: account.php");
            die("<div class='alert alert-success'>Je bent nu ingelogd.</div>");
        case 3:
            print("<div class='alert alert-danger'>Je email of wachtwoord is onjuist.</div>");
            break;
        case 4:
            header("Location: account.php");
            die("<div class='alert alert-warning'>Je bent al ingelogd. Klik <a href='inloggen.php?logout=true'>hier</a> om uit te loggen.</div>");
    }
// Het teruggestuurde resultaat wordt hier gelinkt aan verschillende cases

    ?>
    <form method="post">
        <div class="mb-3">
            <label for="inputEmail1" class="form-label">E-mailadres</label>
            <input name="email" type="email" class="form-control" id="inputEmail1" placeholder="E-mailadres" value="<?php print(printEmail()); ?>">
        </div>
        <div class="mb-3">
            <label for="inputPassword1" class="form-label">Wachtwoord</label>
            <input name="password" type="password" class="form-control" id="inputPassword1" placeholder="Wachtwoord" value="<?php print(printPassword()); ?>">
        </div>
        <button type="submit" class="btn btn-success">Inloggen</button>
        <a href="maakaccount.php"><br><br>Nog geen account? Maak er een aan!</a><br>
        <a href="index.php">Terug naar de winkel</a>
    </form>
</div>

</body>
</html>


<?php
include __DIR__ . "/footer.php";

function printEmail(){
    if(isset($_POST['email'])){
        return trim($_POST['email']);
    }else return null;
}
// Door deze functie blijft het email staan na een foute inlog poging

function printPassword(){
    if(isset($_POST['password'])){
        return trim($_POST['password']);
    }else return null;
}
// Door deze functie blijft het email staan na een foute inlog poging

?>