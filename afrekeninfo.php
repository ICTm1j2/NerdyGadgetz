<?php
include __DIR__ . "/header.php";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Afrekenen informatie</title>
</head>

<body>

<form>
    <div class="container"><br>
        <h1> Afrekenen </h1>
        <h2>Verzendgegevens</h2>
        <label>Voornaam: </label>
        <input type="text" placeholder="Voornaam" name="voornaam" required>
        <label></br>Achternaam: </label><br>
        <input type="text" placeholder="Achternaam" name="achternaam" required>
        <br><label></br>E-mailadres: </label>
        <input type="email" placeholder="E-mailadres" name="email" required>
        <label></br>Provincie: </label>
        <input type="text" placeholder="Provincie" name="provincie" required>
        <label></br>Woonplaats: </label>
        <input type="text" placeholder="Woonplaats" name="woonplaats" required>
        <label></br>Straatnaam: </label>
        <input type="text" placeholder="Straatnaam" name="straatnaam" required>
        <label></br>Huisnummer: </label>
        <input type="number" placeholder="Huisnummer" name="huisnummer" required>
        <label></bR>Postcode: </label>
        <input type="text" placeholder="Postcode" name="postcode" required> <br><br>
        <label for="voorwaarde">Bij het bestellen ga je akkoord met onze <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Algemene Voorwaarden</a>.</label><br>
<!--        <input type="checkbox" id="voorwaarde" name="voorwaarde" required> <br><br>-->
        <button type="submit">Betalen</button> <br><br>
        <a href="cart.php"> Terug naar winkelwagen </a> <br>
        <a href="index.php"> Verder winkelen <br><br><br></a>

</body>

</html>


<?php
include __DIR__ . "/footer.php";
?>
