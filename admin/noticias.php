<?php 
session_start();
require 'config.php';
require '../functions.php';
require 'views/header.php'; 

//print_r($_SESSION['usuario']);
$conexion = conexion($bd_config);
// Obtenemos los usuarios
$noticias = obtener_noticias($admin_config['usuario_por_pagina'], $conexion);
//echo '<pre>';
//print_r($usuarios);

//-------------SI ELIMINA UN USUARIO Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
  $mensaje = $_GET['e'];
  if ($mensaje==='o') {
    echo "<script>";
      echo "mensajeEliminaNoticia();";
    echo "</script>";
  }
  
  if ($mensaje==='e') {
    echo "<script>";
      echo "mensajeIngresadoNoticia();";
    echo "</script>";
  }
}

?>

<div class="contenedor-menu">

	<a href="nuevaNoticia.php" class="btn">Nueva Noticia</a>
	<!-- <a href="cerrar.php" class="btn">Cerrar Sesion</a>-->
	<h2 class="titulo">Listado de Noticias</h2>
	<section class="post">
	<table class="tablaNoticias">
        <tr>
          <th scope="col">N&ordm;</th>
          <th scope="col">Orden</th>
          <th scope="col">Fecha</th>
          <th scope="col">Título</th>
          <th scope="col" class="notiInt">Intro</th>
          <th width="100" scope="col">Acción</th>
        </tr>

	<?php 
  $i = 1;
  foreach($noticias as $noticia):?>
		<tr>
              <th scope="col"><?php echo $i;?></th>
              <th scope="col"><?php echo $noticia['orden'];?></th>
              <th scope="col"><?php echo $noticia['fecha'];?></th>
              <th scope="col"><?php echo $noticia['titulo'];?></th>
              <th scope="col"><?php echo substr($noticia['intro'],0,118);?></th>
              <th  scope="col" class="tableCol">
              <a href='editarNoticia.php?id=<?php echo $noticia['id']?>'><img src="../img/editar.png" class="imgTabla"></a>
              <a onclick="return confirm('Seguro desea eliminar la Noticia?');" href="borrarNoticia.php?id=<?php echo $noticia['id']?>p=<?php echo pagina_actual();?>"><img src="../img/borrar.png" class="imgTabla"></a>

              </th>
            </tr>
	
	</section>
	<?php 
    $i++;
    endforeach; ?>
	</table>
</div>

<?php require 'paginacion_noticias.php'; ?>
</html>
<?php require 'views/footer.php'; ?>
</body>
