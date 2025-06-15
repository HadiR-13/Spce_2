<?php
require 'function.php';
require '../content/database_conf.php';
require 'auth_check.php';


?>
<html>
<head>
  <title>Data Booking Orbital Nexus</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
</head>

<body>
<div class="container">
  <h2>Data Booking Orbital Nexus</h2>
  <div class="data-tables datatable-dark">
    <table id="datatablesSimple" class="display nowrap" style="width:100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Destinasi</th>
          <th>Nomor Kursi</th>
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
        while($data = mysqli_fetch_array($getdatastock)){
          $user = $data['username'];
          $planet = $data['planet_id'];
          $seat = $data['seat_number'];
        ?>
        <tr>
          <td><?= $i++; ?></td>
          <td><?= htmlspecialchars($user); ?></td>
          <td><?= htmlspecialchars($planet); ?></td>
          <td><?= htmlspecialchars($seat); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#datatablesSimple').DataTable({
    dom: 'Bfrtip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    responsive: true
  });
});
</script>
</body>
</html>
