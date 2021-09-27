<?php include 'includes/header2.php'?>
<?php 
include('./db_connect.php');

$email = $_POST['email'];
$c = "SELECT id, IFNULL( name, 'usuario' ) as NOMBRE FROM faculty WHERE EMAIL='$email' LIMIT 1";
//$c = "SELECT id_no, name FROM faculty WHERE EMAIL='$email' LIMIT 1";
$f = mysqli_query( $conn , $c );
$a = mysqli_fetch_assoc($f);
//var_dump($a);
if( ! $a ){
    $_SESSION['error'] = 'El usuario no existe';
    header( "Location: ./recuperar.php" );
    die( );
}

//generar clave aleatoria
$clave_nueva = rand( 10000000, 99999999 );
$idusuario = $a['id'];

$c2 = "UPDATE faculty set id_no = '$clave_nueva' where id = '$idusuario' LIMIT 1";
$c3 = "UPDATE users set password = md5('$clave_nueva') where faculty_id = $idusuario";
mysqli_query($conn, $c2);
mysqli_query($conn, $c3);


$mensaje = <<<EMAIL
<body>
    <section id="containerLogin">


        <div class="container">
            <div class="row justify-content-center">

                <div class="col-xl-5 col-lg-8 col-md-8">

                    <div class="card o-hidden border-0 shadow-lg my-3">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                        <p>Hola $a[NOMBRE]</p>
                                        <p> Has solicitado recuperar tu contraseña, el sistema te ha generado
                                        una nueva clave que es: <code style="background: lightyellow; color: darkred; padding: 1px 2px">$clave_nueva</code></p>
                                        </div>
                                        <a href="login.php" class="small nav-link" style="text-align: right;">Ir a login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </section>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://kit.fontawesome.com/597588b810.js" crossorigin="anonymous"></script>
</body>
EMAIL;
echo $mensaje;
// //generar una clave aleatoria y el token

// $token = md5( $a['ID'] . time( ) . rand( 1000, 9999 ) );
// $clave_nueva = rand( 10000000, 99999999 );
// $idusuario = $a['ID'];

// $c2 = "INSERT INTO recuperar SET EMAIL='$email', TOKEN='$token', FECHA_ALTA=NOW( ), CLAVE_NUEVA='$clave_nueva' ON DUPLICATE KEY UPDATE TOKEN='$token', CLAVE_NUEVA='$clave_nueva'";
// mysqli_query($cnx, $c2);

// $link = "http://localhost/recuperarclave/forms/recuperar_clave_confirmar.php?e=$email&t=$token";

// //envío de mail
// $mensaje = <<<EMAIL
// <p>Hola $a[NOMBRE]</p>
// <p>Has solicitado recuperar tu contraseña, el sistema te ha generado una nueva clave que es: <code style='background: lightyellow; color: darkred; padding: 1px 2px;'>$clave_nueva</code></p>
// <p>Pero antes de poder usarla, deberás hacer <a href='$link'>click en este vínculo</a> o copiar este código en la URL de tu navegador</p>
// <code style='background: black; color: white; padding: 4px;'>$link</code>
// <p>Si tu no has hecho esta solicitud, ingora el presente mensaje</p>
// EMAIL;

// echo $mensaje;

//enviar ese mail 
//redireccionar al formulario....




?>