<?php
    $id= $_GET['id'];
    require_once('db_login.php');
    $q1 = "DELETE FROM tb_kerjasama WHERE id_kerjasama='".$id."'";
    $result = $db->query($q1);
    if (!$result) {
	    die ("Could not query the database: <br>".$db->error);
	}else {
        $db->close();
        echo"<script>window.alert('Data berhasil dihapus'); window.location='kerjasama.php'</script>";
     } 
    $db -> close();?>


