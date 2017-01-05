<?php
include './PmaDb.class.php';
include './PmaTix.class.php';
include '../wp-config.php';
include 'PmaSupportFile.class.php';

$body="<table><tr><td>one row</td></tr><tr id='oneRowContent'></td>this is one row content</td></tr></table>";
$wrUrl="http://www.cnn.com";
$addresses[]='jrucinski@pma.com';
sendMail('New CRON Message', $body . $wrUrl , $addresses, false );