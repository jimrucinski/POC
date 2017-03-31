<?php

    
    if (isset($_FILES['fileup'])){
        $target_dir = "uploads/";
        $filename = basename($_FILES["fileup"]["name"]);
        $target_file = $target_dir . $filename;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if($imageFileType!='csv'){
            echo 'wrong file type';
        }
        else{
            move_uploaded_file($_FILES['fileup']["tmp_name"], $target_file);
            $dsn="mysql:dbname=buyerssuppliers;host=localhost";
            $username="root";
            $password = "";
            $db="buyerssuppliers";
            $conn = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $handle = fopen($target_file, "r");
            // Read first (headers) record only)
            $data = fgetcsv($handle, 1000, ",");
            $sql= 'CREATE TABLE uploadtesting (';
            $cols = "";
            for($i=0;$i<count($data); $i++) {
            $sql .= 'col' . $i .' VARCHAR(50), ';
            $cols .= 'col' . $i .',';
            }
            $cols = rtrim($cols,', ');
            $sql = rtrim($sql,', ');
            $sql .=  ')';
            echo $sql;
            try{
            $stmt = $conn->prepare($sql);
            $stmt->execute();      

            $file = fopen($target_file, "r");
            $insertSQL = "INSERT into uploadtesting(" . $cols . ")";
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

            echo $insertSQL;
            $conn->exec("SET CHARACTER SET utf8");  
            $stmt2 = $conn->prepare($insertSQL);
            $stmt2->execute();
            }
            catch(PDOException $ex){
                echo ($ex.getMessage());
            }
            fclose($handle);
            }   
    }

?>

<form enctype="multipart/form-data" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
<input type="file" name="fileup"/>
<input type="submit"/>
</form>