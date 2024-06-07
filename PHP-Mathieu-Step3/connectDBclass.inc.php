<?php
$host='mysql-atlantic-web.alwaysdata.net';
$user='343531_theo';
$passwd='fcad24_theo';
$db='atlantic-web_sp';

ini_set("display_errors",0);

$mysqliObject=new mysqli($host,$user,$passwd,$db);
$mysqliOk="";

	session_start(); // Démarre la session pour l'échange de données via le cookie de session
	if($mysqliObject->connect_errno){
		$_SESSION['mysqliOk'] = "<span style=\"color:red;\">Error N° ".$mysqliObject->connect_errno." , Msg : ".$mysqliObject->connect_error."<br>";
		exit();
	} else {
		$_SESSION['mysqliOk'] = "<span style=\"color:green;\">Vous êtes connecté(e) à votre compte : ".$db.".</span><br><br>";
		$mysqliObject->set_charset('utf8mb4');
		// On vérifie si la connexion a été faite depuis le bouton de login
		if (isset($_GET['login']) ) {
			// Si oui on revient à la page d'origine
			header('Location: appSPC-M2.php');
			exit();
		}
	}

?>
