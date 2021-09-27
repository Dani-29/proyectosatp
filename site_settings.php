<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * from system_settings limit 1");
if($qry->num_rows > 0){
	foreach($qry->fetch_array() as $k => $val){
		$meta[$k] = $val;
	}
}
 ?>
<div id="wrapper">
    <?php include 'includes/sidebar.php'?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include 'includes/navbar.php'; ?>
            <div class="container-fluid">

                <div class="card col-lg-12">
                    <div class="card-body">
                        <form action="" id="manage-settings">
                            <div class="form-group">
                                <label for="name" class="control-label">Nombre del sistema</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="contact" class="control-label">Contacto</label>
                                <input type="text" class="form-control" id="contact" name="contact"
                                    value="<?php echo isset($meta['contact']) ? $meta['contact'] : '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="about" class="control-label">Acerca del contenido</label>
                                <textarea name="about"
                                    class="text-jqte"><?php echo isset($meta['about_content']) ? $meta['about_content'] : '' ?></textarea>

                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Imagen</label>
                                <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
                            </div>
                            <div class="form-group">
                                <img src="<?php echo isset($meta['cover_img']) ? 'assets/uploads/'.$meta['cover_img'] :'' ?>"
                                    alt="" id="cimg">
                            </div>
                            <center>
                                <button class="btn btn-info btn-primary btn-block col-md-2"><i class="fa fa-save"></i>
                                    Guardar</button>
                            </center>
                        </form>
                    </div>
                </div>
                <style>
                img#cimg {
                    max-height: 10vh;
                    max-width: 6vw;
                }
                </style>

                <script>
                function displayImg(input, _this) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#cimg').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $('.text-jqte').jqte();

                $('#manage-settings').submit(function(e) {
                    e.preventDefault()
                    start_load()
                    $.ajax({
                        url: 'ajax.php?action=save_settings',
                        data: new FormData($(this)[0]),
                        cache: false,
                        contentType: false,
                        processData: false,
                        method: 'POST',
                        type: 'POST',
                        error: err => {
                            console.log(err)
                        },
                        success: function(resp) {
                            if (resp == 1) {
                                alert_toast('Datos guardados con éxito.', 'success')
                                setTimeout(function() {
                                    location.reload()
                                }, 1000)
                            }
                        }
                    })

                })
                </script>
                <style>

                </style>
            </div>
        </div>
    </div>
</div>