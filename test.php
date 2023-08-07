<?php
require_once "../_config/config.php";
if(isset($_SESSION['user'])){
    echo "<script>window.location ='".base_url()."';</script>";
} else{
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Aplikasi BLUBOOK | Log in</title>
  <link href="<?=base_url('_assets/template/bower_components/Ionicons/css/ionicons.min.css');?>" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/AdminLTE.min.css" rel="stylesheet">
  <link href="<?=base_url('_assets/template/plugins/iCheck/square/blue.css');?>" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="icon" href="<?=base_url('_assets/img/logo1.png');?>">
</head>
<body class="hold-transition login-page" style="height: 550px">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Aplikasi</b>BLUBOOK</a>
    </div>
    <!-- /.login-logo -->
    <?php
    if(isset($_POST['login'])){
        $user = trim(mysqli_real_escape_string($con, $_POST['user']));
        $pass = sha1(trim(mysqli_real_escape_string($con, $_POST['pass'])));
        $sql_login = mysqli_query($con,"SELECT * FROM tb_user WHERE username = '$user' AND password = '$pass'") or die (mysqli_error($con));
        if (mysqli_num_rows($sql_login) >= 1){
            $data = mysqli_fetch_assoc($sql_login);
            $_SESSION['user'] = $user;
            $_SESSION['id'] = $data['id_user'];
            if($data['level'] == 'admin'){
              $_SESSION['level'] = 'admin';  
            }
            else if($data['level'] == 'member'){
              $_SESSION['level'] = 'member';  
            }
            echo "<script>alert('Login berhasil. Selamat datang di aplikasi BLUBOOK')</script>";
            echo "<script>window.location ='".base_url()."';</script>";
        }else{ ?>
            <div class="row text-center">
                <div>
                    <div class="alert alert-danger alert-dismissable" role = "alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <strong>Login gagal!</strong> Username/password kamu salah
                    </div>
                </div>
            </div>
        <?php
        }
    }
    ?>
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="#" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="user" placeholder="Username">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="pass" placeholder="Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8" style="padding-top: 6px">
            <a href="<?=base_url('auth/register.php');?>" class="text-center">Register a new membership</a>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <input type="submit" name="login" class="btn btn-success btn-block" value="Sign In">
          <!-- /.col -->
          </div>
        </div>
      </form>
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="<?=base_url('_assets/template/bower_components/jquery/dist/jquery.min.js');?>"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?=base_url('_assets/template/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
  <!-- iCheck -->
</body>
</html>

<?php
}
?>