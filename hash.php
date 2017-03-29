<?php
$hashed =  password_hash("supersecretpassword", PASSWORD_BCRYPT);
$dehash = password_verify("supersecretpassword",$hashed);

echo $hashed . '<br/>' . $dehash;