<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
include "database.php";
include "accountfuncties.php";
include "orderfuncties.php";
include "reviewfuncties.php";
$databaseConnection = connectToDatabase();
$databaseConnection_admin = connectToDatabase_admin();

$termsOfService = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
    <style>
        .wrapContainer p {
            margin-bottom: 0!important;
            color: white;
        }
    </style>
</head>
<body>
<div class="Background">
    <div class="wrapContainer" style="background-color: #5e00ff; position: fixed; width: 100%; top:0; z-index: 999;">
    <div class="container">
        <div class="row py-1 justify-content-between">
                <p><b>Gratis</b> verzending! </p>
                <p>Bezorging dezelfde dag, 's avonds óf in het weekend!</p>
                <p><b>Gratis</b> retourneren!</p>
        </div>
</div>
</div>
    <div class="row" id="Header">ß
        <div class="col-2"><a href="./" id="LogoA">
                <div id="LogoImage"></div>
            </a></div>
        <div class="col-8" id="CategoriesBar">
            <ul id="ul-class">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);
                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <li>
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </li>
            </ul>
        </div>
<!-- code voor US3: zoeken -->

        <ul id="ul-class-navigation">
            <li>
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken</a>
            </li>
            <li>
                <a href="cart.php" class="HrefDecoration"><i class="fas fa-shopping-cart search"></i> Winkelmand
                    <?php
                    if(isset($_SESSION['cart'])){
                        print(getAantalInWinkelmand($_SESSION['cart']));
                    }
                    ?>
                </a>
            </li>
            <?php
            if(isset($_SESSION['login'])){
                $gebruikersnaam = getFirstname($databaseConnection, $_SESSION['login']);
                ?>
                <li>
                    <a href="account.php" class="HrefDecoration"><i class="fas fa-user search"></i> <?php print($gebruikersnaam); ?></a>
                </li>
            <?php
            }else{
            ?>
            <li>
                <a href="account.php" class="HrefDecoration"><i class="fas fa-user search"></i> Inloggen</a>
            </li>
        <?php } ?>
        </ul>

<!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


