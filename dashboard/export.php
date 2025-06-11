<?php
//import koneksi ke database
require 'function.php';
require 'cek.php';
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
			<h2>Data Booking Orbital Nexus</h2>
				<div class="data-tables datatable-dark">
					
					<!-- Masukkan table nya disini, dimulai dari tag TABLE -->
                    <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Tiket</th>
                                            <th>Destinasi</th>
                                            <th>Tanggal Pemberangkatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $query = "SELECT 
                                                    u.id_user,
                                                    u.email, 
                                                    t.id_tiket,
                                                    t.kelas, 
                                                    p1.id_planet AS asal_id,
                                                    p1.nama AS asal_nama,
                                                    p2.id_planet AS tujuan_id,
                                                    p2.nama AS tujuan_nama,
                                                    h.id_histori,
                                                    h.tanggal, 
                                                    h.pukul  
                                                FROM histori_booking h
                                                JOIN user u ON h.id_user = u.id_user
                                                JOIN tiket t ON h.id_tiket = t.id_tiket
                                                JOIN planet p1 ON h.asal = p1.id_planet
                                                JOIN planet p2 ON h.tujuan = p2.id_planet
                                                ORDER BY h.tanggal ASC, h.pukul ASC
                                                    ";

                                        $getdatastock = mysqli_query($conn, $query);
                                        while($data=mysqli_fetch_array($getdatastock)){
                                            $id_histori = $data['id_histori'];
                                            $user = $data['email'];
                                            $tiket = $data['kelas'];
                                            $asal = $data['asal_nama'];
                                            $tujuan = $data['tujuan_nama'];
                                            $tanggal = $data['tanggal'];
                                            $pukul = $data['pukul'];

                                            $destinasi = htmlspecialchars($asal).' - '.htmlspecialchars($tujuan);
                                            $pemberangkatan = htmlspecialchars($tanggal).' - '.htmlspecialchars($pukul).' WIB';
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=htmlspecialchars($user);?></td>
                                            <td><?=htmlspecialchars($tiket);?></td>
                                            <td><?=htmlspecialchars($destinasi);?></td>
                                            <td><?=htmlspecialchars($pemberangkatan);?></td>
                                        <?php
                                        };
                                        ?>
                                    </tbody>
                                </table>
				</div>
</div>
	
<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy','csv','excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>