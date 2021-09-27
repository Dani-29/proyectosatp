<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}

</style>



<?php include 'includes/header2.php'?>
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
                                            <div class="imagen">
                                                <img src="img/LOGO ISTPM.png" alt="" width="180" height="110">
                                            </div>
                                            <hr>
                                            <h1 class="h4 text-gray-900 mb-4">Iniciar Sesión</h1>
                                        </div>
                                        <form class="user" id="login-form" method="POST">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
												name="username" id="username"
                                                    placeholder="Ingrese su cédula">
                                            </div>
                                            <div class="form-group icono2">
                                                <input type="password" class="form-control form-control-user" 
												name="password" id="password"
                                                    placeholder="Ingrese su contraseña">
                                            </div>
                                            <a href="recuperar.php" class="small nav-link" style="text-align: right;">¿Has olvidado tu contraseña?</a>

                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customCheck">
                                                    <label class="custom-control-label"
                                                        for="customCheck">Recuérdame</label>
                                                </div>
                                            </div>
                                            <button class="btn btn-success btn-user btn-block" type="submit">
                                                Acceder
                                            </button>
                                        </form>
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


<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Iniciando sesión...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Nombre de usuario o contraseña incorrecta.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>