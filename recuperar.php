<?php include 'includes/header2.php'?>
<style>
    .ok,
.error,
.info,
.message,
.warning {
    background: 12px center no-repeat;
    padding: 20px 12px 20px 50px;
    color: white;
    font: 13px/16px Arial;
    border-radius: 3px;
    margin: 10px 30px;
    box-shadow: 0 0 6px rgba(0, 0, 0, .3);
}
.info {
    background-color: #6BC6E1;
    background-image: url(css/icons/ui-info.jpg);
}
.message {
    background-color: #646262;
    padding-left: 20px
}
.error {
    background-color: #DC6460;
    background-image: url(css/icons/ui-error.jpg);
}


</style>

<body>
<?php 
if( isset( $_SESSION['error'] ) ){
	$class = 'error';
	$mensaje = $_SESSION['error'];
	unset( $_SESSION['error'] );
}else if( isset( $_SESSION['rta'] ) ){
	$class = 'ok';
	$mensaje = $_SESSION['rta'];
}else{
	$class = 'info';
	$mensaje = 'Ingrese su correo para recuperar su contraseña';
}
?>
    <section id="containerLogin">


        <div class="container">
            <div class="row justify-content-center">

                <div class="col-xl-5 col-lg-8 col-md-8">
                <p class="<?php echo $class; ?>"><?php echo $mensaje; ?></p>
                    <div class="card o-hidden border-0 shadow-lg my-3">
                        <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="text-center">
                                                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                                                        <h2 class="text-center">¿Has olvidado tu contraseña?</h2>
                                                        <p>Puede restablecer su contraseña aquí.</p>
                                                        <div class="panel-body">
                                                            <form method="post" action="recuperar_clave.php">
                                                                <fieldset>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                                            <input id="emailInput"
                                                                                placeholder="dirección de correo electrónico"
                                                                                class="form-control" type="email" name="email"
                                                                                oninvalid="setCustomValidity('¡Por favor, introduce una dirección de correo electrónico válida!')"
                                                                                onchange="try{setCustomValidity('')}catch(e){}"
                                                                                required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input class="btn btn-lg btn-primary btn-block"
                                                                            value="Recuperar" type="submit">
                                                                    </div>
                                                                </fieldset>
                                                            </form>
                                                            <a href="login.php" style="text-align: right;">Cancelar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>

                </div>

            </div>


        </div>
    </section>

    
</body>