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


$masterArray=array();

foreach($buyers as $buyer){
    $curBuyer = array();
    $primaryKeys = array_keys($buyer);
    $skipPrimaryCompany=true;//used to skip the first key in the array which is always company.
    
    foreach($primaryKeys as $key=>$val){
        $lastPosition = end($primaryKeys);
        if($skipPrimaryCompany){
            $curBuyer['Primary'.$val]=$buyer[$val];
            $skipPrimaryCompany=false;
        }            
        else{
           // $items = str_split($buyer[$val]); //array of all the buyers responses for the current product or region
           // $itemCares = array_sum($items);             
           // $curBuyer[$val . 'Cares']=$itemCares;
            $curBuyer[$val] = $buyer[$val];  
            if($val==$lastPosition){
            $curSupplier=Array();   
            foreach($suppliers as $supplier){
                $secondaryKeys = array_keys($supplier);
                
                foreach($secondaryKeys as $secondaryKey=>$secondaryVal){
                    $curSupplier[$secondaryVal] = $supplier[$secondaryVal];    
                }        
            array_push($curBuyer, $curSupplier);
           }     
            }
        }
    }
    array_push($masterArray,$curBuyer);
}

//var_dump($masterArray);
    foreach ($masterArray as $i => $values) {
        $first = true;
        $str="";
        foreach ($values as $itm => $value)
            {     
                if($first==true){
                    $str = '<h2>' . $value . '</h2>';
                    $first = false;
                }


                if(!is_array($value))
                    echo '';
                   // echo $itm . ' = ' . $value . '<br/>';
                else{
                                 
                    foreach($value as $key =>$val)
                    {
                        $buyerMatches=0;
                        if(array_key_exists($key,$masterArray[$i])){
                            $items = str_split($masterArray[$i][$key]);
                            $supplierItems = str_split($values[$itm][$key]);
                             for($x=0;$x<sizeof($items);$x++){
                                if($items[$x] !=0 && $items[$x] == $supplierItems[$x])
                                    ++$buyerMatches;               
                            }
                            $str .=  $key . " Match Percent: " .  $buyerMatches/array_sum($items)*100 . '<br/>';
                            //$str .= $masterArray[$i][$key] . ' - ' . $values[$itm][$key] .  $key .  $buyerMatches/array_sum($items)*100 . '<br/>';
                            //echo $masterArray[$itm][$key] . ' = ' . $val . '<br/>';                         
                        }
                       else
                        $str .="<strong>" .  $val . "</strong><br/>";
                    }
                   
                    
                }
            }
            echo $str;
    }

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
