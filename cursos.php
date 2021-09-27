<?php include('db_connect.php');?>

<div id="wrapper">

    <?php include 'includes/sidebar.php'?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include 'includes/navbar.php'; ?>
            <div class="container-fluid">

                <div class="col-lg-12">
                    <div class="row mb-4 mt-4">
                        <div class="col-md-12">

                        </div>
                    </div>
                    <div class="row">
                        <!-- FORM Panel -->

                        <!-- Table Panel -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="h6 text-gray-800">Lista de cursos</h6>
                                    <span class="float:right"><a
                                            class="btn btn-primary btn-block btn-sm col-sm-2 float-right"
                                            href="javascript:void(0)" id="new_curso">
                                            <i class="fa fa-plus"></i> Nuevo Curso
                                        </a></span>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-condensed table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                
                                                <th class="">Curso</th>
                                                <th class="text-center">Operaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
								$i = 1;
								$paralelos = $conn->query("SELECT * FROM paralelos order by curso desc ");
								while($row=$paralelos->fetch_assoc()):
								?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                
                                               
                                                <td>
                                                    <p> <b><?php echo ucwords($row['curso']) ?></b></p>
                                                </td>
                                               
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success edit_curso"
                                                        type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit" ></i>Editar</button>
                                                    <button class="btn btn-sm btn-danger delete_curso"
                                                        type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i>Eliminar</button>
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
    margin: unset
}

img {
    max-width: 100px;
    max-height: 150px;
}
</style>
<script>
$(document).ready(function() {
    $('table').dataTable()
})

$('#new_curso').click(function() {
    uni_modal("Nuevo curso", "manage_curso.php", "mid-large")

})

$('.edit_curso').click(function() {
    uni_modal("Editar curso", "manage_curso.php?id=" + $(this).attr('data-id'), "mid-large")

})
$('.delete_curso').click(function() {
    _conf("¿Estás seguro de eliminar este curso", "delete_curso", [$(this).attr('data-id')])
})

function delete_curso($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_curso',
        method: 'POST',
        data: {
            id: $id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Curso eliminado correctamente", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)

            }
        }
    })
}
</script>