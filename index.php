<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<script>
</script>

<?php include('header.html'); 

require_once('db_login.php');
$npsn = $_SESSION['npsn'];
$kerjasama = " SELECT * FROM  tb_kerjasama WHERE npsn=$npsn ";
$sertifikasi = " SELECT * FROM  tb_sertifikasi WHERE npsn=$npsn ";
$sinkronisasi = " SELECT * FROM  tb_sinkronisasi WHERE npsn=$npsn ";
$nganggur = " SELECT COUNT(jml_nganggur) as nganggur FROM  tb_keterserapan WHERE npsn=$npsn ";
$bekerja = " SELECT COALESCE(SUM(jml_industri + jml_wirausaha),0) AS bekerja FROM tb_keterserapan WHERE npsn=$npsn ";
$result = $db->query($kerjasama);
$show = $db->query($sertifikasi);
$sinkron = $db->query($sinkronisasi);
$data = $db->query($nganggur);
$b = $db->query($bekerja);
$hasil = $result->num_rows;
$hasil_sertif = $show->num_rows;
$hasil_sinkron = $sinkron->num_rows;
?>

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
                                <span class="text-dark"><span><?php echo $_SESSION['nama_smk']; ?></span></span>
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
                                    <li class="breadcrumb-item"><a href="index.php"><h2>Halaman Awal</h2></a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Kerjasama dengan Industri</h4>
                            <h2 class="text-dark font-weight-medium">
                            <?php
                                echo $hasil;
                            ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sinkronisasi Kurikulum</h4>
                            <h2 class="text-dark mb-1 font-weight-medium">
                            <?php
                                echo $hasil_sinkron;
                            ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Lulusan yang Bekerja</h4>
                            <h2 class="text-dark mb-1 font-weight-medium">
                            <?php while($baris = $b->fetch_object()){
                                echo '<td>'.$baris->bekerja.'</td>';
                            } ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Lulusan yang Menganggur</h4>
                            <h2 class="text-dark mb-1 font-weight-medium">
                            <?php while($row = $data->fetch_object()){
                               echo '<td>'.$row->nganggur.'</td>';
                            } ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sertifikasi Sekolah</h4>
                            <h2 class="text-dark mb-1 font-weight-medium">
                            <?php echo $hasil_sertif; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>

<?php include('footer.html') ?>