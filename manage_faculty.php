<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM faculty where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-faculty">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div id="msg" class="form-group"></div>
		<div class="form-group">
			<label for="" class="control-label">Nombre</label>
			<input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" class="form-control" name="email" oninvalid="setCustomValidity('¡Por favor, introduce una dirección de correo electrónico válida!')"
			onchange="try{setCustomValidity('')}catch(e){}"  required=""  value="<?php echo isset($email) ? $email :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Contacto</label>
			<input type="number" class="form-control" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Dirección</label>
			<textarea name="address" id="address" cols="30" rows="4" class="form-control"><?php echo isset($address) ? $address :'' ?></textarea>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Password</label>
			<input type="text" class="form-control" name="id_no"  value="<?php echo isset($id_no) ? $id_no :'' ?>" required>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-success btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
        </div>
		
	</form>
</div>
<script>
	$('#manage-faculty').on('reset',function(){
		$('#msg').html('')
		$('input:hidden').val('')
	})
	$('#manage-faculty').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_faculty',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Docente guardado con éxito",'success')
						setTimeout(function(){
							location.reload()
						},1000)
				}else if(resp == 2){
				$('#msg').html('<div class="alert alert-danger mx-2"> El usuario ya existe.</div>')
				end_load()
				}	
			}
		})
	})
</script>