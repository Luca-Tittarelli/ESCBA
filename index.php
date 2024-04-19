<?php

require 'admin/config.php';
require 'functions.php';



$conexion = conexion($bd_config);

if (!$conexion) {
	header('Location: error.php');
}

// Obtenemos las Noticias
$noticias = obtener_noticias_front($conexion);
isset($noticias[0]) != '' ? $noticia1 = $noticias[0]  : $noticia1 = '';
isset($noticias[1]) != '' ? $noticia2 = $noticias[1]  : $noticia2 = '';
isset($noticias[2]) != '' ? $noticia3 = $noticias[2]  : $noticia3 = '';
isset($noticias[3]) != '' ? $noticia4 = $noticias[3]  : $noticia4 = '';


//TRAIGO TODOS LOS COLABORADORES, AL ESTAR ORDENADOS POR DESTACADO, EN EL FOREACH HACEMOS UN IF Y AL SEGUNDO SALIMOS DEL FOR, DE ESTA MANERA EVISTAMOS HACER UNA FUNCION MAS
$colaboradores = obtener_colaboradores_front($admin_config['colaboradores_por_pagina'], $conexion);


$noticiasSeg = noticias_front_segundaSec($conexion);
//var_dump($noticias);
/*
// Si no hay colaboradores entonces redirigimos
if(!$colaboradores){
	header('Location: error.php');
}
*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <!--Icono que se muestra en pantalla-->
    <link rel="shortcut icon" href="img/logo.jpeg" type="image/x-icon">

    <!--wow animaciones-->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>ESCBA - Leones - Noticias Destacadas Genecdnjsrales</title>
    <!--METAS-->
    <meta name="author" content="ESCBA" />
    <meta name="title" content="Noticias destacadas Generales de la Institución y la ciudad" />
    <meta name="keywords" content="escuelas en leones, escuelas en cordoba, leones, cordoba, leones cordoba, intitucion en leones, instituciones, noticias de leones, noticias de hoy, noticias de cordoba, noticia escuelas, orientacion informatica, informatica, orientaciones comunicaciones, comunicaciones, orientacion economia, economia" />
    <meta name="description" content="Escuela de Leones, espacialidad informática, comunicaciones y economía,  brinda información sobre la institución, la ciudad y la región." />

</head>

<body class="container-fluid">
<?php require 'nav.php';?>
    <div class="container-fluid"><!--CONTEINER BOOTSTRAP-->
        <div class="row col-xs-12 col-sm-4 col-md-12 col-lg-6 col-xl-12"> <!--DIV ROS BOOTSTRAP-->
        <!--CONTENIDO PRINCIPAL-->
            <main class="main Principal container-fluid">
                <section class="noticiaPrincipal container-fluid">
                    <?php if($noticia1){?>
                        <div class="noticiaPri container-fluid">
                            <!--AL HACER CLICK EN LA IMAGEN NOS LLEVA AL DETALLE NOTICIA-->
                            <a class="notPriA" href="detalleNoticia.php?id=<?php echo $noticia1['id'];?>"><img src="img/noticias/<?php echo ($noticia1['imagen']=='') ?  "notiBlankImg.png": $noticia1['imagen'];?>" alt="<?php echo $noticia1['titulo'];?>" class="notPriImg"></a>
                            <!--AL HACER CLICK EN EL TITULO NOS LLEVA AL DETALLE NOTICIA-->
                            <a class="notPriA" href="detalleNoticia.php?id=<?php echo $noticia1['id'];?>"><h1 class="notPriH1"><?php echo $noticia1['titulo'];?></h1></a>
                            <p class="notPriP"><?php echo $noticia1['intro'];?></p>
                        </div>
                    <?php }?>
                    <!--div donde va la noticia secundaria-->
                    <?php if($noticia2){?>
                        <div class="main__noticiaSecundaria container-fluid">
                            <a class="main__noticiaSecundaria__a" href="detalleNoticia.php?id=<?php echo $noticia2['id'];?>"><img src="img/noticias/<?php echo ($noticia2['imagen']=='') ?  "notiBlankImg.png": $noticia2['imagen'];?>" alt="<?php echo $noticia2['titulo'];?>" class="main__noticiaSecundaria__img"></a>
                            <!--AL HACER CLICK EN EL TITULO NOS LLEVA AL DETALLE NOTICIA-->
                            <a class="main__noticiaSecundaria__a" href="detalleNoticia.php?id=<?php echo $noticia2['id'];?>"><h1 class="main__noticiaSecundaria__h1"><?php echo $noticia2['titulo'];?></h1></a> 
                        </div>
                    <?php }?>
                </section>

                <section class="noticiasSec container-fluid">
                    <!--div en los cuales van 2 noticias-->
                    <div class="notXDos container-fluid">
                        <?php if($noticia3){?>
                            <a class="notXDos__a" href="detalleNoticia.php?id=<?php echo $noticia3['id'];?>"><img class="notXDos__img" src="img/noticias/<?php echo ($noticia3['imagen']=='') ?  "notiBlankImg.png": $noticia3['imagen'];?>" alt="<?php echo $noticia3['titulo'];?>"></a>
                            <a class="notXDos__a" href="detalleNoticia.php?id=<?php echo $noticia3['id'];?>"><h1 class="notXDos__h1"><?php echo $noticia3['titulo'];?></h1></a> 
                        <?php }?>
                        <?php if($noticia4){?>
                            <a class="notXDos__a" href="detalleNoticia.php?id=<?php echo $noticia4['id'];?>"><img class="notXDos__img" src="img/noticias/<?php echo ($noticia4['imagen']=='') ?  "notiBlankImg.png": $noticia4['imagen'];?>" alt="<?php echo $noticia4['titulo'];?>"></a>
                            <a class="notXDos__a" href="detalleNoticia.php?id=<?php echo $noticia4['id'];?>"><h1 class="notXDos__h1"><?php echo $noticia4['titulo'];?></h1></a> 
                        <?php }?>
                    </div>
                </section>
                <?php if($colaboradores){?>
                    <!--EN EN ASIDE VAN 2 O 3 IMAGENES DE COLABORADORES DONDE AL HACER CLICK LLEVA AL SITIO DEL COLABORADOR EN CASO DE TENERLO -->
                    <aside class="main__aside">
                        <?php 
                        $i = 1;
                        foreach($colaboradores as $colaborador):?>  

                                <a href="<?php echo $colaborador['sitioWeb'];?>" target="_blank"><img src="img/colaboradores/<?php echo ($colaborador['logo']=='') ?  "colaboradorsBlanco.png": $colaborador['logo'];?>" alt="<?php echo $colaborador['razonSocial'];?>" class="main__aside__img"></a> 
                            
                        <?php 
                        if($i==2){
                            break;
                        }
                        $i++;
                        
                        endforeach; ?>
                </aside>
                <?php }?>
            </main>
            <?php if($noticiasSeg){?>
            <!--SECCION NOTICIAS GENERALES-->
                <section class="generales container-fluid">
                    <div class="noticiasGenerales notGenResponsive container-fluid">
                        <?php foreach ($noticiasSeg as $notiSegSec) {?>
                            <div class="noticiasGenerales__articulos container-fluid">
                                    <a class="noticiasGenerales__a" href="detalleNoticia.php?id=<?php echo $notiSegSec['id'];?>"><img class="noticiasGenerales__img" src="img/noticias/<?php echo ($notiSegSec['imagen']=='') ?  "notiBlankImg.png": $notiSegSec['imagen'];?>" alt="<?php echo $notiSegSec['titulo'];?>"></a>
                                    <a class="noticiasGenerales__a" href="detalleNoticia.php?id=<?php echo $notiSegSec['id'];?>"><h1 class="noticiasGenerales__h1"><?php echo $notiSegSec['titulo'];?></h1></a> 
                                </div>
                        <?php  }?>
                    </div>
                </section>
            <?php }?>
        </div> <!--CIERRE DIV ROW BOOTSTRAP-->
    </div><!--CIERRE DIV CONTAINER BOOTSTRAP-->
    
    <!-- Footer -->
    <?php require 'footer.php';?>
        <script src="libs/bootstrap/js/bootstrap.min.js"></script><!--BOOTSTRAP-->    
        </body>
</html>