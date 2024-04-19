<?php require 'views/header.php';
$conexion = conexion($bd_config);

//-------------SI ELIMINA UN contacto Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='o') {
	  echo "<script>";
		echo "mensajeIngresadoActualiza();";
	  echo "</script>";
	}
  }
?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Editar Epígrafe</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="editarEpigrafe" class="formulario"  method="POST">
				<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
						<input type="hidden" name="id" value="<?php echo $imagen['noticias_id']; ?>">
						<input type="hidden" name="id_imagen" value="<?php echo $imagen['id']; ?>">
						<label for="epigrafe">Epígrafe</label><br>
						<input type="text" class="frmEditUser" name="epigrafe" value="<?php echo $imagen['epigrafe'] ?>"><br>
	
						<input type="submit" value="Guardar Datos" class="btn"  >
						<input type="button" value="Volver a la Noticia" onclick="history.back()" class="btn"  >
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
				
				</form>
			</article>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>
