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

    public function loadDataToDatabase(){
        echo 'here';
    }
}

?>
