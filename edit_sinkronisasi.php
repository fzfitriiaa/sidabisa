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
$q2 = mysqli_query($db, " SELECT * FROM tb_sinkronisasi WHERE id=".$id." ");
while ($hasil = mysqli_fetch_array($q2)){
    $id=$hasil["id"];
    $npsn=$hasil["npsn"];
    $sinkron=$hasil["sdh_sinkron"];
    $kompetensi=$hasil["id_kompetensi"];
    $industri_terlibat=$hasil["industri_terlibat"];
    $aspek=$hasil["aspek"];
    $pelaksanaan=$hasil["hasil_sinkron"];
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
    $sinkron = test_input(isset($_POST['sdh_sinkron']) ? $_POST['sdh_sinkron'] : '');
    if ($sinkron == '') {
        $error_sinkron = "Sinkronisasi harus sudah diisi";
        $valid = FALSE;
    }
    $kompetensi = test_input($_POST['kompetensi']);
    if ($kompetensi == '') {
        $error_kompetensi = "Kompetensi Keahlian harus diisi";
        $valid = FALSE;
    }
    $industri_terlibat = test_input(isset($_POST['industri_terlibat']) ? $_POST['industri_terlibat'] : '');
    if ($industri_terlibat == '') {
        $error_industri_telibat = "Nama Industri harus diisi";
        $valid = FALSE;
    }
    $aspek = test_input($_POST['aspek']);
    if ($aspek == '') {
        $error_aspek = "Aspek harus diisi";
        $valid = FALSE;
    }
    $pelaksanaan = test_input(isset($_POST['hasil_sinkron']) ? $_POST['hasil_sinkron'] : '');
    if ($pelaksanaan == '') {
        $error_pelaksanaan = "Bentuk pelaksanaan harus diisi";
        $valid = FALSE;
    }
    
    if ($valid){
        $sinkron = $db->real_escape_string($sinkron);
        $kompetensi = $db ->real_escape_string($kompetensi);
        $industri_terlibat = $db->real_escape_string($industri_terlibat);
        $aspek = $db->real_escape_string($aspek);
        $pelaksanaan = $db->real_escape_string($pelaksanaan);
        $query1 = "UPDATE tb_sinkronisasi SET 
                    npsn=$npsn, 
                    sdh_sinkron='".$sinkron."',
                    id_kompetensi=$kompetensi,
                    industri_terlibat='".$industri_terlibat."',
                    aspek='".$aspek."',
                    hasil_sinkron='".$pelaksanaan."' 
                   WHERE id='".$id."'";
        #execute query
        $result =$db->query($query1);
        if (!$result) {
            die ("could not query the database: <br>".$db->error.'<br>Query:'.$query1);
        }
        else {
            echo "
            <script>window.alert('Data berhasil diubah'); window.location='sinkronisasi.php'</script>";
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
                                    <li class="breadcrumb-item"><h2>Form Edit Sinkronisasi Kurikulum</h2></li>
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
                            <label for="status" class="col-lg-3" style="vertical-align: middle;">Sudah Sinkronisasi</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sdh_sinkron"
                                                id="Sudah" value="Sudah" <?php if($sinkron=='Sudah') echo 'checked';?>>
                                            <label class="form-check-label" for="sinkron">Sudah</label>
                                    </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sdh_sinkron"
                                                id="Belum" value="Belum" <?php if($sinkron=='Belum') echo 'checked';?>>
                                            <label class="form-check-label" for="sinkron">Belum</label>
                                        </div>
                                        <div class="error"><?php if (isset($error_sinkron)) echo $error_sinkron;?></div>
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
                            <label for="industri" class="col-lg-3" style="vertical-align: middle;">Industri yang Terlibat</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="industri" name="industri_terlibat" value="<?php echo $industri_terlibat; ?>">
                                        <div class="error"><?php if (isset($error_industri_terlibat)) echo $error_industri_terlibat;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="aspek" class="col-lg-3" style="vertical-align: middle;">Aspek</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="aspek" name="aspek" value="<?php echo $aspek; ?>">
                                        <div class="error"><?php if (isset($error_aspek)) echo $error_aspek;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="pelaksanaan" class="col-lg-3" style="vertical-align: middle;">Bentuk Pelaksanaan</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="pelaksanaan" name="hasil_sinkron" value="<?php echo $pelaksanaan; ?>">
                                        <div class="error"><?php if (isset($error_pelaksanaan)) echo $error_pelaksanaan;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="text-right">
                            <button type="submit" name="submit" value="submit" class="btn btn-success">Ubah</button>
                            <button type="reset" class="btn btn-danger" value="ulang">Ulang</button>
                            <a href="sinkronisasi.php" class="btn btn-dark">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>

<?php include('footer.html') ?>