<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM class_subject where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage-class_subject">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class="form-group"></div>
        <div class="form-group">
            <label for="" class="control-label">Ciclo</label>
            <select name="ciclo_id" id="" class="custom-select select2">
                <option value=""></option>
                <?php
                $class = $conn->query("SELECT * FROM class order by ciclo asc");
                while($row=$class->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($ciclo_id) && $ciclo_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['ciclo']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>        
        <div class="form-group">
            <label for="" class="control-label">Curso</label>
            <select name="class_id" id="" class="custom-select select2">
                <option value=""></option>
                <?php
                //$class = $conn->query("SELECT *,concat(ciclo,' - ',horas,'h') as `class` FROM `class` order by concat(ciclo,'- ',horas) asc");
                $class = $conn->query("SELECT *,concat(curso) as `class` FROM `paralelos` order by concat(curso) asc");
                while($row=$class->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($class_id) && $class_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Docente</label>
            <select name="faculty_id" id="" class="custom-select select2">
                <option value=""></option>
                <?php
                $class = $conn->query("SELECT * FROM faculty order by name asc");
                while($row=$class->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($faculty_id) && $faculty_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Asignatura</label>
            <select name="subject_id" id="" class="custom-select select2">
                <option value=""></option>
                <?php
                $class = $conn->query("SELECT * FROM subjects order by subject asc");
                while($row=$class->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($subject_id) && $subject_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['subject']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-success btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
        </div>
    </form>
</div>
<script>
    $('#manage-class_subject').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#manage-class_subject').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url:'ajax.php?action=save_class_subject',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                    alert_toast("Datos guardados con éxito.",'success')
                        setTimeout(function(){
                            location.reload()
                        },1000)
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">Los datos ya existen.</div>')
                end_load()
                }   
            }
        })
    })
    $('.select2').select2({
        placeholder:"Por favor seleccione aqui",
        width:'100%'
    })
</script>