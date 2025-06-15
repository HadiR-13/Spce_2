<?php
require 'function.php';
require '../content/database_conf.php';

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
                            <a class="nav-link" href="edit_planet.php">
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
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Histori Booking Tiket</h1>                           
                        <div class="card mb-4">
                            <div class="card-header">
                                <a href="export.php" class="btn btn-success">Export Data</a>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Destinasi</th>
                                            <th>Nomor Kursi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $query = "SELECT 
                                                    b.booking_id,
                                                    u.username,
                                                    b.planet_id,
                                                    b.seat_number
                                                FROM booking b
                                                JOIN user u ON b.user_id = u.user_id
                                                ORDER BY b.booking_id ASC";

                                        $getdatastock = mysqli_query($conn, $query);
                                        $i = 1;
                                        while($data = mysqli_fetch_array($getdatastock)){
                                            $id_booking = $data['booking_id'];
                                            $user = $data['username'];
                                            $planet = $data['planet_id']; 
                                            $seat = $data['seat_number'];
                                        ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($user); ?></td>
                                            <td><?= htmlspecialchars($planet); ?></td>
                                            <td><?= htmlspecialchars($seat); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $id_booking; ?>">Edit</button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $id_booking; ?>">Delete</button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$id_booking;?>" >
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Histori?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                        <?=$user;?><br>
                                                        <?=$planet;?><br>
                                                        <?=$seat;?><br>
                                                        <strong>Anda yakin ingin menghapus histori ini?<strong><br><br>
                                                        <input type="hidden" name="id_booking" value="<?=$id_booking;?>">
                                                        <button class="btn btn-danger" type="submit" name="deletehistori">Hapus</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </td>
                                        </tr> 

                                        <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$id_booking;?>" >
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Histori</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                        Pax : 
                                                        <?=$user;?><br><br>
                                                        Destination:
                                                        <select class="form-control" name="planet-edit" required>
                                                        <?php
                                                            $planets = json_decode(file_get_contents("../data/planets.json"), true);
                                                            foreach($planets as $row) { 
                                                                echo "<option value='{$row['planet_id']}'>{$row['name']}</option>";
                                                            }
                                                        ?>
                                                        </select><br>

                                                        Seat :
                                                        <select class="form-control" name="seat-edit" required>
                                                        <?php
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            echo "<option value='{$i}'>Seat {$i}</option>";
                                                        }
                                                        ?>
                                                        </select><br>
                                                        <input type="hidden" name="id_booking" value="<?=$id_booking;?>">
                                                        <button class="btn btn-success mt-2" type="submit" name="edithistori">Submit</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        <?php
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Kelompok Satu</div>
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
</html>
