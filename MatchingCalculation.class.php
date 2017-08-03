<?php
class MatchingCalculation
{
    private $inData = array();
    private $outData = array();
    private $structuredArray = array();

    private $matchingData=array();

    //$ar = master array of buyers and suppliers
    //$keyArray is the column names from the excel files used to create the output array of this object
    public function __construct($ar, $keyArray){
        $this->inData = $ar;        
        $this->structuredArray = $keyArray;
    }

    public function GetCalculatedResults(){
        $this->calculateMatching();
        return $this->matchingData;
    }

    private function calculateMatching(){
 
        foreach ($this->inData as $i => $values) {
        $first = true;
        $ar = $this->structuredArray;

        foreach ($values as $itm => $value)
            {     
            $keys = array();               
            if($first==true){
                array_push($this->outData,$value);
                $first = false;
            }
            if(is_array($value))
               {                                                   
                foreach($value as $key =>$val) 
                {                     
                $buyerMatches=0;                          
                //array_push($keys,$key);                
                if(array_key_exists($key,$this->inData[$i])){                            
                    $items = str_split($this->inData[$i][$key]);
                    $supplierItems = str_split($values[$itm][$key]);
                        for($x=0;$x<sizeof($items)-1;$x++){
                        if($items[$x] !=0 && $items[$x] == $supplierItems[$x])
                            ++$buyerMatches;               
                    }
                    if(array_sum($items)>0)
                        $percentMatch = ($buyerMatches/array_sum($items)*100);
                    else
                        $percentMatch = 0;

                    $ar[$key]= number_format($percentMatch,2);

                }
                else{                       
                    $ar[$key]=$val;   

                }                                           
            }  
            array_push($this->outData,$ar);            
        }    
    }

        if(!empty($ar)){
            array_push($this->matchingData,$this->outData);
            unset($ar);
            $ar = $this->structuredArray;       
            $this->outData = array(); 
            }
        }

    }
}
