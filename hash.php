<?php
include 'Passhasher/HashMe.class.php';

$hash = password_hash('biteme',PASSWORD_DEFAULT);
$passhash = new HashMe('biteme',$hash);





if($passhash->isValid())
    echo ('<br/>it is good');
else
    echo ('<br/>it is bad');


/*
$hashed =  password_hash("!!MaxwellSilverHammer", PASSWORD_BCRYPT);
$dehash = password_verify("supersecretpassword",$hashed);

echo $hashed . '<br/>' . $dehash;
*/