<?php
class HashMe
{
    private $pass;
    private $hash;

    public function __construct($password, $hashvalue){
    $this->pass = $password;
    $this->hash = $hashvalue;
    }

    
    public function isValid(){
        if(password_verify($this->pass,$this->hash)){

            if(password_needs_rehash($this->hash, PASSWORD_DEFAULT))
                echo 'rehash needed';
            else
                echo 'it is hashed fine';
            return true;
        }
        else
            return false;
    }

}
    

?>