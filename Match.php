<?php

$servername="localhost";
$username="root";
$password = "";
$db="buyerssuppliers";

$mysqli = new mysqli($servername, $username, $password, $db);


if($mysqli->connect_errno){
    echo("connection failerd: " . $mysqli->connect_error);
    exit();
}

//$buyerQuery = "select id as buyerId,buyerName, Concat(ifnull(first,0),ifnull(second,0), ifnull(third,0),
//ifnull(fourth,0), ifnull(fifth,0), ifnull(sixth,0), ifnull(seventh,0), ifnull(eighth,0), ifnull(nineth,0), ifnull(tenth,0)) as BuyerMatchPattern from buyers";
//$supplierQuery="select id as supplierId, supplierName, Concat(ifnull(first,0),ifnull(second,0), ifnull(third,0),
//ifnull(fourth,0), ifnull(fifth,0), ifnull(sixth,0), ifnull(seventh,0), ifnull(eighth,0), ifnull(nineth,0), ifnull(tenth,0)) as SupplierMatchPattern from suppliers";
$buyerQuery="select companyProducts.companyName,companies.participationType, Concat(prod1, prod2,prod3, prod4, prod5, prod6, prod7, prod8, prod9, prod10, prod11,prod12, 
prod13,prod14,prod15,prod16,prod17, prod18,prod19, prod20, prod21,prod22,prod23,prod24,prod25,prod26,prod27,prod28) as BuyerMatchPattern
FROM buyerssuppliers.companyproducts
join buyerssuppliers.companies on companyproducts.companyName = companies.companyName
where companies.participationType=1
order by companyproducts.companyName asc";
$supplierQuery="select companyProducts.companyName, companies.participationType, Concat(prod1, prod2,prod3, prod4, prod5, prod6, prod7, prod8, prod9, prod10, prod11,
prod12, prod13,prod14,prod15,prod16,prod17, prod18,prod19, prod20, prod21,prod22,prod23,prod24,prod25,prod26,prod27,prod28) as SupplierMatchPattern
FROM buyerssuppliers.companyproducts
join buyerssuppliers.companies on companyproducts.companyName = companies.companyName
where companies.participationType=2
order by companyproducts.companyName asc";

if($buyerResult=$mysqli->query($buyerQuery))
{
    //if($supplierResult=$mysqli->query($supplierQuery)){
    
    
    
    while ($buyerRow = $buyerResult->fetch_assoc()){
        $strTable = "<table style='width:100%;border:solid #000000 1px;border-collapse:collapse'>";
        $arBuy = str_split($buyerRow["BuyerMatchPattern"]);
        
        $buyerTotal = array_sum($arBuy);
        $strTable .= "<tr style='background-color:#000000;color:#ffffff;'><th style='text-align:left;border:solid #000000 1px;'>" . $buyerRow["companyName"] . "</th><th style='text-align:left;' colspan='2'>" . $buyerRow["BuyerMatchPattern"] . "</th></tr>";
        //echo "<h3 style='color:blue;margin-bottom:0;'>" . $buyerRow["buyerName"] ." " . $buyerRow["BuyerMatchPattern"] . "</h3>";
        //echo($buyerRow["buyerName"] . ": " . $buyerRow["BuyerMatchPattern"] . "<br/>");
        if($supplierResult=$mysqli->query($supplierQuery)){
        while($supplierRow = $supplierResult->fetch_assoc()){
            $buyerMatches=0;
            $strTable .= "<tr><td style='border:solid #000000 1px;'>" . $supplierRow["companyName"] . "</td><td style='border:solid #000000 1px;'>" . $supplierRow["SupplierMatchPattern"] . "</td>";
          //  echo("<strong><font>" . $supplierRow["supplierName"] . ": " . $supplierRow["SupplierMatchPattern"] . "</font></strong><br/>");
            $arSup = str_split($supplierRow["SupplierMatchPattern"]);

            for($i=0;$i<sizeOf($arBuy);$i++){
               if($arBuy[$i]!=0 && $arBuy[$i] === $arSup[$i]){
                    ++$buyerMatches;
                }
                }
             $strTable .="<td style='border:solid #000000 1px;'>" . ($buyerMatches/$buyerTotal) * 100 . '%</td></tr>';
        }
        $strTable .="</table>";
        echo $strTable . "<br/>";
    }
    }
}
else{echo 'no';}

