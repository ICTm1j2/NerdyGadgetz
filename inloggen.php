<?php
include __DIR__ . "/header.php";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>inlog pagina</title>
</head>

<body>

<form>
    <div class="container">
        <h1> inloggen </h1> <br>
        <label>Gebruikersnaam : </label>
        <input type="text" placeholder="Geef gebruikersnaam" name="username" required>
        <label>Wachtwoord : </label>
        <input type="password" placeholder="Geef wachtwoord" name="password" required>
        <button type="submit">inloggen</button> <br>
        <a href="maakaccount.php"> Account maken </a> <br>
        <a href="index.php"> Terug naar de winkel </a>
    </div>
</form>

</body>
</html>


<?php
include __DIR__ . "/footer.php";
?>