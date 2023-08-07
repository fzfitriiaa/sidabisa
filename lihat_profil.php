<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}
?>

<?php include('header.html'); 
require_once('db_login.php');

$npsn = $_SESSION['npsn'];
$q = "SELECT * FROM tb_sekolah WHERE npsn=$npsn";
$hasil = mysqli_query($db, $q);
while ($row = mysqli_fetch_array($hasil)){
    $npsn=$row["npsn"];
    $nama_smk=$row["nama_smk"];
    $status=$row["status"];
    $akreditasi=$row["akreditasi"];
    $alamat=$row["alamat"];
    $kab_kota=$row["kab_kota"];
    $kecamatan=$row["kecamatan"];
    $telp=$row["telp"];
    $fax=$row["fax"];
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
                                    <li class="breadcrumb-item"><h2>Lihat Profil Sekolah</h2></li>
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
                            <label for="npsn" class="col-lg-2" style="vertical-align: middle;">NPSN</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="npsn" name="npsn" value="<?php echo $npsn; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama_smk" class="col-lg-2" style="vertical-align: middle;">Nama Sekolah</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="nama_smk" name="nama_smk" value="<?php echo $nama_smk; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="status" class="col-lg-2" style="vertical-align: middle;">Status</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="status" name="status" value="<?php echo $status; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="akreditasi" class="col-lg-2" style="vertical-align: middle;">Akreditasi</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="status" name="status" value="<?php echo $akreditasi; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="alamat" class="col-lg-2" style="vertical-align: middle;">Alamat</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <textarea type="text" class="form-control" rows="3" id="alamat" name="alamat" readonly><?php echo $alamat; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="kecamatan" class="col-lg-2" style="vertical-align: middle;">Kecamatan</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $kecamatan; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="kab_kota" class="col-lg-2" style="vertical-align: middle;">Kabupaten/kota</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="kab_kota" name="kab_kota" value="<?php echo $kab_kota; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="telp" class="col-lg-2" style="vertical-align: middle;">No. Telpon</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="telp" name="telp" value="<?php echo $telp; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="fax" class="col-lg-2" style="vertical-align: middle;">Fax</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="fax" name="fax" value="<?php echo $fax; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="text-right">
                            <a href="index.php" class="btn btn-dark">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>

<?php include('footer.html') ?>