if(!empty($_POST)){

$buyer= $_POST["buyer"];
$supplier = $_POST["supplier"];
//$percent = null;
//$return  = similar_text($buyer,$supplier,$percent);

//$charMatch = similar_text($buyer, $supplier);
//$percentMatch = similar_text($buyer, $supplier,$percent);
//$percent = round($percent,2);

echo '<table style="font-size:larger;"><tr><td>BUYER</td><td style="letter-spacing:1em;">' . $buyer . '</td></tr><tr><td>SUPPLIER</td><td style="letter-spacing:1em;">' . $supplier . '</td></tr></table>';
//echo '# of matching charecters = ' . $charMatch . '<br/>percentage match = '. $percent;

$arBuy = str_split($buyer);
$arSup = str_split($supplier);
$result = array_diff($arBuy, $arSup);
//echo '<br/> size of array = ' .  sizeOf($result) . '<br/>';

//for($i=0;$i<sizeOf($arBuy); $i++){
//    echo $i . ' = ' . $result[$i] . '<br/>';
//}


//$xor1 = gmp_init($supplier, 2);
//$xor2 = gmp_init($buyer, 2);
//$xor3 = gmp_xor($xor1, $xor2);
//$sum =  gmp_add($xor1, $xor2) ;
//echo '<br/> the sum = ' . gmp_strval($sum);
//echo '<br/> type = ' . gettype($xor3) . '<br/>';
//$ar = str_split((string)gmp_strval($xor3, 2));
//$arSup = str_split((string)gmp_strval($xor1,2));
//$arBuy = str_split((string)gmp_strval($xor2,2));

//echo 'sup = ' . sizeof($arSup) . '<br/>';
//echo 'buy = ' . sizeof($arBuy) . '<br/>';
//die();

$buyerMatches=0;
$buyerTotal = array_sum($arBuy);

//if($xor1 > 0){
//$arSupLen = sizeof($arSup);

for($i=0;$i<sizeOf($arBuy);$i++){
    //echo $arBuy[$i] . ' = ' . $arSup[$i] . '<br/>';
    if($arBuy[$i]!=0 && $arBuy[$i] === $arSup[$i]){
        ++$buyerMatches;
    }
    }

echo '<br/> buyer total cares = ' . $buyerTotal;
echo '<br/>buyer matches = ' . $buyerMatches;
echo '<br/>buyer match % = ' . ($buyerMatches/$buyerTotal) * 100;

//echo '<br/> matchcalc = ' . $matchcalc . '<br/>';
//echo 'the string = ' . (string)gmp_strval($xor3, 2) . '<br/>';
//echo '<br/>the array sum = '. array_sum($ar);
//$matchcalc = array_sum($ar);
//echo '<br/>' . $matchcalc . '<br/>';
//echo '<br/> XOR = ' . gmp_strval($xor3, 2) . "\n";

//$numQuestions = 6;
//if($matchcalc==0){
//    $matching = '100';}
//else{
//    if($matchcalc == $numQuestions){
//    $matching='0';
//}
//else{
//$matching = ($matchcalc/$numQuestions)*100;
//}}
//echo '<br/>Matching percentage = ' . $matching . '%';


}
?>
<html>
<head>
	
</head>
<body>


<form method="post">
<fieldset>
<legend>Enter a string of six digits using only one and zero</legend>
<ul>
<li>
<label>buyer string: </label><input type="text" name="buyer" id="buyer"/>
</li>
<li>
<label>supplier string: </label> <input type"text" name="supplier" id="supplier"/>
</li>
</ul>
<input type="submit"/>
</form>

<a href="mailto:jrucinski@pma.com?subject=Bryan%20Test&body=This%20is%20the%20test%20body%20text">email text</a>
</body>

</html>