<?php include('header.html') ?>
<?php
require_once('db_login.php');

if (isset($_POST["signup"])){
	$valid = TRUE;
	$npsn = test_input($_POST['npsn']);
    if ($npsn == '') {
        $error_npsn = "NPSN harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $npsn)){
        $error_npsn = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
	
	$password = md5(test_input($_POST['password']));
	if ($password == ''){
		$error_password = "Kata Sandi harus diisi";
		$valid = FALSE;
	}
    $cpassword = md5(test_input($_POST['cpassword']));
	if ($cpassword == ''){
		$error_cpassword = "Konfirmasi Kata Sandi harus diisi";
		$valid = FALSE;
	}
	
	
	if ($valid){
        if($password==$cpassword){
            $cek_sekolah = "SELECT npsn FROM tb_sekolah WHERE npsn = $npsn";
            $hasil = $db->query( $cek_sekolah );
            if($hasil->num_rows > 0) {
                $cek_login = "SELECT npsn FROM tb_login WHERE npsn = $npsn";
                $login = $db->query( $cek_login );
                if($login->num_rows > 0){
                    echo "<script type='text/javascript'>
                        setTimeout(function (){
                            swal({
                                title: 'Register gagal!',
                                text: 'Akun anda telah terdaftar',
                                icon: 'error',
                            });
                        });
                        </script>";
                }               
                else {
                $query = " INSERT INTO tb_login(npsn,password) VALUES ($npsn,'".$password."')";
                $result = $db->query( $query );
                    if (!$result){
                        die("Could not query the database: <br />". $db->error. '<br>Query:' .$query);
                    }
                    else{
                        echo "<script type='text/javascript'>
                        setTimeout(function (){
                            swal({
                                title: 'Register berhasil!',
                                text: 'Anda berhasil mendaftar akun',
                                icon: 'success',
                            });
                        },1);
                        window.setTimeout(function(){
                            window.location.replace('index.php');
                        } ,1000);
                        </script>";
                    }
                }
            }
            else{
                echo "<script type='text/javascript'>
                setTimeout(function (){
                    swal({
                        title: 'Register gagal!',
                        text: 'NPSN anda tidak terdaftar',
                        icon: 'error',
                    });
                });
                </script>";
            }
        }
        else{
            echo "<script type='text/javascript'>
                setTimeout(function (){
                    swal({
                        title: 'Register gagal!',
                        text: 'Kata Sandi tidak sama',
                        icon: 'error',
                    });
                });
                </script>";
        }
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
            style="background:url(assets/images/big/bg2.png) no-repeat center center;">
                
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <h2 class="mt-3 text-center">Daftar Akun</h2>
                        <form class="mt-4" method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER ['PHP_SELF']);?>">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="npsn">NPSN</label>
                                        <input class="form-control" name="npsn" id="npsn" type="text">
                                        <div class="error"><?php if (isset($error_npsn)) echo $error_npsn;?></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="password">Kata Sandi</label>
                                        <input class="form-control" name="password" id="password" type="password">
                                        <div class="error"><?php if (isset($error_password)) echo $error_password;?></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="password">Konfirmasi Kata Sandi</label>
                                        <input class="form-control" name="cpassword" id="cpassword" type="password">
                                        <div class="error"><?php if (isset($error_cpassword)) echo $error_cpassword;?></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" name="signup" class="btn btn-block btn-success">Daftar</button>
                                    <a href="login.php" class="btn btn-block btn-dark">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</body>
<?php include('footer.html') ?>