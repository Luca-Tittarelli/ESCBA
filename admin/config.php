<?php
//esta ruta es para ternerla siempre dispible para utilizar en los archivos ejemplo en el head cuando necesitamos la url
define('RUTA', 'http://localhost/ProyectoInstitucion/');


//creamos un array para utilizarlo en la conexion
$bd_config = array(
	'basedatos' => 'db_institucion',
	'usuario' => 'root',
	'pass' => ''
);


//otro array para el paginado y las imagenes seria la configuracion del blog
$admin_config = array(
	'usuario_por_pagina'=> '4',
	'colaboradores_por_pagina'=> '6',
	'carpeta_imagenes' => '../img/'
);



//--------------CONSTANTES ENVIOS DE CORREO-------------------
define('PROJECT_NAME', 'ESCBA');


define('IP_HOST', 'mail.nodosud.com.ar');
define('PORT_HOST', '25');
define('SMTP_USER', 'graficatres@nodosud.com.ar');
define('SMTP_PASS', 'leones');

define('SEND_EMAIL', 'gregorioboglione@gmail.com');
//define('SEND_EMAIL_CC1', 'gregorioboglione@gmail.com');
//define('SEND_EMAIL_CC2', 'gregorioboglione@gmail.com');

?>