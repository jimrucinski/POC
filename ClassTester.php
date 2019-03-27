<?php
    include 'MatchingData.class.php';
    include 'PmaMatching.class.php';

function recursive($array){
    foreach($array as $key => $value){
        //If $value is an array.
        if(is_array($value)){
            //We need to loop through it.
            recursive($value);
        } else{
            //It is not an array, so print it out.
            echo '<strong>' . $key . '</strong>' . ' = ' . $value, '<br>';
        }
    }
}


    if (isset($_FILES['first'])){
        try{

            $buyers = new PmaMatching($_FILES['first']);
            $suppliers= new PmaMatching($_FILES['second']);
            if($buyers->UploadFile()){
              // var_dump($buyers->Data);
            }
            if($suppliers->UploadFile()){
               //var_dump($suppliers->Data);
            }


///add in a check to ensure that both arrays have the same amount of columns
$buyers =$buyers->AssociativeData;
$suppliers = $suppliers->AssociativeData;//var_dump($buyers);
$curKeyName = "";
$keys = "";
$masterArray = Array();
$coArray = Array();
foreach($buyers as $buyer){
    $keys = array_keys($buyer);
    $buyerCompanyName = $buyer[$keys[0]]; //company name should always be in position zero.
    echo '<h2>' . $buyerCompanyName  . '</h2>';
   $coArray = array('PrimaryCompanyName' => $buyerCompanyName);
    
   // $childArray= Array();
   // $indivMatches = array();
    for ($i=1;$i<sizeof($keys);$i++){
        //$matches=Array();
        $items = str_split($buyer[$keys[$i]]); //array of all the buyers responses for the current product or region
        $itemCares = array_sum($items); // total amount of things the buyer cares about
        echo 'cares about ' . $itemCares . '<br/>';
        
        foreach($suppliers as $supplier){
            
            $buyerMatches = 0;
            $supplierKeys = array_keys($supplier);
            $supplierCompanyName = $supplier[$supplierKeys[0]];  
            $supplierItems = str_split($supplier[$supplierKeys[$i]]);//array of all the suppliers responses for the current product or region                      
            echo '<br/><i>' . $supplierCompanyName . '</i>';
            
             //for($supi=1;$supi<sizeof($supplierKeys);$supi++)
           // {
            //   array_push($childArray,$supplierCompanyName);
            for($x=0;$x<sizeof($supplierItems);$x++){
                if($items[$x] !=0 && $items[$x] == $supplierItems[$x])
                    ++$buyerMatches;                    
            }
            
           // $matches[$supplierKeys[$i]] = ($buyerMatches/$itemCares)*100;
           
            echo '<br/>&nbsp;&nbsp;&nbsp;' .  $supplierKeys[$i] . ' MATCHES = ' . $buyerMatches.' percent match = ' . ($buyerMatches/$itemCares)*100 ;
            $supArray = array('SecondaryCompanyName' => $supplierCompanyName, $supplierKeys[$i] => $buyerMatches);
            //var_dump($matches);
           // }
           if($i===sizeof($keys)-1)//if we are done with this record add to the array ... otherwise records add multiple times
            array_push($coArray, $supArray);  
        }
         //var_dump($matches);
    }

    array_push($masterArray,$coArray);
}

//var_dump($masterArray);
echo '<p>';
recursive($masterArray);
echo '</p>';
//var_dump($buyers);
//var_dump($suppliers);
 /*
$keys = array_keys($buyers);
for($i = 0; $i < count($buyers); $i++) {
   
    $companyName=true;    
    foreach($buyers[$keys[$i]] as $key => $value) {
       $items = str_split($value);
       //var_dump($items);
        $buyerTotal = "";
        if(!$companyName)
            $buyerTotal = array_sum(str_split($value));
        else{
            echo $value .'<br/>';
            $companyName = false;
        }
        
        foreach($suppliers[$keys[$i]] as $key => $value){
            echo '     ' . $value . '<br/>';
        }
        //echo $buyerTotal . '  ';
        //echo $key . " " . $value . "<br>";
    }
    echo "}<br>";
    
}
*/
$BuyerSupplierResults= Array();
$Indie = Array();

/*foreach($buyers->Data as $buyer){
     $arBuy = str_split($buyer[1]);
     $buyerTotal = array_sum($arBuy);
     foreach($suppliers->Data as  $supplier){
         $Indie = Array();
         $buyerMatches=0;
         $arSup = str_split($supplier[1]);
         for($i=0;$i<sizeof($arBuy);$i++){
             if($arBuy{$i}!=0 && $arBuy[$i] == $arSup[$i]){
                 ++$buyerMatches;
             }
         }      
         $buyerMatchPercent = ($buyerMatches/$buyerTotal) * 100;
         array_push($Indie,$buyer[0]);
         array_push($Indie,$supplier[0]);
         array_push($Indie,(float)$buyerMatchPercent);
         array_push($BuyerSupplierResults, $Indie);

     }
        foreach($BuyerSupplierResults as $result){
            //var_dump($result);
        }
        
       // array_multisort($BuyerSupplierResults[2], SORT_NUMERIC, SORT_DESC);

        

}*/

//var_dump($BuyerSupplierResults);


//var_dump($BuyerSupplierResults);
 /*               
     // Printing all the keys and values one by one
$keys = array_keys($buyers->Data);
for($i = 0; $i < count($buyers->Data); $i++) {
    
    echo $keys[$i] . "{<br>";
    foreach($buyers->Data[$keys[$i]] as $key => $value) {
        echo $key . " : " . $value . "<br>";
    }
    echo "}<br>";
}
     */           
               //foreach($datas as $data){
               //     foreach($data as $item){
               //         echo $item . '<br/>';
               //     }
               //}                
     

           // if($buyers->UploadFile()){
           //     echo 'file upped<br/>';

           //     $datas = $buyers->Data;
           //     var_dump($datas);
                
               //foreach($datas as $data){
               //     foreach($data as $item){
               //         echo $item . '<br/>';
               //     }
               //}                
           // }   

            //$upload = new MatchingDataUpload($_FILES['fileup']);
           // if($upload->uploadFile()){
            //    echo($upload->GenerateInsertStatement());
               //echo($upload->generateInsertStatement());
               /*
               $cols = $upload->ColumnNames;

               foreach($cols as $col){
                   echo $col . '<br/>';
               }

               $datas = $upload->Data;
               foreach($datas as $data){
                    foreach($data as $item){
                        echo $item . '<br/>';
                    }
                   //echo $data . '<br/>';
               }
               */
          //  }
        }
        catch(Exception $ex){
            echo $ex->getMessage();
        }
    }
?>
<form enctype="multipart/form-data" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
<p>files are overwritten. no warning is given. this is not a file storage facility.</p>
<input type="file" name="first"/><br/>
<input type="file" name="second"/><br/>
<input type="submit"/>
</form>
