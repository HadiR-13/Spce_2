<?php
//jika belum login
if(isset($_SESSION['log'])){
}
else{
    header('register.php');
}
?>