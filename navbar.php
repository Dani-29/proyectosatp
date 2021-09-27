
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
				<?php if($_SESSION['login_faculty_id'] <= 0): ?>
				<a href="index.php?page=ciclos" class="nav-item nav-ciclos"><span class='icon-field'><i class="fa fa-th-list "></i></span> Course</a>
				<a href="index.php?page=asignaturas" class="nav-item nav-asignaturas"><span class='icon-field'><i class="fa fa-book "></i></span> Subject</a>
				<a href="index.php?page=class" class="nav-item nav-class"><span class='icon-field'><i class="fa fa-list-alt "></i></span> Class</a>
				<a href="index.php?page=docentes" class="nav-item nav-docentes"><span class='icon-field'><i class="fa fa-user-tie "></i></span> Faculty</a>
				<a href="index.php?page=estudiantes" class="nav-item nav-estudiantes"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Student</a>
				<a href="index.php?page=class_subject" class="nav-item nav-class_subject"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Class per Subject</a>
				<?php endif; ?>
				<a href="index.php?page=asistencia" class="nav-item nav-asistencia"><span class='icon-field'><i class="fa fa-tasks "></i></span> Check Attendance</a>
				<a href="index.php?page=verificar_asistencia" class="nav-item nav-verificar_asistencia"><span class='icon-field'><i class="fa fa-tasks "></i></span> Attendance Record</a>
				<a href="index.php?page=reporte_asistencia" class="nav-item nav-reporte_asistencia"><span class='icon-field'><i class="fa fa-tasks "></i></span> Attendance Report</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=usuarios" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users "></i></span> Users</a>
				<!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs text-danger"></i></span> System Settings</a> -->
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
