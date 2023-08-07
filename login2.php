<?php
session_start();
if(isset($_SESSION['login'])){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V4</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>

<?php 
require_once('db_login.php');

if(isset($_POST["login"])){
	$valid = TRUE; //flag validasi
	//cek validasi email
	$npsn = test_input(isset($_POST['npsn']) ? $_POST['npsn'] : '');
	if ($npsn == ''){
		$error_npsn = "NPSN harus ditulis";
		$valid = FALSE;
	}
	//cek validasi password
	$password = test_input(isset($_POST['password']) ? $_POST['password'] : '');
	if ($password == ''){
		$error_password = "Kata Sandi harus ditulis";
		$valid = FALSE;
	}
	
	//cek validasi
	if($valid){
		//asign query
        $cek_login = "SELECT npsn FROM tb_login WHERE npsn = $npsn";
        $login = $db->query( $cek_login );
        if($login->num_rows==0){
            echo "<script type='text/javascript'>
                    setTimeout(function (){
                        swal({
                            title: 'Login gagal!',
                            text: 'Sekolah anda belum memiliki akun',
                            icon: 'error',
                        });
                    });
                    </script>";
        }
        else{
            $query = "SELECT * FROM tb_login JOIN tb_sekolah ON tb_login.npsn=tb_sekolah.npsn WHERE tb_login.npsn = $npsn
            AND password = '".md5($password)."' ";
		    //execute the query
            $result = $db->query( $query );
            if(!$result){
                die ("Could not query the database: <br />". $db->error);
            }
            else{
                if ($result->num_rows > 0){ //login berhasil
                    $data = mysqli_fetch_assoc($result);
                    $_SESSION['login'] = 1;
                    $_SESSION['nama_smk'] = $data['nama_smk'];
                    $_SESSION['npsn'] = $data['npsn'];
                    echo "<script type='text/javascript'>
                    setTimeout(function (){
                        swal({
                            title: 'Login berhasil!',
                            text: 'Anda berhasil login',
                            icon: 'success',
                        });
                    },1);
                    window.setTimeout(function(){
                        window.location.replace('index.php');
                    } ,1000);
                    </script>";
                }
                else{
                    echo "<script type='text/javascript'>
                    setTimeout(function (){
                        swal({
                            title: 'Login gagal!',
                            text: 'Kombinasi NPSN atau Password salah',
                            icon: 'error',
                        });
                    });
                    </script>";
                }
            }
        }
	//close db connection
	$db->close();
	}
}
?>


<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/images/big/bg2.png');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="mt-4" method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER ['PHP_SELF']);?>">
					<span class="login100-form-title p-b-49">
						Masuk
					</span>
					<div class="form-group">
                        <label class="text-dark" for="npsn">NPSN</label>
                        <input class="form-control" name="npsn" id="npsn" type="text" placeholder="Masukkan NPSN anda">
                        <div class="error" style="color: red;"><?php if (isset($error_npsn)) echo $error_npsn;?></div>
                    </div>

					<div class="form-group">
                        <label class="text-dark" for="password">Kata Sandi</label>
                        <input class="form-control" name="password" id="password" type="password" placeholder="Masukkan kata sandi" value="">
                        <div class="error" style="color: red;"><?php if (isset($error_password)) echo $error_password;?></div>
                    </div>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" name="login" class="login100-form-btn">
								Login
							</button>
						</div>
					</div>
<br>
						<a href="register.php" type="submit" name="login" class="txt2">
							Sign Up
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

    <!-- All Jquery -->
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- apps -->
<!-- apps -->
<script src="dist/js/app-style-switcher.js"></script>
<script src="dist/js/feather.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<!-- themejs -->
<!--Menu sidebar -->
<script src="dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="dist/js/custom.min.js"></script>

<!--This page plugins -->
<script src="assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/extra-libs/datatables.net/js/jquery.dataTables.js"></script>
<script src="dist/js/pages/datatable/datatable-basic.init.js"></script>

<script src="//cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>


</body>

</html>

</body>
</html>