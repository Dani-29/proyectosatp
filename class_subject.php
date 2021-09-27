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
                                    <h6 class="h6 text-gray-800">Lista de ciclos por asignatura</h6>
                                    <span class="float:right"><a
                                            class="btn btn-primary btn-block btn-sm col-sm-2 float-right"
                                            href="javascript:void(0)" id="new_class_subject">
                                            <i class="fa fa-plus"></i>Nuevo
                                        </a></span>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-condensed table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="">Ciclo</th>
                                                <th class="">Curso</th>
                                                <th class="">Asignatura</th>
                                                <th class="">Docente</th>
                                                <th class="text-center">Operaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
								$i = 1;
								//$class_subject = $conn->query("SELECT cs.*,concat(c.ciclo,' - ',c.horas) as `class`,s.subject,f.name as fname FROM class_subject cs inner join `class` c on c.id = cs.class_id inner join faculty f on f.id = cs.faculty_id inner join subjects s on s.id = cs.subject_id order by concat(c.ciclo,' ',c.horas) asc");
                                $class_subject = $conn->query("SELECT cs.*,concat(c.curso) as `class`, ci.ciclo, s.subject,f.name as fname FROM class_subject cs inner join `paralelos` c on c.id = cs.class_id inner join faculty f on f.id = cs.faculty_id inner join class ci on ci.id = cs.ciclo_id  inner join subjects s on s.id = cs.subject_id order by concat(c.curso) asc");
								while($row=$class_subject->fetch_assoc()):
								?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                <td class="">
                                                    <p> <b><?php echo $row['ciclo'] ?></b></p>
                                                </td>
                                                <td>
                                                    <p> <b><?php echo $row['class'] ?></b></p>
                                                </td>
                                                <td class="">
                                                    <p> <b><?php echo $row['subject'] ?></b></p>
                                                </td>
                                                <td class="">
                                                    <p> <b><?php echo $row['fname'] ?></b></p>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success edit_class_subject"
                                                        type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i>Editar</button>
                                                    <button class="btn btn-sm btn-danger delete_class_subject"
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
$('#new_class_subject').click(function() {
    uni_modal("Nuevo", "manage_class_subject.php", "")

})

$('.edit_class_subject').click(function() {
    uni_modal("Editar", "manage_class_subject.php?id=" + $(this).attr('data-id'), "")

})
$('.delete_class_subject').click(function() {
    _conf("¿Está seguro de eliminar?", "delete_class_subject", [$(this).attr('data-id')])
})

function delete_class_subject($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_class_subject',
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