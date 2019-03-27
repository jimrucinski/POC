<?php

$dsn="mysql:dbname=buyerssuppliers;host=localhost";
$username="root";
$password = "";
$db="buyerssuppliers";
try{
$conn = new PDO($dsn, $username, $password);
$sql = 'CAll getBuyersAndSuppliersList()';//this procedure calls two additional procedures generateBuerMatchPattern and generateSupplierMatchPattern
$stmt = $conn->query($sql);
$i = 0;

$rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
$buyers = $rowset;
$stmt->nextRowset();
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor(); //must close the cursor or you cannot execute any other commands agains MySql
$results= Array();


foreach($buyers as $buyer){
    $values = Array();    
    $arBuy = str_split($buyer["BuyerMatchPattern"]);
    $buyerTotal = array_sum($arBuy);

    foreach($suppliers as $supplier){
        $buyerMatches=0;
        $arSup = str_split($supplier["SupplierMatchPattern"]);
        for($i=0;$i<sizeOf($arBuy);$i++){
            if($arBuy[$i]!=0 && $arBuy[$i] === $arSup[$i]){
                ++$buyerMatches;
            }
        }
       $matchPercent = ($buyerMatches/$buyerTotal) * 100;
       $cat = '"' .  $buyer['companyName'] . '","' . $supplier['companyName'] . '",' . $matchPercent;
       array_push($results,$cat);
        }
    }


$fields = implode( $results);
$values = array();
$insertStringValues='';
foreach ($results as $rowValues) {
   $insertStringValues .='(' . $rowValues . '),';
}
$insertStringValues = rtrim($insertStringValues,',');
$sqlInsert = "INSERT INTO eventmatchpercentages (buyerCompanyName, supplierCompanyName, matchPercentage)
values " . $insertStringValues . ';';
}
catch(PDOException $e){
die('could not connect to the database<br/>' . $e->getMessage());
}
try{
$sql2 = 'CALL insertPercentageMatches(?)';
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(1,$insertStringValues, PDO::PARAM_LOB);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // without this no error is generate when the proc doesn't work
$stmt2->execute();
$stmt2->closeCursor();  //must close the cursor or you cannot execute any other commands agains MySql
}
catch(PDOException $e){
    die($e->getMessage());
}

$sql = 'SELECT * FROM buyerssuppliers.eventmatchpercentages order by buyerCompanyName asc, matchPercentage desc;';
$stmt = $conn->query($sql);
$i = 0;
$rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
$buyers = $rowset;


?>
<html>
<head>
</head>
<body>

<?php
$curCompany="";
foreach($buyers as $buyer){
    if($buyer['buyerCompanyName']!=$curCompany){
        echo '<h3>' . $buyer['buyerCompanyName'] . '</h3>';
    }
        echo'<div>' . $buyer['matchPercentage'] . ' - ' . $buyer['supplierCompanyName'] . '</div>';
    $curCompany = $buyer['buyerCompanyName'];
}

$conn = null; //closet the connection
?>
</body>
</html>