<?php session_start(); // Démarrege d'un clé de session

function isConnected()
{
	return ! empty($_SESSION['user']);
}

$path = $_SERVER['PHP_SELF'];
$file = basename ($path);
?>