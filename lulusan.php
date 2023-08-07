<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}
include 'db_login.php';

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<script>
    function logout(){
        return confirm('Apakah anda ingin logout?')
    }
    function hapus(){
        return confirm('Apakah anda ingin menghapus data ini?')
    }
</script>

<?php include('header.html') ?>

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
                            <a href="lihat_profil.php" class="dropdown-item" ><i data-feather="user" class="svg-icon mr-2 ml-1"></i>Profil Saya</a>
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
                                    <li class="breadcrumb-item"><a href="lulusan.php"><h2>Keterserapan Lulusan</h2></a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8">
                        <a href="add_lulusan.php" type="submit" class="btn waves-effect waves-light btn-rounded btn-primary" style="margin-left: -15px;" name="submit" value="submit">Tambah Data</a>
                    </div>
                        <br> <br>
                        <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-hover table-bordered">
                            <thead class="bg-info text-white" style="text-align: center;">
                                <tr>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Punya BKK</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Jumlah lulusan tiap program</th>
                                    <th colspan="4" style="vertical-align : middle;text-align:center;">Jumlah lulusan</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Total Jumlah lulusan</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Jumlah Keterserapan</th>
                                    <th colspan="2" style="vertical-align : middle;text-align:center;">Jumlah yang Sesuai Keahlian</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Nama Perusahaan</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Aksi</th>
                                </tr>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">Industri</th>
                                    <th style="vertical-align : middle;text-align:center;">Universitas</th>
                                    <th style="vertical-align : middle;text-align:center;">Wirausaha</th>
                                    <th style="vertical-align : middle;text-align:center;">Menganggur</th>
                                    <th style="vertical-align : middle;text-align:center;">Sesuai</th>
                                    <th style="vertical-align : middle;text-align:center;">Tidak Sesuai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $No = 1;     
                                    require_once('db_login.php');
                                    $npsn = $_SESSION['npsn'];
                                    $query1 = "SELECT * FROM tb_keterserapan WHERE npsn=$npsn ORDER BY id";
                                    $result =$db->query($query1);
                                    while($show=$result->fetch_object()){?>
                                        <tr>
                                            <td><?php echo $No; ?></td>
                                            <td><?php echo $show->bkk; ?></td>
                                            <td><?php echo $show->jml_lulusan_txt; ?></td>
                                            <td><?php echo $show->jml_industri; ?></td>
                                            <td><?php echo $show->jml_univ; ?></td>
                                            <td><?php echo $show->jml_wirausaha; ?></td>
                                            <td><?php echo $show->jml_nganggur; ?></td>
                                            <td><?php echo $show->total_lulusan; ?></td>
                                            <td><?php echo $show->jml_serapan; ?></td>
                                            <td><?php echo $show->jml_sesuai_kompetensi; ?></td>
                                            <td><?php echo $show->jml_tdk_sesuai_kompetensi; ?></td>
                                            <td><?php echo $show->kerjasama_industri; ?></td>
                                            <td>
                                            <a class="btn waves-effect waves-light btn-rounded btn-outline-info" href="edit_lulusan.php?id=<?php echo $show->id;?>">Edit</a> 
                                            <a class="btn waves-effect waves-light btn-rounded btn-outline-danger" href="hapus_lulusan.php?id=<?php echo $show->id?>" 
                                            onclick="javascript: return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a> 
                                            </td>
                                       </tr>
                                    <?php $No++;
                                    }
                                ?>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>

<?php include('footer.html') ?>