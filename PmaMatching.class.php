<?php
class PmaMatching
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
    public $AssociativeData=array();

   
    public function __construct($csvFile){
        $this->csvFile = $csvFile;
        $this->fileName = basename($csvFile["name"]);
        $this->targetFileWithPath = $this->uploadPath . $this->fileName;
        $this->fileType = $this->csvFile['type'];                       
    }

    public function UploadFile(){
        if(in_array($this->fileType, $this->allowedFileTypes)){
            move_uploaded_file($this->csvFile["tmp_name"], $this->targetFileWithPath); 
            $this->generateData();
            $this->generateAssociativeArray();
            return true;
        }
        else{            
            throw new Exception("You are not permitted to upload files of this type.");
            return false;
        }
    }

    private function generateAssociativeArray(){
       ini_set('auto_detect_line_endings', true);

        $file = fopen($this->targetFileWithPath, 'r') or die('Unable to open file!');
        $returnVal = array();
        $header = null;

        while(($row = fgetcsv($file)) !== false){
            if($header === null){
                $header = $row;
                $uniqueHeaders=array_unique($header);
                continue;
            }
            
            $newRow = array();

            foreach($uniqueHeaders as $uniqueHeader)
                {
                $concat="";
                $label ="";
                for($i = 0; $i<count($row); $i++){
                    if($i==0){//check for the first column ... this is name.
                        //$concat=$row[$i];
                        $label=$row[$i];
                    }
                    else{
                    if($header[$i] === $uniqueHeader)
                    {
                        $concat.=trim($row[$i]) <> ''?1:0;
                    }
                    }
                }
                    
                    $newRow[$uniqueHeader] = $concat;
                    
                    
                }
                $newRow[$header[0]] = $label;//add in the company name to the appropriate position in the array
            $returnVal[] = $newRow;
        }
        $this->AssociativeData = $returnVal;
        fclose($file);
    }
        

     private function generateData(){
        $file = fopen($this->targetFileWithPath, "r");
        $data =fgetcsv($file);
        $skipFirstRow = true;
        $curRecord = array();
        while(($data = fgetcsv($file,100000,",")) !== FALSE)
        {
            $curRecord="";
            $curRecord[] = $data[0];
            $curval="";
            for($i=1;$i<sizeof($data);$i++){                    
                    $curval .= trim($data[$i]) <> ''?1:0;                    
                }
            $curRecord[]=$curval;
            $this->Data[]=$curRecord;            

        }
    }

}


?>