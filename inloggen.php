<?php
include __DIR__ . "/header.php";
?>
<div class="container container-sm">
    <br><h1>Inloggen</h1>
    <form method="post">
        <div class="mb-3">
            <label for="inputUsername1" class="form-label">Gebruikersnaam</label>
            <input type="text" class="form-control" id="inputUsername1">
        </div>
        <div class="mb-3">
            <label for="inputPassword1" class="form-label">Wachtwoord</label>
            <input type="password" class="form-control" id="inputPassword1">
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
?>