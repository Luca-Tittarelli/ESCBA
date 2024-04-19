<?php

require 'admin/config.php';
require 'functions.php';



$conexion = conexion($bd_config);

if (!$conexion) {
	header('Location: error.php');
}


$id_noticia = id_noticia($_GET['id']);

//si el usuario no esta seteado mandamod a listado de usuarios
if (empty($id_noticia)) {
    header('Location: index.php');
}

// Obtenemos el usuario por id
$noticia = obtener_noticia_por_id($conexion, $id_noticia);

// Si no hay contacto en el ID entonces redirigimos.
if (!$noticia) {
    header('Location: index.php');
}


$noticia = $noticia[0];
$imagenPri = $noticia['imagen'];
//ECHO '<PRE>';
//print_R($noticia);
//IMAGENES DE GALERIA
$imagenesGal = obtener_imagenes_por_id_noticias($conexion, $id_noticia);
//print_r($imagenesGal);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpeg" type="image/x-icon">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 
    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--Hojas de estilos-->
    <link rel="stylesheet" href="css/estilos.css">
    <!--wow animaciones-->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>23 de abril: “Día Mundial del Idioma Español”</title>
    <!--METAS-->
    <meta name="author" content="ESCBA" />
    <meta name="title" content="23 de abril: “Día Mundial del Idioma Español" />
    <meta name="keywords" content="escuelas en leones, escuelas en cordoba, leones, cordoba, leones cordoba, intitucion en leones, instituciones, noticias de leones, noticias de hoy, noticias de cordoba, noticia escuelas, orientacion informatica, informatica, orientaciones comunicaciones, comunicaciones, orientacion economia, economia" />
    <meta name="description" content="Escuela de Leones, espacialidad informática, comunicaciones y economía,  brinda información sobre la institución, la ciudad y la región." />    
</head>
<body class="container-fluid">
    <?php require 'nav.php';?> 
    <div class="container-fluid"><!--CONTEINER BOOTSTRAP-->
        <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-12"> <!--DIV ROS BOOTSTRAP-->
            <main>
                    <h1 class="detH1">
                    <?php echo $noticia['titulo'];?>
                    </h1>
                    <section class="contenidoNoticia container-fluid">   

                        <!--pequeño intro de la noticia-->
                        <p class="detP">
                        <?php echo $noticia['intro'];?>
                        </p>
                        <?php if ($imagenPri != '') {
                            $botones = false;
                        ?>
                        <!--ACA PODRÍA IR LA IMAGEN DE LA NOTICIA Y UNA GALERIA O CARRUSEL DE IMAGENES-->
                            <div class="container my-3 carrusel">
                                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="img/noticias/<?php echo $imagenPri;?>" class="d-block w-100" alt="<?php echo $noticia['titulo'];?>">
                                        </div>
                                        <?php if ($imagenesGal) {
                                            $botones = true;
                                                foreach($imagenesGal as $imagenGal):?>      
                                                    <div class="carousel-item">
                                                        <img src="img/noticias/<?php echo $imagenGal['imagen'];?>" class="d-block w-100" alt="<?php echo $imagenGal['epigrafe'];?>">
                                                    </div>                                   
                                            <?php 
                                                endforeach; 
                                            }?>
                                    </div>
                                        <?php if ($botones) {?>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                            </button>
                                        <?php }?>
                                </div>
                            </div><!--Cierre div carrusel-->
                         <?php }?>
                        <p class="detP"> 
                            <?php echo $noticia['detalle'];?>
                        </p>
                </section>
            </main>
        </div> <!--CIERRE DIV ROW BOOTSTRAP-->
    </div><!--CIERRE DIV CONTAINER BOOTSTRAP-->
    <!-- Footer -->
    <?php require 'footer.php';?>       
<script src="libs/bootstrap/js/bootstrap.min.js"></script><!--BOOTSTRAP-->    
</body>
</html>