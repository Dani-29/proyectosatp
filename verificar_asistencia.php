<?php include 'db_connect.php' ?>

<div id="wrapper">

    <?php include 'includes/sidebar.php'?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include 'includes/navbar.php'; ?>
            <div class="container-fluid">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Verificar asistencia</h6></div>
                        
                        <div class="card-body">
                            <form id="manage-attendance">
                                <input type="hidden" name="id" value="">
                                <div class="row justify-content-center">
                                    <label for="" class="mt-2">Ciclo por asignaturas</label>
                                    <div class="col-sm-4">
                                        <select name="class_subject_id" id="class_subject_id"
                                            class="custom-select select2 input-sm">
                                            <option value=""></option>
                                            <?php
				                //$class = $conn->query("SELECT cs.*,concat(c.ciclo,' - ',c.horas) as `class`,s.subject,f.name as fname FROM class_subject cs inner join `class` c on c.id = cs.class_id inner join faculty f on f.id = cs.faculty_id inner join subjects s on s.id = cs.subject_id ".($_SESSION['login_faculty_id'] ? " where f.id = {$_SESSION['login_faculty_id']} ":"")." order by concat(c.ciclo,' - ',c.horas) asc");
                                $class = $conn->query("SELECT cs.*,concat(c.curso) as `class`,ci.ciclo,s.subject,f.name as fname FROM class_subject cs inner join `paralelos` c on c.id = cs.class_id inner join faculty f on f.id = cs.faculty_id inner join class ci on ci.id = cs.ciclo_id inner join subjects s on s.id = cs.subject_id ".($_SESSION['login_faculty_id'] ? " where f.id = {$_SESSION['login_faculty_id']} ":"")." order by concat(c.curso) asc");
				                while($row=$class->fetch_assoc()):
				                ?>
                                            <option value="<?php echo $row['id'] ?>" data-cid="<?php echo $row['id'] ?>"
                                                <?php echo isset($class_subject_id) && $class_subject_id == $row['id'] ? 'selected' : '' ?>>
                                                <?php echo $row['class'].'-'.$row['subject']. ' [ '.$row['fname'].' ]' ?>
                                            </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="date" name="doc" id="doc" value="<?php echo date('Y-m-d') ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn  btn-primary" type="button" id="filter">Buscar</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12" id='att-list'>
                                        <center><b>
                                                <h4><i>Seleccione el curso primero.</i></h4>
                                            </b></center>
                                    </div>
                                    <div class="col-md-12" style="display: none" id="submit-btn-field">
                                        <center>
                                            <button class="btn btn-primary btn-sm col-sm-3" type="button"
                                                id="edit_att"><i class="fa fa-edit" data-id=''></i> Editar</button>
                                            <button class="btn btn-success btn-sm col-sm-3" type="button"
                                                id="print_att"><i class="fa fa-print"></i> Descargar</button>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
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
<div id="table_clone" style="display: none">
    <table width="100%">
        <tr>
            <td width="50%">
                <p>Ciclo: <b class="ciclo"></b></p>
                <p>Curso: <b class="curso"></b></p>
                <p>Asignatura: <b class="subject"></b></p>
                
            </td>
            <td width="50%">
                <p>Docente: <b class="name"></b></p>
                <p>Fecha de la clase: <b class="doc"></b></p>
            </td>
        </tr>
    </table>
    <table class='table table-bordered table-hover att-list'>
        <thead>
            <tr>
                <th class="text-center" width="5%">#</th>
                <th width="20%">Estudiante</th>
                <th>Asistencia</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div id="chk_clone" style="display: none">
    <div class="d-flex justify-content-center chk-opts">
        <div class="form-check form-check-inline">
            <input class="form-check-input presente-inp" type="checkbox" value="1" readonly="">
            <label class="form-check-label presente-lbl">Presente</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input justificado-inp" type="checkbox" value="0" readonly="">
            <label class="form-check-label justificado-lbl">Justificado</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input falta-inp" type="checkbox" value="2" readonly="">
            <label class="form-check-label falta-lbl">Falta</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input vacacion-inp" type="checkbox" value="3" readonly="">
            <label class="form-check-label vacacion-lbl">Vacacion</label>
        </div>
    </div>
