<?php
require 'function.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Spacestation</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">Dashboard Admin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Halaman</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Histori Booking
                            </a>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Edit Planet
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <iframe src="./form_edit.php" frameborder="0" style="height: 100%;"></iframe>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; 231712035 - Habibullah Aqil Dika Putra</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambah Histori</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
         <form method="post">
        <div class="modal-body">
        <label>User :</label>
        <select class="form-control" name="user" required>
                <?php
                    $getdata = mysqli_query($conn, "SELECT * FROM user");
                    while($row = mysqli_fetch_assoc($getdata)){ // Ganti menjadi fetch_assoc
                        echo "<option value='{$row['id_user']}'>{$row['email']}</option>";
                    }
                ?>
                </select><br>

            <label>Kelas Tiket :</label>
            <select class="form-control" name="tiket" required>
                <?php
                    $getdata = mysqli_query($conn, "SELECT * FROM tiket");
                    while($row = mysqli_fetch_assoc($getdata)){ // Ganti menjadi fetch_assoc
                        echo "<option value='{$row['id_tiket']}'>{$row['kelas']}</option>";
                    }
                ?>
                </select><br>

            <label>Asal Pemberangkatan :</label>
            <select class="form-control" name="asal" required>
                <?php
                    $getdata = mysqli_query($conn, "SELECT * FROM planet");
                    while($row = mysqli_fetch_assoc($getdata)){ // Ganti menjadi fetch_assoc
                        echo "<option value='{$row['id_planet']}'>{$row['nama']}</option>";
                    }
                ?>
                </select><br>

            <label>Tujuan Pemberangkatan :</label>
            <select class="form-control" name="tujuan" required>
                <?php
                    $getdata = mysqli_query($conn, "SELECT * FROM planet");
                    while($row = mysqli_fetch_assoc($getdata)){ // Ganti menjadi fetch_assoc
                        echo "<option value='{$row['id_planet']}'>{$row['nama']}</option>";
                    }
                ?>
                </select><br>

            <label>Jadwal Pemberangkatan :</label>
            <input class="form-control" type="date" name="tanggal" required><br>
            <input class="form-control" type="time" name="pukul" required><br>
            <button class="btn btn-primary" type="submit"  name="addnewhistori">Submit</button><br><br>
        </div>
        </form>

        </div>
    </div>
    </div>
</html>
