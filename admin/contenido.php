<?php session_start();

// Comprobamos tenga sesion, si no entonces redirigimos y MATAMOS LA EJECUCION DE LA PAGINA.
//si esta seteada la sesion usuario le mostramos contenido
if (isset($_SESSION['usuario'])) {
	require 'views/contenido.view.php';
} else {
	header('Location: login.php');
	die();
}

?>