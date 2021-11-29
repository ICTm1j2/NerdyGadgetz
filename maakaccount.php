<?php
include __DIR__ . "/header.php";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>account maken</title>
</head>

<body>

<form>
    <div class="container">
        <h1> Account maken </h1> <br>
        <label>Voornaam : </label>
        <input type="text" placeholder="voornaam" name="voornaam" required>
        <label>Achternaam : </label>
        <input type="text" placeholder="achternaam" name="achternaam" required>
        <label>Gebruikersnaam : </label>
        <input type="text" placeholder="gebruikersnaam" name="username" required>
        <label>Wachtwoord : </label>
        <input type="password" placeholder="wachtwoord" name="password" required> <br><br>

        <h2> Addres gegevens</h2>
        <label>Provincie : </label>
        <input type="text" placeholder="provincie" name="provincie" required>
        <label>Woonplaats : </label>
        <input type="text" placeholder="woonplaats" name="woonplaats" required>
        <label>Postcode : </label>
        <input type="text" placeholder="postcode" name="postcode" required> <br><br>
        <label for="voorwaarde">Akkoord met de <a href="voorwaarde.php">voorwaarde</a></label>
        <input type="checkbox" id="voorwaarde" name="voorwaarde"> <br><br>
        <button type="submit">Aanmaken</button> <br>
        <a href="inloggen.php"> Terug naar inloggen </a> <br>
        <a href="index.php"> Terug naar de winkel </a>
    </div>
</form>

</body>

</html>


<?php
include __DIR__ . "/footer.php";
?>