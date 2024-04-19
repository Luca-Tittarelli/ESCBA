<?php session_start();

require 'config.php';
require '../functions.php';

// Comprobamos si la session esta iniciada, sino, redirigimos.
comprobarSession();

// 1.- Conectamos a la base de datos
$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

$id = limpiarDatos($_GET['id']);

// Comprobamos que exista un ID, sino viene id redireccionamos
if (!$id) {
	header('Location:' . RUTA . 'admin');
}

//eliminamos con delete para borrado logico hay que agregar campo en la DB y hacer un update
$statement = $conexion->prepare('UPDATE contactos SET borrado = 1 WHERE id = :id');
$statement->execute(array('id' => $id));

if ($statement) {
	$mensaje = 'o';
}
//echo pagina_actual();die;
//require 'paginacion_contactos.php';
header('Location: ' . RUTA . 'admin/contactos.php?p='.pagina_actual().'&e='.$mensaje);

?>