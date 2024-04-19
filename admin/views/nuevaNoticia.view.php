<?php require 'views/header.php';
$conexion = conexion($bd_config);

//-------------SI ELIMINA UN COLABORADOR Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='o') {
	  echo "<script>";
		echo "mensajeIngresadoNoticia();";
	  echo "</script>";
	}
  }

?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Nueva Noticia</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="nuevaNoticia" class="formulario"  method="POST" enctype="multipart/form-data">
				<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
					<label for="titulo">Título</label><br>
						<input type="text" class="frmEditUser" name="titulo" value="" required><br>
					<label for="fecha">Fecha</label><br>
						<input type="date" class="frmEditUser" name="fecha" value="<?php $hoy=date("Y-m-d"); echo $hoy;?>"  min=<?php $hoy=date("Y-m-d"); echo $hoy;?>  required><br>
					<label for="intro">Intro</label><br>
						<textarea class="frmEditUser" name="intro" id="" rows="5" required></textarea><br>
					<label for="detalle">Detalle</label><br>
						<textarea class="frmEditUser" name="detalle"  rows="10" id=""  required></textarea><br><br>
					<label for="destacado">¿ Destacar Noticia ?</label><br><br>
					<input type="radio" name="destacado" id="" value="1" class="formulario" checked> NO
					<input type="radio" name="destacado" id="" value="0" class="formulario"> SI<br><br>
					<label for="orden">Orden</label><br><br>
					<input type="number" class="frmEditUser" name="orden" min="1" value="100" ><br><br>
					<label for="fuente">Fuente</label><br><br>
						<input type="text" class="frmEditUser" name="fuente" value=""><br><br>
					<label for="imagen">Suba Imagen</label>
					<!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
					<input type='file' class="frmEditUser" name='imagen' required><br><br>
					
					<input type="submit" value="Guardar Datos" class="btn"  >
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
				
				</form>
			</article>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>
