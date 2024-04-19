<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../admin/js/functions.js"></script>
	<link rel="stylesheet" href="css/estilos.css">
	<link rel="shortcut icon" href="logo.jpeg" type="image/x-icon">

    <title>ESCBA</title>
</head>
<body>
    
<div class="logo">
				<img src="../img/logoBlanco.png" alt="Logo" class="imgLogo">	
	</div>
		<nav class="menu-navegacion">
			<ul class="navegacion_ul">
			<li class="navegacion__ul__li"> <a class="navegacion__a" href="noticias.php" class="encabezado__enlace">Noticias</a> </li>
			<li class="navegacion__ul__li"> <a class="navegacion__a" href="colaboradores.php" class="encabezado__enlace">Colaboradores</a> </li>
			<li class="navegacion__ul__li"> <a class="navegacion__a" href="contactos.php" class="encabezado__enlace">Contactos</a> </li>
				<?php 
					//COMPROBAMOS EL NIVEL DEL USUARIO, CUANDO EL USURIO TIENE NIVEL ROOT PERMITIMOS VER EL MENU USUARIOS, DONDE SE PUEDEN ADMINISTRAR LOS MISMOS, EJEMPLO CREAR NUEVOS, RESETEAR CONTRASEÑAS Y DEMAS
					if ($_SESSION['usuario']['nivel']==='R') {?>
					<li class="navegacion__ul__li"> <a class="navegacion__a" href="usuarios.php" class="encabezado__enlace">Usuarios</a></li>
				<?php }?>
				<li class="navegacion__ul__li"> <a class="navegacion__a" href="cerrar.php" class="encabezado__enlace">Cerrar Sesión</a></li>		
			</ul>
		</nav>		