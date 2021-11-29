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
        <label>E-mail : </label>
        <input type="email" placeholder="E-mail" name="email" required>
        <label>Gebruikersnaam : </label>
        <input type="text" placeholder="gebruikersnaam" name="username" required>
        <label>Wachtwoord : </label>
        <input type="password" placeholder="wachtwoord" name="password" required> <br><br>

        <h2> Addres gegevens</h2>
        <label>Provincie : </label>
        <input type="text" placeholder="provincie" name="provincie" required>
        <label>Woonplaats : </label>
        <input type="text" placeholder="woonplaats" name="woonplaats" required>
        <label>Straatnaam : </label>
        <input type="text" placeholder="straatnaam" name="straatnaam" required>
        <label>Huisnummer : </label>
        <input type="number" placeholder="huisnummer" name="huisnummer" required>
        <label>Postcode : </label>
        <input type="text" placeholder="postcode" name="postcode" required> <br><br>
        <label for="voorwaarde">Akkoord met <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">voorwaarden</a></label>
        <input type="checkbox" id="voorwaarde" name="voorwaarde" required> <br><br>
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