<?php
include __DIR__ . "/header.php";

$melding = 0;

if(!isset($_SESSION['login'])){
    header("Location: inloggen.php");
    die("<div class='alert alert-danger'>Je moet eerst inloggen om dit te kunnen doen.</div>");
}

if(!isset($_GET['item'])){
    header("Location: browse.php");
    die("<div class='alert alert-danger'>Er is iets misgegaan. (Geen product)</div>");
}
$product = getProductName($databaseConnection, $_GET['item']);
if($product == 0){
    die("<div class='alert alert-danger'>Er is iets misgegaan. (Product bestaat niet)</div>");
}

if(isset($_POST['reviewPosted'])){
    $rate = 1;
    $rateText = "REVIEW_EMPTY";

    if(isset($_POST['rate'])){
        $rate = $_POST['rate'];
    }

    if(isset($_POST['rateText'])){
        $rateText = $_POST['rateText'];
    }

    if(createReview($databaseConnection, $_GET['item'], $_SESSION['login'], $rateText, $rate)){
        $melding = 1;
    }else $melding = 2;
}

?>

    <div class="container container-sm">
        <div class="text-center">

            <?php
            if($melding == 1){
                die("<div style='padding-top: 4em;'><div class='alert alert-success'>Bedankt voor je review! Klik <a href='view.php?id=" . $_GET['item'] . "'>hier</a> om terug te gaan.</div></div>");
            }else if ($melding == 2){
                die("<div class='alert alert-danger'>Er is iets misgegaan tijdens het plaatsen van je review.</div>");
            }
            ?>
            <h1 style="padding-top: 2em;">Plaats een review</h1>
            <h3><?php print(getProductName($databaseConnection, $_GET['item'])); ?></h3>

            <form method="post">
                <input type="hidden" name="reviewPosted" value="true">
                <div class="mb-3">
                    <label for="reviewText1" class="form-label">Schrijf hier je review</label>
                    <textarea class="form-control" id="reviewText1" rows="3" name="rateText"></textarea>
                </div>
                <label class="form-label" for="star1">Kies het aantal sterren</label><br>
                <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5">
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4">
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3">
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2">
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1">
                    <label for="star1" title="text">1 star</label>
                </div>
                <input type="submit" class="btn btn-success" value="Plaats Review">
            </form>
        </div>
    </div>

<?php
include __DIR__ . "/footer.php";

?>