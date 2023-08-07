<?php
error_reporting(0);

mysql_connect('localhost','root','');
mysql_select_db('sweet');

if (isset($_POST['simpan'])) {
	$nm=$_POST['nama'];

	$s=mysql_query("insert into test (nama) values ('$nm')");

	  if ($s) {
	  	if (empty($nm)) {
	  	  	$nm='Nama Tidak diisi !';
	  	  }else{
	  	  	$nm;
	  	  }
	      echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Nama berhasil tersimpan.',
	                text:  'Nama : $nm',
	                type: 'success',
	                timer: 3200,
	                showConfirmButton: true
	            });   
	      },10);  
	      window.setTimeout(function(){ 
	        window.location.replace('sweet.php');
	      } ,3000); 
	      </script>";
	  }else{
	    echo "gagal simpan.";
	  }
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>SWEETALERT</title>
	<link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
 	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/sweetalert.css">
</head>
<body>

 <div class="container ml-4">
 	<div class="row">
    	<div class="col-md-4 mt-4">
    		<form action="" method="POST">
      			<div class="page-header">
        			<h4>
        				<span class="far fa-bell fa-lg" style="color: #1cc88a"></span><strong>&nbsp;&nbsp;Membuat Sweet Alert</strong>
        			</h4>
      				<hr>
      			</div>
      			<label class="control-label">Nama Lengkap</label>
      			<div class="form-group">
            		<input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" onkeypress="return hanyaHuruf(event)">
      			</div>
      				<div class="form-group">
            			<button class="btn" style="background-color: #1cc88a; color: white" type="submit" name="simpan">
            				<i class="fas fa-save"></i>&nbsp;Simpan
            			</button>
     				</div>
     		</form>
    	</div>
 	</div>
 </div>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/sweetalert.min.js"></script>

<script type="text/javascript">
	function hanyaHuruf(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 65 || charCode > 90)&&(charCode < 97 || charCode > 122)&&charCode>32)
            return false;
        return true;
	}
</script>

</body>
</html>