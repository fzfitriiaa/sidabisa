<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}
require_once('db_login.php');
$npsn = $_SESSION['npsn'];
$q = "SELECT * FROM tb_sekolah WHERE npsn=$npsn";
$hasil = mysqli_query($db, $q);
$baris=mysqli_fetch_array($hasil);
?>

<?php

if (isset($_POST["submit"])) {
    $valid = TRUE;
    $npsn = test_input($_POST['npsn']);
    if ($npsn == '') {
        $error_npsn = "NPSN harus diisi";
        $valid = FALSE;
    }
    $sertifikasi = test_input(isset($_POST['status']) ? $_POST['status'] : '');
    if ($sertifikasi == '') {
        $error_sertifikasi = "Harus diisi";
        $valid = FALSE;
    }
    $status_tuk = test_input(isset($_POST['status_tuk']) ? $_POST['status_tuk'] : '');
    if ($status_tuk == '') {
        $error_status_tuk = "Status TUK harus sudah diisi";
        $valid = FALSE;
    }
    $program = test_input(isset($_POST['kompetensi']) ? $_POST['kompetensi'] : '');
    if ($program == '-- Pilih Kompetensi --') {
        $error_program = "Kompetensi Keahlian harus diisi";
        $valid = FALSE;
    }
    $siswa = test_input(isset($_POST['jml_siswa']) ? $_POST['jml_siswa'] : '');
    if ($siswa == '') {
        $error_siswa = "Jumlah siswa harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $siswa)){
        $error_siswa = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $lembaga = test_input(isset($_POST['lembaga']) ? $_POST['lembaga'] : '');
    if ($lembaga == '-- Pilih Lembaga --') {
        $error_lembaga = "Lembaga sertifikasi harus diisi";
        $valid = FALSE;
    }
    $lulus = test_input(isset($_POST['status_lulus']) ? $_POST['status_lulus'] : '');
    if ($lulus == '') {
        $error_lulus = "Harus diisi";
        $valid = FALSE;
    }
    $jml_lulus = test_input(isset($_POST['jml_lulus']) ? $_POST['jml_lulus'] : '');
    if ($jml_lulus == '') {
        $error_jml_lulus = "Jumlah siswa yang lulus harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_lulus)){
        $error_jml_lulus = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    
    if ($valid){
        $sertifikasi = $db->real_escape_string($sertifikasi);
        $status_tuk = $db->real_escape_string($status_tuk);
        $program = $db ->real_escape_string($program);
        $lembaga = $db->real_escape_string($lembaga);
        $lulus = $db->real_escape_string($lulus);
        
        $query = " INSERT INTO tb_sertifikasi(npsn,status,status_tuk,id_kompetensi,jml_siswa,lembaga,status_lulus,jml_lulus) 
                 VALUES($npsn,'".$sertifikasi."','".$status_tuk."','".$program."',$siswa,'".$lembaga."','".$lulus."',$jml_lulus)";
        #execute query
        $result =$db->query($query);
        if (!$result) {
            die ("could not query the database: <br>".$db->error.'<br>Query:'.$query);
        }
        else {
            echo "<script>window.alert('Data berhasil ditambahkan'); window.location='sertifikasi.php'</script>";
        }
        #close connection
        $db->close();
    }
     
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="25x25" href="assets/images/big/logo-icon.png">
    <title>SIDABISA</title>
    <!-- This page plugin CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <script src="js/script.js"></script>
    <link href="dist/css/style.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <div class="navbar-brand">
                        <b class="logo-icon">
                            <img src="assets/images/logo.png" width="150px" style="margin-top: 15px; margin-right: 15px;" alt="homepage" class="dark-logo" />
                        </b>
                    </div>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <div class="navbar-nav float-left mr-auto ml-3 pl-1">
                        <li class="nav-item">
                            <div class="nav-link" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="text-dark"><span>Selamat Datang, <?php echo $_SESSION['nama_smk']; ?></span></span>
                            </div>
                        </li>
                    </div>
                        <div class="navbar-nav float-right">
                        <a href="lihat_profil.php" class="dropdown-item" onclick="alert('Profil Sekolah hanya dapat dilihat. Jika terdapat perbedaan data, silahkan menghubungi Dinas Pendidikan dan Kebudayaan Jawa Tengah')">
                            <i data-feather="user" class="svg-icon mr-2 ml-1"></i>Profil Saya</a>
                            <a href="logout.php" class="dropdown-item" onclick="javascript: return confirm('Apakah Anda yakin ingin logout?')">
                            <i data-feather="power" class="svg-icon mr-2 ml-1"></i>Keluar</a>
                        </div>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="index.php" aria-expanded="false">
                            <i data-feather="home" class="feather-icon"></i>
                                <span class="hide-menu">Halaman Awal</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="kerjasama.php" aria-expanded="false">
                            <i data-feather="file-text" class="feather-icon"></i>
                                <span class="hide-menu">Kerjasama Industri</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="sinkronisasi.php" aria-expanded="false">
                            <i data-feather="file" class="feather-icon"></i>
                                <span class="hide-menu">Sinkronisasi Kurikulum</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="sertifikasi.php" aria-expanded="false">
                            <i data-feather="briefcase" class="feather-icon"></i>
                                <span class="hide-menu">Sertifikasi Sekolah</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="lulusan.php" aria-expanded="false">
                            <i data-feather="clipboard" class="feather-icon"></i>
                                <span class="hide-menu">Keterserapan Lulusan di Industri</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><h2>Form Tambah Sertifikasi Sekolah</h2></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <form method="POST" autocomplete="on" action="">
                    <div class="form-group">
                        <div class="row">
                            <label for="npsn" class="col-lg-3" style="vertical-align: middle;">NPSN</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="npsn" name="npsn" value="<?php echo $baris['npsn'];?>">
                                        <div class="error" style="color: red;"><?php if (isset($error_npsn)) echo $error_npsn;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="status" class="col-lg-3" style="vertical-align: middle;">Apakah telah sertifikasi?</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="status" value="Sudah">
                                            <label class="form-check-label" for="sertifikasi">Sudah</label>
                                    </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="status" value="Belum">
                                            <label class="form-check-label" for="sertifikasi">Belum</label>
                                        </div>
                                        <div class="error" style="color: red;"><?php if (isset($error_sertifikasi)) echo $error_sertifikasi;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="status_tuk" class="col-lg-3" style="vertical-align: middle;">Apakah Sekolah Memiliki TUK</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_tuk"
                                                id="status_tuk" value="Ada">
                                            <label class="form-check-label" for="status">Ada</label>
                                    </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_tuk"
                                                id="status_tuk" value="Tidak">
                                            <label class="form-check-label" for="status_tuk">Tidak</label>
                                        </div>
                                        <div class="error"><?php if (isset($error_status_tuk)) echo $error_status_tuk;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="program" class="col-lg-3" style="vertical-align: middle;">Kompetensi Keahlian yang telah Sertifikasi</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                    <select id="kompetensi" name="kompetensi" class="form-control">
                                            <option selected>-- Pilih Kompetensi --</option>
                                            <?php
                                                require_once('db_login.php');
                                                $query = " SELECT * FROM tb_kompetensi ORDER BY id_kompetensi ";
                                                #execute query
                                                $result =$db->query($query);
                                                if (!$result) {
                                                    die("Could not query the database: <br>".$db->error);
                                                }
                                                while ($row=$result->fetch_object()) {
                                                    echo'<option value="'.$row->id_kompetensi.'">'.$row->kompetensi.'</option>';
                                                }
                                            ?>
                                        </select>
                                        <div class="error" style="color: red;"><?php if (isset($error_program)) echo $error_program;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <label for="siswa" class="col-lg-3" style="vertical-align: middle;">Jumlah Siswa</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="siswa" name="jml_siswa">
                                        <div class="error" style="color: red;"><?php if (isset($error_siswa)) echo $error_siswa;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="lembaga" class="col-lg-3" style="vertical-align: middle;">Lembaga Sertifikasi</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select id="lembaga" name="lembaga" class="form-control">
                                            <option selected>-- Pilih Lembaga --</option>
                                            <option value="P1">P1 (Sekolah)</option>
                                            <option value="P2">P2 (Provinsi)</option>
                                            <option value="P3">P3 (Asosisasi / Industri)</option>
                                        </select>
                                        <div class="error" style="color: red;"><?php if (isset($error_lembaga)) echo $error_lembaga;?></div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="lulus" class="col-lg-3" style="vertical-align: middle;">Apakah lulus semua?</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_lulus"
                                                id="lulus" value="ya">
                                            <label class="form-check-label" for="lulus">Ya</label>
                                    </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_lulus"
                                                id="sertifikasi" value="belum">
                                            <label class="form-check-label" for="lulus">Belum</label>
                                        </div>
                                        <div class="error" style="color: red;"><?php if (isset($error_lulus)) echo $error_lulus;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="jml_lulus" class="col-lg-3" style="vertical-align: middle;">Jumlah Siswa yang Lulus</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="jml_lulus" name="jml_lulus">
                                        <div class="error" style="color: red;"><?php if (isset($error_jml_lulus)) echo $error_jml_lulus;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="text-right">
                            <input type="submit" name="submit" value="Tambah" class="btn btn-success">
                            <button type="reset" class="btn btn-danger" value="ulang">Ulang</button>
                            <a href="sertifikasi.php" class="btn btn-dark">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
$(document).ready(function(){
 $('#framework').multiselect({
  nonSelectedText: 'Select Framework',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'400px'
 });
 
 $('#framework_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:form_data,
   success:function(data)
   {
    $('#framework option:selected').each(function(){
     $(this).prop('selected', false);
    });
    $('#framework').multiselect('refresh');
    alert(data);
   }
  });
 });
 
 
});
</script>

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

</body>

</html>


