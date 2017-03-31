<?php
    include 'MatchingData.class.php';

    if (isset($_FILES['fileup'])){
        try{
            $upload = new MatchingDataUpload($_FILES['fileup']);
            if($upload->uploadFile()){
                $upload->loadDataToDatabase();
            }
        }
        catch(Exception $ex){
            echo $ex->getMessage();
        }
    }
?>
<form enctype="multipart/form-data" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
<p>files are overwritten. now warning is given. this is not a file storage facility.</p>
<input type="file" name="fileup"/>
<input type="submit"/>
</form>
