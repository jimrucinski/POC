<?php
    //include 'MatchingData.class.php';
    include 'MatchingCalculation.class.php';
    include 'PmaMatching.class.php';
    $report="";

    if (isset($_FILES['first'])){
        try{

            $buyers = new PmaMatching($_FILES['first']);
            $suppliers= new PmaMatching($_FILES['second']);
            $buyers->UploadFile();
            $suppliers->UploadFile();
            $buyers =$buyers->AssociativeData;

            //$keys=array_shift($buyers);
            $keys = array_keys($buyers[0]);



            //$arr = array_fill_keys($keys,'');
            //var_dump($arr);
            //die();
            $arr = array_fill_keys($keys,null);

            //var_dump($keys);
            //die();

            $suppliers = $suppliers->AssociativeData;
            //Ensure that both arrays have the same number of comparison elements.

            //if(max(array_map('strlen', $buyers[1])) != max(array_map('strlen', $suppliers[1]))){
            //    throw new exception("There is a problem pertaining to the number of comparison fields within the two uploaded tables. Please check to see if both files contain the same number of comparison columns.");
            //}


            $curKeyName = "";
            $keys = "";
            $percentMatch="";


            //var_dump($buyers);
            //var_dump($suppliers);
            $file = fopen("matching.csv","w");
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

            $matches = new MatchingCalculation($masterArray, $arr);

            $calcs= $matches->GetCalculatedResults();
            $str = "";
            $first=true;

            foreach($calcs as $calc){
                $str ="";
                $header = false;
                $strHeader="";
                $first=true;
                foreach($calc as $val)
                {
                    

                    if(is_string($val)){

                        $str .= '<h2>' . $val . '</h2>';
                        fputcsv($file,array($val));
                    }
                    else
                    {
                        $strRow = "";
                        
                        if($first){
                            fputcsv($file,array_keys($val));
                            $first=false;
                        }   
                        fputcsv($file,$val);
                        foreach($val as $key =>$v){
                        $strHeader .= "<td class='header'>" . $key . "</td>"; 
                        $strRow .= "<td>" . $v . "</td>";
                        
                        
                        }    
                        if(!$header){
                            $str .= "<tr>" . $strHeader . "</tr>";
                            $header = true;
                        }
                        $str .= "<tr>" . $strRow . "</tr>";
                    }       
                }
                fputcsv($file,array(''));
                $report .=  "<table border='1'>"  .  $str . "</table>";
            }
        }
        catch(Exception $ex){
            echo "<div id='errors'>" .  $ex->getMessage() . "</div>";
        }
    }
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style/matching.css">
</head>
<body>

<form enctype="multipart/form-data" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
<p>files are overwritten. no warning is given. this is not a file storage facility.</p>
<input type="file" name="first"/><br/>
<input type="file" name="second"/><br/>
<input type="submit"/>
<?php echo (strlen($report)>0?$report:'');?>
</form>
</body>
</html>
