<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM students where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage-student">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class="form-group"></div>
        <div class="form-group">
            <label for="" class="control-label">Nombre</label>
            <input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Apellidos</label>
            <input type="text" class="form-control" name="apellidos"  value="<?php echo isset($apellidos) ? $apellidos :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Dirección</label>
            <input type="text" class="form-control" name="direccion"  value="<?php echo isset($direccion) ? $direccion :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="email" class="control-label">Email</label>
            <input type="email" class="form-control" name="email" oninvalid="setCustomValidity('¡Por favor, introduce una dirección de correo electrónico válida!')"
            onchange="try{setCustomValidity('')}catch(e){}"  required=""  value="<?php echo isset($email) ? $email :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Cédula</label>
            <input type="number" class="form-control" name="id_no"  value="<?php echo isset($id_no) ? $id_no :'' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Curso</label>
            <select name="class_id" id="" class="custom-select select2">
                <option value=""></option>
                <?php
                //$class = $conn->query("SELECT *,concat(ciclo,' - ',horas) as `class` FROM `class` order by concat(ciclo,' - ',horas) asc");
                $class = $conn->query("SELECT *,concat(curso) as `class` FROM `paralelos` order by concat(curso) asc");
                while($row=$class->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($class_id) && $class_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
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
    $('#manage-student').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#manage-student').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url:'ajax.php?action=save_student',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                    alert_toast("Estudiante guardado con éxito",'success')
                        setTimeout(function(){
                            location.reload()
                        },1000)
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">La Cédula ya existe.</div>')
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