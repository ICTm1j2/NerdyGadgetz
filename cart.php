<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

$cart = getCart();
$items = array();
$amounts = array();

foreach($cart as $id=>$amount){
    $StockItem = getStockItem($id, $databaseConnection);
    $StockItemImage = getStockItemImage($id, $databaseConnection);
    array_push($items, $StockItem);
//    array_push($amounts, $id[$amount]);
    $amounts[$id] = $amount;
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
</head>
<body>
<h1>Inhoud Winkelwagen</h1>
<div>
<?php
    if(count($items) < 1){
        print("Je hebt nog niks in je winkelmandje.");
    }else{
        print("<table>
        <tr>
            <th>Product ID</th>
            <th>Product Naam</th>
            <th>Prijs per stuk</th>
            <th>Hoeveelheid</th>
            <th>Totaal prijs</th>
        </tr>");
    }
?>

<?php
$total = 0;
foreach($items as $item){
    print("<tr>");
    print("<td>" . $item['StockItemID'] . "</td>");
    print("<td><a href='view.php?id=" . $item['StockItemID'] . "'>" . $item['StockItemName'] . "</a></td>");
    print("<td>" . sprintf("€ %.2f", $item['SellPrice']). "</td>");
    print("<td>" . $amounts[$item['StockItemID']] . "</td>");
    print("<td>" . sprintf("€ %.2f",$item['SellPrice'] * $amounts[$item['StockItemID']]) . "</td>");
    print("</tr>");

    $total = $total + $item['SellPrice'] * $amounts[$item['StockItemID']];
}

?>
<tr>
    <td></td><td></td><td></td><td></td>
    <td><?php
        if(!(count($items) < 1)){
            print(sprintf("€ %.2f", $total));
        }
        ?></td>

</tr>
    <?php
    if(!(count($items) < 1)){
        print("</table>");
    }
    ?>

</div>
<hr>
<center><p><a href='index.php'>Terug naar start</a></p></center>
</body>
</html>