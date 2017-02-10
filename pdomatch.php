<?php
/*
$matches = array( array('companyName' => "ACME",
                        'percentMatch' => 22.222
                        ),
                    array('companyName' => "boo",
                            'percentMatch' => 55.555));
array_multisort($matches[1], SORT_ASC, SORT_STRING);
var_dump($matches);
//echo sizeof($matches);
die();
*/
$dsn="mysql:dbname=buyerssuppliers;host=localhost";
$username="root";
$password = "";
$db="buyerssuppliers";
try{
$conn = new PDO($dsn, $username, $password);
//$statement = $conn->query('select * from companies');
//$statement->setFetchMode(PDO::FETCH_OBJ);
$sql = 'CAll getBuyersAndSuppliersList()';
$stmt = $conn->query($sql);
$i = 0;
//do{
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
    //echo$buyer['companyName'] . '<br/>';
    foreach($suppliers as $supplier){
        $buyerMatches=0;
  //      echo '&nbsp;&nbsp;&nbsp;' . $supplier['companyName'] ;
        $arSup = str_split($supplier["SupplierMatchPattern"]);
        for($i=0;$i<sizeOf($arBuy);$i++){
            if($arBuy[$i]!=0 && $arBuy[$i] === $arSup[$i]){
                ++$buyerMatches;
            }
        }
        $matchPercent = ($buyerMatches/$buyerTotal) * 100;
       // array_push($values,$buyer['companyName']);
       // array_push($values,$supplier['companyName']);
       // array_push($values,$matchPercent);
       $cat = '"' .  $buyer['companyName'] . '","' . $supplier['companyName'] . '",' . $matchPercent;
       array_push($results,$cat);
//        echo ' - ' . ($buyerMatches/$buyerTotal) * 100  . '<br/>';
        }
        //array_push($results,$values);
    }
//echo sizeof($results) . '<br/>';
for($i=0;$i<count($results);$i++)
{
   
for($j=0;$j<count($results[$i]);$j++)
{
   // echo   $results[$i][$j] . ' | ';
}

}

$fields = implode( $results);
//echo $fields;
//echo $results[0];
$values = array();
//echo $fields;
$insertStringValues='';
foreach ($results as $rowValues) {
   $insertStringValues .='(' . $rowValues . '),';

   
    //foreach($rowValues as $value){
    //    echo '(' . $value .')<br/>';
   // }
    //foreach ($rowValues as $key => $rowValue) {
    //    $rowValues[$key] = $rowValues[$key];
          
   // }
//$values[] = "(" . implode(', ', $rowValues) . ")";
   
}
//echo strlen($insertStringValues);
//echo '<br/>' . $insertStringValues;

$insertStringValues = rtrim($insertStringValues,',');
//$insertStringValues = addslashes($insertStringValues);



$sqlInsert = "INSERT INTO eventmatchpercentages (buyerCompanyName, supplierCompanyName, matchPercentage)
values " . $insertStringValues . ';';
//echo $sqlInsert;
//die();
}
catch(PDOException $e){


die('could not connect to the database<br/>' . $e->getMessage());

}
try{
//echo $insertStringValues;
$sql2 = 'CALL insertPercentageMatches(?)';
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(1,$insertStringValues, PDO::PARAM_LOB);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // without this no error is generate when the proc doesn't work
$stmt2->execute();
$stmt2->closeCursor();  //must close the cursor or you cannot execute any other commands agains MySql


//$sql = 'call insertPercentageMatches("' . addslashes($insertStringValues) . ';")';
//echo $sql;

//$conn->query($sql);
}
catch(PDOException $e){
    die($e->getMessage());
}
//echo implode(', ', $values);

//$query = "INSERT INTO table_name ($fields) VALUES (" . implode (', ', $values) . ")";





$conn = null; //closet the connection
?>
<html>
<head>
	
</head>
<body>


</body>

</html>