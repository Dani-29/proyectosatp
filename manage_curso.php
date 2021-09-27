<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM paralelos where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-curso">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div id="msg" class="form-group"></div>
		<div class="form-group">
			<label for="" class="control-label">Curso</label>
			<input type="text" class="form-control" name="curso"  value="<?php echo isset($curso) ? $curso :'' ?>" required>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-success btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
        </div>
		
	</form>
</div>
<script>
	$('#manage-curso').on('reset',function(){
		$('#msg').html('')
		$('input:hidden').val('')
	})
	$('#manage-curso').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_curso',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Curso guardado con éxito",'success')
						setTimeout(function(){
							location.reload()
						},1000)
				}else if(resp == 2){
				$('#msg').html('<div class="alert alert-danger mx-2"> El curso ya existe.</div>')
				end_load()
				}	
			}
		})
	})
</script>