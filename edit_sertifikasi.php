<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}
?>

<?php include('header.html'); 
require_once('db_login.php');

$id = $_GET["id"];
$q2 = mysqli_query($db, " SELECT * FROM tb_sertifikasi WHERE id=".$id." ");
while ($hasil = mysqli_fetch_array($q2)){
    $id=$hasil["id"];
    $npsn=$hasil["npsn"];
    $status=$hasil["status"];
    $status_tuk=$hasil["status_tuk"];
    $kompetensi=$hasil["id_kompetensi"];
    $jml_siswa=$hasil["jml_siswa"];
    $lembaga=$hasil["lembaga"];
    $status_lulus=$hasil["status_lulus"];
    $jml_lulus=$hasil["jml_lulus"];
    }
?>
<?php

if (isset($_POST["submit"])) {
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
    $status = test_input(isset($_POST['status']) ? $_POST['status'] : '');
    if ($status == '') {
        $error_status = "Status harus sudah diisi";
        $valid = FALSE;
    }
    $status_tuk = test_input(isset($_POST['status_tuk']) ? $_POST['status_tuk'] : '');
    if ($status_tuk == '') {
        $error_status_tuk = "Status TUK harus sudah diisi";
        $valid = FALSE;
    }
    $kompetensi = test_input($_POST['kompetensi']);
    if ($kompetensi == '') {
        $error_kompetensi = "Kompetensi Keahlian harus diisi";
        $valid = FALSE;
    }
    $jml_siswa = test_input(isset($_POST['jml_siswa']) ? $_POST['jml_siswa'] : '');
    if ($jml_siswa == '') {
        $error_jml_siswa = "Jumlah siswa harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_siswa)){
        $error_jml_siswa = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $lembaga = test_input($_POST['lembaga']);
    if ($lembaga == '') {
        $error_lembaga = "Field ini harus diisi";
        $valid = FALSE;
    }
    $status_lulus = test_input(isset($_POST['status_lulus']) ? $_POST['status_lulus'] : '');
    if ($status_lulus == '') {
        $error_status_lulus = "Status Lulus harus diisi";
        $valid = FALSE;
    }
    $jml_lulus = test_input(isset($_POST['jml_lulus']) ? $_POST['jml_lulus'] : '');
    if ($jml_lulus == '') {
        $error_jml_lulus = "Jumlah siswa lulus harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_lulus)){
        $error_jml_lulus = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    
    if ($valid){
        $status = $db->real_escape_string($status);
        $status_tuk = $db->real_escape_string($status_tuk);
        $kompetensi = $db ->real_escape_string($kompetensi);
        $lembaga = $db->real_escape_string($lembaga);
        $status_lulus = $db->real_escape_string($status_lulus);
        $query1 = "UPDATE tb_sertifikasi SET 
                    npsn=$npsn, 
                    status='".$status."',
                    status_tuk='".$status_tuk."',
                    id_kompetensi=$kompetensi,
                    jml_siswa=$jml_siswa,
                    lembaga='".$lembaga."',
                    status_lulus='".$status_lulus."',
                    jml_lulus=$jml_lulus
                   WHERE id='".$id."'";
        #execute query
        $result =$db->query($query1);
        if (!$result) {
            die ("could not query the database: <br>".$db->error.'<br>Query:'.$query1);
        }
        else {
            echo "
            <script>window.alert('Data berhasil diubah'); window.location='sertifikasi.php'</script>";
        }
        #close connection
        $db->close();
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

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
                            <a href="edit_profil.php" class="dropdown-item" ><i data-feather="user" class="svg-icon mr-2 ml-1"></i>Profil Saya</a>
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
                                    <li class="breadcrumb-item"><h2>Form Edit Sertifikasi Kurikulum</h2></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <form method="POST" autocomplete="on" action="">
                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <div class="row">
                            <label for="npsn" class="col-lg-3" style="vertical-align: middle;">NPSN</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="npsn" name="npsn" value="<?php echo $npsn; ?>">
                                        <div class="error"><?php if (isset($error_npsn)) echo $error_npsn;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="status" class="col-lg-3" style="vertical-align: middle;">Apakah Telah Sertifikasi</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="status" value="Sudah" <?php if($status=='Sudah') echo 'checked';?>>
                                            <label class="form-check-label" for="status">Sudah</label>
                                    </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="status" value="Belum" <?php if($status=='Belum') echo 'checked';?>>
                                            <label class="form-check-label" for="status">Belum</label>
                                        </div>
                                        <div class="error"><?php if (isset($error_status)) echo $error_status;?></div>
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
                                                id="status_tuk" value="Ada" <?php if($status_tuk=='Ada') echo 'checked';?>>
                                            <label class="form-check-label" for="status_tuk">Ada</label>
                                    </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_tuk"
                                                id="status_tuk" value="Tidak" <?php if($status_tuk=='Tidak') echo 'checked';?>>
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
                            <label for="kompetensi" class="col-lg-3" style="vertical-align: middle;">Kompetensi Keahlian</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                    <select name="kompetensi" id="kompetensi" class="form-control">
                                        <?php
                                        $query_kompetensi="SELECT * FROM tb_kompetensi ";
                                        $sql_kompetensi=mysqli_query($db, $query_kompetensi);
                                        while ($data_kompetensi=mysqli_fetch_array($sql_kompetensi)) {
                                            $k = $data_kompetensi['id_kompetensi'];
                                            $k1 = $data_kompetensi['kompetensi'];
                                            if ($kompetensi==$k) {
                                            $select="selected";
                                            }else{
                                            $select="";
                                            }
                                            echo "<option value='$k' $select>".$k1."</option>";
                                        }
                                        ?>      
                                    </select>
                                        <div class="error"><?php if (isset($error_kompetensi)) echo $error_kompetensi;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="jml_siswa" class="col-lg-3" style="vertical-align: middle;">Jumlah Siswa</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="jml_siswa" name="jml_siswa" value="<?php echo $jml_siswa; ?>">
                                        <div class="error"><?php if (isset($error_jml_siswa)) echo $error_jml_siswa;?></div>
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
                                            <option value="P1" <?php if(isset($lembaga) && $lembaga=="P1") echo 'selected=="true"'; ?>>P1 (Sekolah)</option>
                                            <option value="P2" <?php if(isset($lembaga) && $lembaga=="P2") echo 'selected=="true"'; ?>>P2 (Provinsi)</option>
                                            <option value="P3" <?php if(isset($lembaga) && $lembaga=="P3") echo 'selected=="true"'; ?>>P3 (Asosisasi / Industri)</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="status" class="col-lg-3" style="vertical-align: middle;">Apakah Lulus Semua</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_lulus"
                                                id="status" value="ya" <?php if($status_lulus=='ya') echo 'checked';?>>
                                            <label class="form-check-label" for="status">Ya</label>
                                    </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_lulus"
                                                id="status" value="belum" <?php if($status_lulus=='belum') echo 'checked';?>>
                                            <label class="form-check-label" for="status">Belum</label>
                                        </div>
                                        <div class="error"><?php if (isset($error_status_lulus)) echo $error_status_lulus;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="jml_siswa" class="col-lg-3" style="vertical-align: middle;">Jumlah Siswa Lulus</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="jml_lulus" name="jml_lulus" value="<?php echo $jml_lulus; ?>">
                                        <div class="error"><?php if (isset($error_jml_lulus)) echo $error_jml_lulus;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="text-right">
                            <button type="submit" name="submit" value="submit" class="btn btn-success">Ubah</button>
                            <button type="reset" class="btn btn-danger" value="ulang">Ulang</button>
                            <a href="sertifikasi.php" class="btn btn-dark">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>

<?php include('footer.html') ?>