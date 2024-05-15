<?php
$host='mysql-atlantic-web.alwaysdata.net';
$user='343531_theo';
$passwd='fcad24_theo';
$db='atlantic-web_sp';

ini_set("display_errors",1);

//mysqli class https://www.php.net/manual/en/class.mysqli.php

//procedural : mysqli_connect();
//instance mysqli() class => $mysqliObject object
//https://www.php.net/manual/en/mysqli.construct.php

$mysqliObject=new mysqli($host,$user,$passwd,$db);


//var_dump($mysqliObject);


//procedural : mysqli_connect_errno(), mysqli_connect_error()
//mysqli class https://www.php.net/manual/en/class.mysqli.php
//connect_errno, connect_error, if()
//https://www.php.net/manual/en/mysqli.connect-errno.php
//https://www.php.net/manual/en/mysqli.connect-error.php

if($mysqliObject->connect_errno){
	echo "Error N° ".$mysqliObject->connect_errno." , Msg : ".$mysqliObject->connect_error."<br>";
	exit();
} else {
	echo "<span style=\"color:green;\">Connected to the database ".$db." on the server ".$host." with success</span><br>";
}

//procedural : mysqli_set_charset()
//mysqli class https://www.php.net/manual/en/class.mysqli.php
//set_charset()
//https://www.php.net/manual/en/mysqli.set-charset.php

$mysqliObject->set_charset('utf8');
?>