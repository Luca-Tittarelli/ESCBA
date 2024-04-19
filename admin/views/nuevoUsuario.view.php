<?php require 'views/header.php';
$conexion = conexion($bd_config);
?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Crear USUARIO</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="nuevoUsuario" class="formulario"  method="POST">
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
					<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>

					<label for="Nivel">Nivel Usuario</label><br>
						<select name="nivel" id="nivel">
							<option value="">Seleccione...</option>
						<?php 
						//llamamos a la funciones obtener_nivles para llenar el select 
						$niveles = obtener_niveles($conexion);
						
						foreach ($niveles as $nivel) { ?>
							<option value="<?php echo $nivel['id'];?>">
							<?php echo $nivel['nivel'] ;?>
							 </option>
						<?php  } ?>
						</select><br>
						<label for="usuario">Usuario</label><br>
						<input type="text" class="frmEditUser" name="usuario" required><br>
					<label for="pass">PassWord</label><br>
						<input type="password" class="frmEditUser" name="password" required><br>
					<label for="pass">Reingrese PassWord</label><br>
						<input type="password" class="frmEditUser" name="password2" required><br>
					<label for="nombre">Nombre</label><br>
						<input type="text" class="frmEditUser" name="nombre" required><br>
					<label for="apellido">Apellido</label><br>
						<input type="text" class="frmEditUser" name="apellido" required><br>
					<label for="email">E-mail</label><br>
						<input type="email" class="frmEditUser" name="email" required><br>
					<label for="telefono">Teléfono</label><br>
						<input type="text" class="frmEditUser" name="telefono" required><br>
						
	
					<input type="submit" value="Registrar Usuario" class="btn"  >
				
				</form>
			</article>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>
