<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->

            <li class="nav-item active">
                <a class="nav-link">
                    <span>Sistema de asistencia tecnologico primero de Mayo</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php?page=home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Principal</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <?php if($_SESSION['login_faculty_id'] <= 0): ?>
                <li class="nav-item">
                <a class="nav-link" href="index.php?page=ciclos">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Ciclos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=cursos">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Cursos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=asignaturas">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Asignaturas</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=docentes">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Docentes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=estudiantes">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Estudiantes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=class_subject">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Ciclos por asignatura</span></a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=asistencia">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Registrar asistencia</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=verificar_asistencia">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Verificar asistencia</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=reporte_asistencia">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Reporte de asistencia</span></a>
            </li>
            <?php if($_SESSION['login_type'] == 1): ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=usuarios">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Usuarios</span></a>
            </li>
            <?php endif; ?>
            

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>