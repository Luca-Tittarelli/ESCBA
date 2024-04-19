<?php require 'views/header.php';
$conexion = conexion($bd_config);

//-------------SI ELIMINA UN COLABORADOR Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='o') {
	  echo "<script>";
		echo "mensajeIngresadoActualizaNot();";
	  echo "</script>";
	}
  }

  if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='ep') {
		echo "<script>";
			echo "imagenPrincipalModificada();";
		echo "</script>";
	}
}


if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='egal') {
		echo "<script>";
			echo "imagenEliminadaEnGaleria();";
		echo "</script>";
	}
}

if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='epi') {
		echo "<script>";
			echo "editaEpigrafe();";
		echo "</script>";
	}
}

  $fecha = $noticia['fecha'];

	$fecha = converToLatinDate($fecha);
	//echo "<br>".$fecha;
	$fecha = converToLatinDateString($fecha);
	//echo "<br>".$fecha;
	$fecha = converToEnglishDate($fecha);
?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Editar Noticia</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="editarNoticia" class="formulario"  method="POST" enctype="multipart/form-data">
				<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
						<input type="hidden" name="id" value="<?php echo $noticia['id']; ?>">
					<label for="titulo">Título</label><br>
						<input type="text" class="frmEditUser" name="titulo" value="<?php echo $noticia['titulo']; ?>" required><br>
					<label for="fecha">Fecha</label><br>
						<input type="date" class="frmEditUser" name="fecha" value="<?php echo $fecha;?>"  required><br>
					<label for="intro">Intro</label><br>
						<textarea class="frmEditUser" name="intro" id="" rows="5" required><?php echo $noticia['intro'];?></textarea><br>
					<label for="detalle">Detalle</label><br>
						<textarea class="frmEditUser" name="detalle"  rows="10" id=""  required><?php echo $noticia['detalle'];?></textarea><br><br><br>
					<label for="orden">Orden</label><br><br>
						<input type="number" class="frmEditUser" name="orden" min="1" value="<?php echo $noticia['orden'];?>" ><br><br>
						<label for="fuente">Fuente</label><br><br>
						<input type="text" class="frmEditUser" name="fuente" value="<?php echo $noticia['fuente'];?>" ><br><br>

					<label for="destacado">¿ Destacar Noticia ?</label><br><br>
					<?php 
					
						if($noticia['destacado'] == 1){
							echo '<input type="radio" name="destacado" id="" value="1" checked  class="formulario"> NO &nbsp;&nbsp;';
							echo '<input type="radio" name="destacado" id="" value="0" class="formulario"> SI &nbsp;&nbsp;<br><br>';
						}else{
							echo '<input type="radio" name="destacado" id="" value="1"   class="formulario"> NO &nbsp;&nbsp;';
							echo '<input type="radio" name="destacado" id="" value="0" checked class="formulario"> SI &nbsp;&nbsp;<br><br>';
						} ?>

					<?php if(!empty($noticia['imagen'])!=''){?>
						<label for="">Imagen Principal</label><br>
						<img src="../img/noticias/<?php echo $noticia['imagen']; ?>" alt="" width="200px"><br>
						<?php if($imagenesGal){?>
							<a href='editarImagenNoticia.php?id=<?php echo $noticia['id']?>&imagen=<?php echo $noticia['imagen']?>'><img src="../img/editar.png" class="imgTabla"></a><br><br><br>
						<?php }else{?>
							<a href="borrarImagenNoticia?id=<?php echo $noticia['id'];?>&imagen=<?php echo $noticia['imagen'];?>" onclick="return confirm('Seguro desea eliminar la imagen?');">
							<img border="0" src="../img/borrar.png" width="30px"/></a><br><br>						
						<?php }?>
						<a href="subirImagenes.php?id=<?php echo $noticia['id']; ?>" class="btn">Agregar Imágenes a la Galeria de Esta Noticia</a><br><br>
					
							<?php if ($imagenesGal) {
								echo '<label for="">Imagenes de la Galeria</label><br><br>';
								echo '<div class="divImg">';
								foreach($imagenesGal as $imagenGal){?>
									<div class="imgGal">
										<img src="../img/noticias/<?php echo $imagenGal['imagen'];?>"  class="imgTamanoGal"><br>
										<p><?php echo $imagenGal['epigrafe']; ?></p>
										<a href='editarImagenGal.php?id=<?php echo $imagenGal['noticias_id'];?>&id_imagen=<?php echo $imagenGal['id'];?>'><img src="../img/editar.png" class="imgTabla"></a>
										<a onclick="return confirm('Seguro desea eliminar la Imagen?');" href="borrarImagenGal.php?idImg=<?php echo $imagenGal['id']?>&id=<?php echo $imagenGal['noticias_id'];?>&imagen=<?php echo $imagenGal['imagen'];?>"><img src="../img/borrar.png" class="imgTabla"></a>
									</div>
								<?php	}
								echo '</div>';
								echo '<br><br>';
							} //fin si tiene imagenes para la galeria ?>

					<?php }else{ ?>
						<label for="imagen">Suba Imagen</label>
						<!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
						<input type='file' class="frmEditUser" name='imagen' required><br><br>
					<?php } ?>
					<input type="submit" value="Guardar Datos" class="btn"  >
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
				
				</form>
			</article>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>
