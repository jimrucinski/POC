<?php
    include 'MatchingData.class.php';
    include 'PmaMatching.class.php';

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


var_dump($buyers->AssociativeData);


$BuyerSupplierResults= Array();
$Indie = Array();

foreach($buyers->Data as $buyer){
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

        

}

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
