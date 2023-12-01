  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../../adminlte/img/icon.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Kelas<strong>AI</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../adminlte/img/icon.png" class="img-circle elevation-2" alt="User Image" style="width:50px">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username']; ?> <br> <?php echo $_SESSION['role'] . ' ' . $_SESSION['studi']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">  
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>  
          <li class="nav-item">
            <a href="guru.php" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Database Guru</p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="siswa.php" class="nav-link">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Database Siswa</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="kelas.php" class="nav-link">
              <i class="nav-icon fas fa-chalkboard"></i>
              <p>Database Kelas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="mapel.php" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>Database Mata Pelajaran</p>
            </a>
          </li>
          <hr>
          <li class="nav-item">
            <a href="../server/logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Keluar</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>