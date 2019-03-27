<?php
class MatchingDataUpload
{
    private $uploadPath='Uploads/';
    private $allowedFileTypes = array('application/vnd.ms-excel');
    private $targetFileWithPath;
    private $csvFile;
    private $fileName;
    private $fileType;
    private $tableName="uploadedData";

    public $ColumnNames = array();
    public $Data=array();

   
    public function __construct($csvFile){
        $this->csvFile = $csvFile;
        $this->fileName = basename($csvFile["name"]);
        $this->targetFileWithPath = $this->uploadPath . $this->fileName;
        $this->fileType = $this->csvFile['type'];
                       
    }
    
/**
    *Description goes hear. 
*/
    public function UploadFile(){
        if(in_array($this->fileType, $this->allowedFileTypes)){
            move_uploaded_file($this->csvFile["tmp_name"], $this->targetFileWithPath); 
            $this->generateColumnNames();
            $this->generateData();
            return true;
        }
        else{            
            throw new Exception("You are not permitted to upload files of this type.");
            return false;
        }
    }

//Get the column names of the file necessary for creating an the SQL create Table statment.
    private function generateColumnNames(){
        $file = fopen($this->targetFileWithPath, "r");
        $cols = "";
        $data =fgetcsv($file);        

        for($i=0;$i<sizeof($data);$i++){
            if(trim($data[$i])<>"")
            $this->ColumnNames[] = trim($data[$i]);
        } 
    }

    private function generateData(){
        $file = fopen($this->targetFileWithPath, "r");
        $data =fgetcsv($file);
        $skipFirstRow = true;
        $curval = array();
        while(($data = fgetcsv($file,100000,",")) !== FALSE)
        {
            $curval="";
            for($i=0;$i<sizeof($data);$i++){                    
                $curval[] = trim($data[$i]);
            }
            $this->Data[] = $curval;
        }
    }
    
    public function GenerateInsertStatement(){

        $out = "INSERT INTO " . $this->tableName ;
        $cols = "";
        $curval = "";
        foreach($this->ColumnNames as $ColumnName){
            $cols .= $ColumnName . ',';
        }
        $cols = rtrim($cols,',');
        
        $out .= '(' . $cols . ') VALUES(';

        foreach($this->Data as $items)
        {
            $curval=' (';
            for($i=0;$i<sizeof($items);$i++)
            {
                $curval.=trim($items[$i]);
            }
            $curval .= '),';
            $out .= $curval;
            $curval='';
        }
        $out .= rtrim($out,',');
        $out .=")";
        return rtrim($out,',');


    }
    
}

?>
