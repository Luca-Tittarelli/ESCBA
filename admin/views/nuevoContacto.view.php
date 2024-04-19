<?php require 'views/header.php';
$conexion = conexion($bd_config);
?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Crear CONTACTO</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="nuevoContacto" class="formulario"  method="POST">
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
					<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
					<label for="nombre">Nombre</label><br>
						<input type="text" class="frmEditUser" name="nombre" value="" required><br>
					<label for="apellido">Apellido</label><br>
						<input type="text" class="frmEditUser" name="apellido" value="" required><br>
					<label for="email">E-mail</label><br>
						<input type="email" class="frmEditUser" name="email" value="" required><br>
					<label for="telefono">Teléfono</label><br>
						<input type="text" class="frmEditUser" name="telefono" value="" required><br>
					<label for="mensaje">Mensaje </label><br>
						<textarea name="mensaje" class="frmEditUser" cols="30" rows="10"></textarea>
	
					<input type="submit" value="Guardar Datos" class="btn"  >
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
				
				</form>
			</article>
		</div>
	</div>
</body>
</html>
<?php //require 'footer.php'; ?>