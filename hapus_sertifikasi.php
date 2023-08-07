<?php
        $id= $_GET['id'];
        require_once('db_login.php');
        $q3 = "DELETE FROM tb_sertifikasi WHERE id=".$id."";
        $result = $db->query($q3);
        if (!$result) {
            die ("Could not query the database: <br>".$db->error);
        }else {
            $db->close();
            echo"<script>window.alert('Data berhasil dihapus'); window.location='sertifikasi.php'</script>";
        }
        $db -> close(); 
    ?>

