<?php
    $id= $_GET['id'];
    require_once('db_login.php');
    $q4 = "DELETE FROM tb_keterserapan WHERE id=".$id."";
    $result = $db->query($q4);
    if (!$result) {
	    die ("Could not query the database: <br>".$db->error);
	}else {
        $db->close();
        echo"<script>window.alert('Data berhasil dihapus'); window.location='lulusan.php'</script>";
     } 
    $db -> close();?>

