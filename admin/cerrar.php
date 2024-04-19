<?php session_start();

session_destroy(); //destuimos la sesion para que el usuario si vuelve a accedr se tenga que loguar nuevamente
$_SESSION = array(); // la sesion la limpiamos la igualamos a un array vacios

header('Location: login.php'); //mandamos a login nuevamente
die();

?>