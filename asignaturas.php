<?php include('db_connect.php');?>


<div id="wrapper">

    <?php include 'includes/sidebar.php'?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include 'includes/navbar.php'; ?>
            <div class="container-fluid">

                <div class="col-lg-12">
                    <div class="row">
                        <!-- FORM Panel -->
                        <div class="col-md-4">
                            <form action="" id="manage-subject">
                                <div class="card">
                                    <div class="card-header">
                                        Formulario de asignaturas
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="id">
                                        <div id="msg"></div>
                                        <div class="form-group">
                                            <label class="control-label">Asignatura</label>
                                            <input type="text" class="form-control" name="subject">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Descripción</label>
                                            <textarea name="description" id="" cols="30" rows="4"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-sm btn-primary col-sm- offset-md-3"><i class="fa fa-save"></i>
                                                    Guardar</button>
                                                <button class="btn btn-sm btn-default col-sm-4" type="reset">
                                                    Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- FORM Panel -->

                        <!-- Table Panel -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h1 class="h6 mb-2 text-gray-800">Lista de asignaturas</h1>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Asignatura</th>
                                                <th class="text-center">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
								$i = 1;
								$subject = $conn->query("SELECT * FROM subjects order by id asc");
								while($row=$subject->fetch_assoc()):
								?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                <td class="">
                                                    <p><b><?php echo ucwords($row['subject']) ?></b></p>
                                                    <small><i><?php echo $row['description'] ?></i></small>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success edit_subject" type="button"
                                                        data-id="<?php echo $row['id'] ?>"
                                                        data-subject="<?php echo $row['subject'] ?>"
                                                        data-description="<?php echo $row['description'] ?>"><i class="fa fa-edit" ></i>Editar</button>
                                                    <button class="btn btn-sm btn-danger delete_subject" type="button"
                                                        data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i>Eliminar</button>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Table Panel -->
                    </div>
                </div>

            </div>
        </div>
        <?php include 'includes/footer.php'?>
    </div>
</div>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="vendor/chart.js/Chart.min.js"></script>
<style>
td {
    vertical-align: middle !important;
}

td p {
    margin: unset;
}
</style>
<script>
$('#manage-subject').on('reset', function() {
    $('#msg').html('')
    $('input:hidden').val('')
})
$('#manage-subject').submit(function(e) {
    e.preventDefault()
    $('#msg').html('')
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_subject',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Datos guardados con éxito", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)

            } else if (resp == 2) {
                $('#msg').html('<div class="alert alert-danger mx-2">Subject already exist.</div>')
                end_load()
            }
        }
    })
})
$('.edit_subject').click(function() {
    start_load()
    var cat = $('#manage-subject')
    cat.get(0).reset()
    cat.find("[name='id']").val($(this).attr('data-id'))
    cat.find("[name='subject']").val($(this).attr('data-subject'))
    cat.find("[name='description']").val($(this).attr('data-description'))
    end_load()
})
$('.delete_subject').click(function() {
    _conf("¿Estás seguro de eliminar esta asignatura?", "delete_subject", [$(this).attr('data-id')])
})

function delete_subject($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_subject',
        method: 'POST',
        data: {
            id: $id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Data successfully deleted", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)

            }
        }
    })
}
$('table').dataTable()
</script>