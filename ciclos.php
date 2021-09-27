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
                            <form action="" id="manage-class">
                                <div class="card">
                                    <div class="card-header">
                                        Formulario de Ciclos
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="id">
                                        <div id="msg"></div>
                                        
                                        <div class="form-group">
                                            <label class="control-label">Ciclo</label>
                                            <input type="text" class="form-control" name="ciclo">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Horas</label>
                                            <input type="number" class="form-control" name="horas">
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-sm btn-primary col-sm-4 offset-md-3"><i class="fa fa-save"></i>
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
                                <h6 class="h6 mb-2 text-gray-800">Lista de ciclos</h6>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                
                                                <th class="text-center">Ciclo</th>
                                                <th class="text-center">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
								$i = 1;
								
								$class = $conn->query("SELECT *,concat(ciclo,' - ',horas,'h') as `class` FROM `class`  order by concat(ciclo,' ',horas) asc");
								while($row=$class->fetch_assoc()):
								?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                <td class="">
                                                    <p><b><?php echo $row['class'] ?></b></p>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success edit_class" type="button"
                                                        data-id="<?php echo $row['id'] ?>"
                                                        data-ciclo="<?php echo $row['ciclo'] ?>"
                                                        data-horas="<?php echo $row['horas'] ?>">
                                                        <i class="fa fa-edit"></i>Editar</button>
                                                    <button class="btn btn-sm btn-danger delete_class" type="button"
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
<script src="js/sb-admin-2.min.js"></script>

<style>
td {
    vertical-align: middle !important;
}

td p {
    margin: unset;
}
</style>
<script>
$('#manage-class').on('reset', function() {
    $('#msg').html('')
    $('input:hidden').val('')
    $('.select2').val('').trigger('change')
})
$('#manage-class').submit(function(e) {
    e.preventDefault()
    $('#msg').html('')
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_class',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Datos guardados correctamente", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)

            } else if (resp == 2) {
                $('#msg').html('<div class="alert alert-danger mx-2">El ciclo ya existe.</div>')
                end_load()
            }
        }
    })
})
$('.edit_class').click(function() {
    start_load()
    var cat = $('#manage-class')
    cat.get(0).reset()
    cat.find("[name='id']").val($(this).attr('data-id'))
    cat.find("[name='ciclo']").val($(this).attr('data-ciclo'))
    cat.find("[name='horas']").val($(this).attr('data-horas'))
    end_load()
})
$('.delete_class').click(function() {
    _conf("¿Estás segura de eliminar este ciclo?", "delete_class", [$(this).attr('data-id')])
})

function delete_class($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_class',
        method: 'POST',
        data: {
            id: $id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Ciclo eliminado correctamente", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)

            }
        }
    })
}
$('table').dataTable()
</script>