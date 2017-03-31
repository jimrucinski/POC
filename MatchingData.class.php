<?php
class MatchingDataDataLoad
{
    private $pathToFile;
    private $obj;
    
    public function __contruct(MatchingDataUpload $obj)
    {
        $this->obj = $obj;
    }

    public function Test(){
        echo 'here';
        var_dump($this->obj);
    }


}

class MatchingDataUpload
{
    private $uploadPath='Uploads/';
    private $allowedFileTypes = array('application/vnd.ms-excel');

    private $targetFileWithPath;
    private $csvFile;
    private $fileName;
    private $fileType;
    private $tableName="uploadedData";

   
    public function __construct($csvFile){
        $this->csvFile = $csvFile;
        $this->fileName = basename($csvFile["name"]);
        $this->targetFileWithPath = $this->uploadPath . $this->fileName;
        $this->fileType = $this->csvFile['type'];
                       
    }
    

    public function uploadFile(){
        if(in_array($this->fileType, $this->allowedFileTypes)){
            move_uploaded_file($this->csvFile["tmp_name"], $this->targetFileWithPath); 
            return true;
        }
        else{            
            throw new Exception("You are not permitted to upload files of this type.");
            return false;
        }
    }

    public function generateInsertStatement(){
        $file = fopen($this->targetFileWithPath, "r");
            $insertSQL = "INSERT into " . $this->tableName . "(" . $cols . ")";
            $vals="";
            $skipFirstRow = true;
            while(($data = fgetcsv($file,100000,",")) !== FALSE)
            {
                $curval="";
                if($skipFirstRow){$skipFirstRow=false;}
                else{
                    $curval = "(";
                for($i=0;$i<sizeof($data);$i++){
                    if($i==0)
                        $curval .= '"' . trim($data[$i]) . '"';
                    else
                        $curval .= trim($data[$i]) <> ''?1:0;
                    $curval .= ',';
                }
                $curval = rtrim($curval, ",");
                $curval .=  "),";
                }
                $vals .= $curval;
            }
            $vals = rtrim($vals,',');
            $insertSQL .= ' VALUES' . $vals;
    }
}

?>
