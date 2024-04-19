<?php 

session_start();

// Comprobamos tenga sesion, si no entonces redirigimos y MATAMOS LA EJECUCION DE LA PAGINA.
if(isset($_SESSION['usuario'])) {
	header('Location: contenido.php');
	die();
} else {
	// Enviamos al usuario al formulario de LOGIN, PARA QUE EL USUARIO PUEDA LOGUEARSE
	header('Location: login.php');
}

?>