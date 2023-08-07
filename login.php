<?php
session_start();
include('header.html');
if(isset($_SESSION['login'])){
    header("location: login.php");
    exit;
}
?>

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
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url(assets/images/big/bg2.png) no-repeat center center; ">
            
                
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                    <div class="text-center">
                            <img src="assets/images/big/logo-icon.png" width="100px" alt="wrapkit">
                        </div>
                        <h1 class="mt-3 text-center">Selamat Datang di SIDABISA</h1>
                        
                        <form class="mt-4" method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER ['PHP_SELF']);?>">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="npsn">NPSN</label>
                                        <input class="form-control" name="npsn" id="npsn" type="text" placeholder="Masukkan NPSN anda">
                                        <div class="error" style="color: red;"><?php if (isset($error_npsn)) echo $error_npsn;?></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="password">Kata Sandi</label>
                                        <input class="form-control" name="password" id="password" type="password" placeholder="Masukkan kata sandi" value="">
                                        <div class="error" style="color: red;"><?php if (isset($error_password)) echo $error_password;?></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" name="login" class="btn btn-block btn-dark">Masuk</button>
                                    <a href="register.php" type="submit" name="login" class="btn btn-block btn-success">Daftar Akun</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
        </div>
    </div>
</body>

<?php include('footer.html')?>