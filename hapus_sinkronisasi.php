<?php
    $id= $_GET['id'];
    require_once('db_login.php');
    $q2 = "DELETE FROM tb_sinkronisasi WHERE id=".$id."";
    $result = $db->query($q2);
    if (!$result) {
	    die ("Could not query the database: <br>".$db->error);
	}else {
        $db->close();
        echo"<script>window.alert('Data berhasil dihapus'); window.location='sinkronisasi.php'</script>";
     } 
    $db -> close();?>