</div>
<style>
.presente-inp,
.justificado-inp,
.falta-inp,
.vacacion-inp,
.presente-lbl,
.justificado-lbl,
.falta-lbl,
.vacacion-lbl {
    cursor: pointer;
}
</style>
<noscript>
    <style>
    table.att-list {
        width: 100%;
        border-collapse: collapse
    }

    table.att-list td,
    table.att-list th {
        border: 1px solid
    }

    .text-center {
        text-align: center
    }
    </style>
</noscript>
<script>
$('#filter').click(function() {
    start_load()
    $.ajax({
        url: 'ajax.php?action=get_att_record',
        method: 'POST',
        data: {
            class_subject_id: $('#class_subject_id').val(),
            doc: $('#doc').val()
        },
        success: function(resp) {
            if (resp) {
                resp = JSON.parse(resp)
                var _table = $('#table_clone').clone()
                $('#att-list').html('')
                $('#att-list').append(_table)
                var _type = ['Justificado', 'Presente', 'Falta', 'Vacacion'];
                var data = !!resp.data ? resp.data : [];
                var record = !!resp.record ? resp.record : [];
                var attendance_id = !!resp.attendance_id ? resp.attendance_id : '';
                if (Object.keys(data).length > 0) {
                    var i = 1;
                    Object.keys(data).map(function(k) {
                        var name = data[k].name;
                        var id = data[k].id;
                        var tr = $('<tr></tr>')


                        tr.append('<td class="text-center">' + (i++) + '</td>')
                        tr.append('<td class="">' + (name) + '</td>')
                        var td = '<td>';
                        td += '<input type="hidden" name="student_id[' + id + ']" value="' +
                            id + '">';
                        td += !!record[k].type ? _type[record[k].type] : '';
                        td += '</td>';
                        tr.append(td)

                        _table.find('table.att-list tbody').append(tr)
                    })
                    $('#submit-btn-field').show()
                    $('#edit_att').attr('data-id', attendance_id)
                } else {
                    var tr = $('<tr></tr>')
                    tr.append('<td class="text-center" colspan="3">Sin datos.</td>')
                    _table.find('table.att-list tbody').append(tr)
                    $('#submit-btn-field').attr('data-id', '').hide()
                    $('#edit_att').attr('data-id', '')
                }
                $('#att-list').html('')
                _table.find('.ciclo').text(!!resp.details.ciclo ? resp.details.ciclo : '')
                _table.find('.curso').text(!!resp.details.curso ? resp.details.curso : '')
                _table.find('.subject').text(!!resp.details.subject ? resp.details.subject : '')
                _table.find('.name').text(!!resp.details.name ? resp.details.name : '')
                _table.find('.doc').text(!!resp.details.doc ? resp.details.doc : '')
                $('#att-list').append(_table.html())
                if (Object.keys(record).length > 0) {
                    Object.keys(record).map(k => {
                        // console.log('[name="type['+record[k].student_id+']"][value="'+record[k].type+'"]')
                        $('#att-list').find('[name="type[' + record[k].student_id +
                            ']"][value="' + record[k].type + '"]').prop('checked', true)
                    })
                }
            }
        },
        complete: function() {
            $("input[readonly]").on('keyup keypress change', function(e) {
                e.preventDefault()
                return false;
            });
            $('#edit_att').click(function() {
                location.href = 'index.php?page=asistencia&attendance_id=' + $(this)
                    .attr('data-id')
            })
            end_load()
        }
    })
})
$('#manage-attendance').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_attendance',
        method: 'POST',
        data: $(this).serialize(),
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Datos guardados correctamente.", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1000)
            } else if (resp == 2) {
                alert_toast(
                    "La clase ya tiene un registro de asistencia con el tema y la fecha seleccionados.",
                    'danger')
                end_load();
            }
        }
    })
})
$('#print_att').click(function() {
    var _c = $('#att-list').html();
    var ns = $('noscript').clone();
    var nw = window.open('', '_blank', 'width=900,height=600')
    nw.document.write("<h3 style='text-align: center;'>INSTITUTO SUPERIOR TECNOLÓGICO PRIMERO DE MAYO</h3>");
    nw.document.write("<h4 class='small' style='text-align: center;'><i>Yantzaza-Zamora-Chinchipe</i></h4>");
    nw.document.write("<h3 style='text-align: center;'>REGISTRO DE ASISTENCIA</h3>");
    nw.document.write(_c)
    nw.document.write(ns.html())
    nw.document.close()
    nw.print()
    setTimeout(() => {
        nw.close()
    }, 500);
})
</script>