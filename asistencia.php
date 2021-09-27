<?php include 'db_connect.php' ?>
<?php

if(isset($_GET['attendance_id'])){
	// echo "SELECT * FROM attendance_list where id = {$_GET['attendance_id']}";
$qry = $conn->query("SELECT * FROM attendance_list where id = {$_GET['attendance_id']}");
foreach($qry->fetch_array() as $k => $v){
	$$k = $v;
}
}

?>
<div id="wrapper">

    <?php include 'includes/sidebar.php'?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include 'includes/navbar.php'; ?>
            <div class="container-fluid">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Registrar asistencia</h6></div>
                        <div class="card-body">
                            <form id="manage-attendance">
                                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                                <div class="row justify-content-center">
                                    <label for="" class="mt-2">Ciclos por asignaturas</label>
                                    <div class="col-sm-4">
                                        <select name="class_subject_id" id="class_subject_id"
                                            class="custom-select select2 input-sm">
                                            <option value=""></option>
                                            <?php
				                //$class = $conn->query("SELECT cs.*,concat(c.ciclo,' - ',c.horas) as `class`,s.subject,f.name as fname FROM class_subject cs inner join `class` c on c.id = cs.class_id inner join faculty f on f.id = cs.faculty_id inner join subjects s on s.id = cs.subject_id ".($_SESSION['login_faculty_id'] ? " where f.id = {$_SESSION['login_faculty_id']} ":"")." order by concat(c.ciclo,' - ',c.horas) asc");
                                $class = $conn->query("SELECT cs.*,concat(c.curso) as `class`,s.subject,f.name as fname FROM class_subject cs inner join `paralelos` c on c.id = cs.class_id inner join faculty f on f.id = cs.faculty_id inner join subjects s on s.id = cs.subject_id ".($_SESSION['login_faculty_id'] ? " where f.id = {$_SESSION['login_faculty_id']} ":"")." order by concat(c.curso) asc");
				                while($row=$class->fetch_assoc()):
				                ?>
                                            <option value="<?php echo $row['id'] ?>" data-cid="<?php echo $row['id'] ?>"
                                                <?php echo isset($class_subject_id) && $class_subject_id == $row['id'] ? 'selected' : (isset($class_subject_id) && $class_subject_id == $row['id'] ? 'selected' :'') ?>>
                                                <?php echo $row['class'].' '.$row['subject']. ' [ '.$row['fname'].' ]' ?>
                                            </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="date" name="doc"
                                            value="<?php echo isset($doc) ? date('Y-m-d',strtotime($doc)) :date('Y-m-d') ?>"
                                            class="form-control">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12" id='att-list'>
                                        <center><b>
                                                <h4><i>Primero seleccione el curso.</i></h4>
                                            </b></center>
                                    </div>
                                    <div class="col-md-12" style="display: none" id="submit-btn-field">
                                        <center>
                                            <button class="btn btn-primary btn-sm col-sm-5"><i class="fa fa-save"></i> Guardar</button>
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
<div id="table_clone" style="display: none" class="table-responsive">
    <table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th>#</th>
                <th>Estudiante</th>
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
            <input class="form-check-input presente-inp" type="radio" value="1">
            <label class="form-check-label presente-lbl">Presente</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input justificado-inp" type="radio" value="0">
            <label class="form-check-label justificado-lbl">Justificado</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input falta-inp" type="radio" value="2">
            <label class="form-check-label falta-lbl">Falta</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input vacacion-inp" type="radio" value="3">
            <label class="form-check-label vacacion-lbl">Vacación</label>
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
<script>
$(document).ready(function() {
    if ('<?php echo isset($class_subject_id) ? 1 : 0 ?>' == 1) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=get_class_list',
            method: 'POST',
            data: {
                class_subject_id: $('#class_subject_id').val(),
                doc: $('#doc').val(),
                att_id: '<?php echo isset($id) ? $id : '' ?>'
            },
            success: function(resp) {
                if (resp) {
                    resp = JSON.parse(resp)
                    var _table = $('#table_clone table').clone()
                    $('#att-list').html('')
                    $('#att-list').append(_table)
                    var _type = ['Justificado', 'Presente', 'Falta', 'Vacacion'];
                    var data = resp.data;
                    var record = resp.record;
                    var attendance_id = !!resp.attendance_id ? resp.attendance_id : '';
                    if (Object.keys(data).length > 0) {
                        var i = 1;
                        Object.keys(data).map(function(k) {
                            var name = data[k].name;
                            var id = data[k].id;
                            var tr = $('<tr></tr>')
                            var opts = $('#chk_clone').clone()

                            opts.find('.presente-inp').attr({
                                'name': 'type[' + id + ']',
                                'id': 'presente_' + id
                            })
                            opts.find('.justificado-inp').attr({
                                'name': 'type[' + id + ']',
                                'id': 'justificado_' + id
                            })
                            opts.find('.falta-inp').attr({
                                'name': 'type[' + id + ']',
                                'id': 'falta_' + id
                            })
                            opts.find('.vacacion-inp').attr({
                                'name': 'type[' + id + ']',
                                'id': 'vacacion_' + id
                            })

                            opts.find('.presente-lbl').attr({
                                'for': 'presente_' + id
                            })
                            opts.find('.justificado-lbl').attr({
                                'for': 'justificado_' + id
                            })
                            opts.find('.falta-lbl').attr({
                                'for': 'falta_' + id
                            })
                            opts.find('.vacacion-lbl').attr({
                                'for': 'vacacion_' + id
                            })

                            tr.append('<td class="text-center">' + (i++) + '</td>')
                            tr.append('<td class="">' + (name) + '</td>')
                            var td = '<td>';
                            td += '<input type="hidden" name="student_id[' + id +
                                ']" value="' + id + '">';
                            td += opts.html();
                            td += '</td>';
                            tr.append(td)

                            _table.find('tbody').append(tr)
                        })
                        $('#submit-btn-field').show()
                        $('#edit_att').attr('data-id', attendance_id)
                    } else {
                        var tr = $('<tr></tr>')
                        tr.append('<td class="text-center" colspan="3">Sin datos.</td>')
                        _table.find('tbody').append(tr)
                        $('#submit-btn-field').attr('data-id', '').hide()
                        $('#edit_att').attr('data-id', '')
                    }
                    $('#att-list').html('')
                    $('#att-list').append(_table)
                    if (Object.keys(record).length > 0) {
                        Object.keys(record).map(k => {
                            // console.log('[name="type['+record[k].student_id+']"][value="'+record[k].type+'"]')
                            $('#att-list').find('[name="type[' + record[k].student_id +
                                ']"][value="' + record[k].type + '"]').prop(
                                'checked', true)
                        })
                    }
                }
            },
            complete: function() {
                $("input:radio").on('keyup keypress change', function() {
                    var group = "input:radio[name='" + $(this).attr("name") + "']";
                    $(group).prop("checked", false);
                    $(this).prop("checked", true);
                });
                $('#edit_att').click(function() {
                    location.href = 'index.php?page=asistencia&attendance_id=' +
                        $(this).attr('data-id')
                })
                end_load()
            }
        })
    }

})
$('#class_subject_id').change(function() {
    get_data($(this).val())
})
window.get_data = function(id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=get_class_list',
        method: 'POST',
        data: {
            class_subject_id: id
        },
        success: function(resp) {
            if (resp) {
                resp = JSON.parse(resp)
                var _table = $('#table_clone table').clone()
                $('#att-list').html('')
                $('#att-list').append(_table)
                if (Object.keys(resp).length > 0) {
                    var i = 1;
                    Object.keys(resp.data).map(function(k) {
                        var name = resp.data[k].name;
                        var id = resp.data[k].id;
                        var tr = $('<tr></tr>')
                        var opts = $('#chk_clone').clone()
                        opts.find('.presente-inp').attr({
                            'name': 'type[' + id + ']',
                            'id': 'presente_' + id
                        })
                        opts.find('.justificado-inp').attr({
                            'name': 'type[' + id + ']',
                            'id': 'justificado_' + id
                        })
                        opts.find('.falta-inp').attr({
                            'name': 'type[' + id + ']',
                            'id': 'falta_' + id
                        })
                        opts.find('.vacacion-inp').attr({
                            'name': 'type[' + id + ']',
                            'id': 'vacacion_' + id
                        })

                        opts.find('.presente-lbl').attr({
                            'for': 'presente_' + id
                        })
                        opts.find('.justificado-lbl').attr({
                            'for': 'justificado_' + id
                        })
                        opts.find('.falta-lbl').attr({
                            'for': 'falta_' + id
                        })
                        opts.find('.vacacion-lbl').attr({
                            'for': 'vacacion_' + id
                        })

                        tr.append('<td class="text-center">' + (i++) + '</td>')
                        tr.append('<td class="">' + (name) + '</td>')
                        var td = '<td>';
                        td += '<input type="hidden" name="student_id[' + id + ']" value="' +
                            id + '">';
                        td += opts.html();
                        td += '</td>';
                        tr.append(td)

                        _table.find('tbody').append(tr)
                    })
                    $('#submit-btn-field').show()
                } else {
                    var tr = $('<tr></tr>')
                    tr.append('<td class="text-center" colspan="3">Sin datos.</td>')
                    _table.find('tbody').append(tr)
                    $('#submit-btn-field').hide()
                }
                $('#att-list').html('')
                $('#att-list').append(_table)
            }
        },
        complete: function() {
            $("input:radio").on('keyup keypress change', function() {
                // console.log(test)
                var group = "input:radio[name='" + $(this).attr("name") + "']";
                $(group).prop("checked", false);
                $(this).prop("checked", true);
            });
            end_load()
        }
    })
}
$('#manage-attendance').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_attendance',
        method: 'POST',
        data: $(this).serialize(),
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Datos guardados con éxito.", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1000)
            } else if (resp == 2) {
                alert_toast(
                    "La asignatura ya tiene un registro de asistencia con el ciclo y la fecha seleccionados.",
                    'danger')
                end_load();
            }
        }
    })
})
</script>