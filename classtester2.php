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

            

///add in a check to ensure that both arrays have the same amount of columns
$buyers =$buyers->AssociativeData;
$suppliers = $suppliers->AssociativeData;//var_dump($buyers);
$curKeyName = "";
$keys = "";

//var_dump($buyers);
//var_dump($suppliers);

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
        $h2="";
       
        foreach ($values as $itm => $value)
            {     
                 $header = "";
                if($first==true){
                    $h2 = '<h2>' . $value . '</h2>';
                    $first = false;
                }

                
                if(!is_array($value))
                    echo '';
                else{                                 
                    foreach($value as $key =>$val) 
                    {
                        $header .= "<td>" . $key . "</td>";
                        $buyerMatches=0;                        
                        if(array_key_exists($key,$masterArray[$i])){                            
                            $items = str_split($masterArray[$i][$key]);
                            $supplierItems = str_split($values[$itm][$key]);
                             for($x=0;$x<sizeof($items)-1;$x++){
                                if($items[$x] !=0 && $items[$x] == $supplierItems[$x])
                                    ++$buyerMatches;               
                            }
                            if(array_sum($items)>0)
                                $matchPercent = ($buyerMatches/array_sum($items)*100);
                            else
                                $matchPercent = 0;
                            
                            $str .="<td>" . number_format($matchPercent,2) . "%</td>";
                            
                     
                        }
                       else
                        $str .="<td><strong>" .  $val . "</strong></td>";                        
                    }  
                   $str = "<tr>" . $str . "</tr>";
                   
                }                
            }
            echo $h2;
          
            echo "<table border='1'>" . $header . $str . "</table>";
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
