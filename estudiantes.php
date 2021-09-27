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
                                    <h6 class="h6 text-gray-800">Lista de estudiantes</h6>
                                    <span class="float:right"><a
                                            class="btn btn-primary btn-block btn-sm col-sm-2 float-right"
                                            href="javascript:void(0)" id="new_student">
                                            <i class="fa fa-plus"></i> Nuevo Estudiante
                                        </a></span>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-condensed table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                
                                                <th class="">Nombre</th>
                                                <th class="">Apellidos</th>
                                                <th class="">Dirección</th>
                                                <th class="">Email</th>
                                                <th class="">Cédula</th>
                                                <th class="">Ciclo</th>
                                                <th class="text-center">Operaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
								$i = 1;
								//$student = $conn->query("SELECT s.*,concat(c.ciclo,' - ',c.horas) as `class` FROM students s inner join `class` c on c.id = s.class_id order by s.name desc ");
                                $student = $conn->query("SELECT s.*,concat(c.curso) as `class` FROM students s inner join `paralelos` c on c.id = s.class_id order by s.name desc ");
								while($row=$student->fetch_assoc()):
								?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                
                                                <td>
                                                    <p> <b><?php echo ucwords($row['name']) ?></b></p>
                                                </td>
                                                <td>
                                                    <p> <b><?php echo ucwords($row['apellidos']) ?></b></p>
                                                </td>
                                                <td>
                                                    <p> <b><?php echo ucwords($row['direccion']) ?></b></p>
                                                </td>
                                                <td>
                                                    <p> <b><?php echo ucwords($row['email']) ?></b></p>
                                                </td>
                                                <td>
                                                    <p> <b><?php echo $row['id_no'] ?></b></p>
                                                </td>
                                                <td class="">
                                                    <p> <b><?php echo $row['class'] ?></b></p>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success edit_student"
                                                        type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i>Editar</button>
                                                    <button class="btn btn-sm btn-danger delete_student"
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
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
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
$('#new_student').click(function() {
    uni_modal("Nuevo Estudiante", "manage_student.php", "")

})

$('.edit_student').click(function() {
    uni_modal("Administrar detalles del estudiante", "manage_student.php?id=" + $(this).attr('data-id'), "mid-large")

})
$('.delete_student').click(function() {
    _conf("¿Estás seguro de eliminar a este estudiante?", "delete_student", [$(this).attr('data-id')])
})

function delete_student($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_student',
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