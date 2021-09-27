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
                                    <h6 class="h6 text-gray-800">Lista de docentes</h6>
                                    <span class="float:right"><a
                                            class="btn btn-primary btn-block btn-sm col-sm-2 float-right"
                                            href="javascript:void(0)" id="new_faculty">
                                            <i class="fa fa-plus"></i> Nuevo Docente
                                        </a></span>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-condensed table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                
                                                <th class="">Nombre</th>
                                                <th class="">Email</th>
                                                <th class="">Contacto</th>
                                                <th class="">Dirección</th>
                                                <th class="">Clave/Acceso</th>
                                                <th class="text-center">Operaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
								$i = 1;
								$faculty = $conn->query("SELECT * FROM faculty order by name desc ");
								while($row=$faculty->fetch_assoc()):
								?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                
                                                <td>
                                                    <p> <b><?php echo ucwords($row['name']) ?></b></p>
                                                </td>
                                                <td class="">
                                                    <p> <b><?php echo $row['email'] ?></b></p>
                                                </td>

                                                <td class="">
                                                    <p> <b><?php echo $row['contact'] ?></b></p>
                                                </td>
                                                <td class="">
                                                    <p><b><?php echo  $row['address'] ?></b></p>
                                                </td>
                                                <td>
                                                    <p> <b><?php echo $row['id_no'] ?></b></p>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success edit_faculty"
                                                        type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit" ></i>Editar</button>
                                                    <button class="btn btn-sm btn-danger delete_faculty"
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

$('#new_faculty').click(function() {
    uni_modal("Nuevo docente", "manage_faculty.php", "mid-large")

})

$('.view_payment').click(function() {
    uni_modal("facultys Payments", "view_payment.php?id=" + $(this).attr('data-id'), "large")

})
$('.edit_faculty').click(function() {
    uni_modal("Administrar los detalles del docente", "manage_faculty.php?id=" + $(this).attr('data-id'), "mid-large")

})
$('.delete_faculty').click(function() {
    _conf("¿Estás segur@ de eliminar esta docente?", "delete_faculty", [$(this).attr('data-id')])
})

function delete_faculty($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_faculty',
        method: 'POST',
        data: {
            id: $id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Datos eliminados correctamente", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)

            }
        }
    })
}
</script>