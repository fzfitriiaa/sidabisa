<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}
include 'db_login.php';

?>


<script>
    function logout(){
        return confirm('Apakah anda ingin logout?')
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
                                    <li class="breadcrumb-item"><a href="kerjasama.php"><h2>Sinkronisasi Kurikulum</h2></a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <a href="add_sinkronisasi.php" type="submit" class="btn waves-effect waves-light btn-rounded btn-primary" style="margin-left: -15px;" name="submit" value="submit">Tambah Data</a>
                    </div>
                        <br>
                        <br>
                        <table id="zero_config" class="table table-striped table-hover">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">No</th>
                                    <th style="vertical-align : middle;text-align:center;">Sudah Sinkronisasi</th>
                                    <th style="vertical-align : middle;text-align:center;">Kompetensi Keahlian</th>
                                    <th style="vertical-align : middle;text-align:center;">Industri yang Terlibat</th>
                                    <th style="vertical-align : middle;text-align:center;">Aspek</th>
                                    <th style="vertical-align : middle;text-align:center;">Bentuk Pelaksanaan</th>
                                    <th style="vertical-align : middle;text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $No = 1;     
                                    require_once('db_login.php');
                                    $npsn = $_SESSION['npsn'];
                                    $query1 = "SELECT id, a.npsn, sdh_sinkron, kompetensi, industri_terlibat, aspek, hasil_sinkron 
                                    FROM tb_sinkronisasi as a JOIN tb_kompetensi as b ON a.id_kompetensi=b.id_kompetensi JOIN tb_sekolah as c ON a.npsn=c.npsn
                                    WHERE a.npsn=$npsn";
                                    $result =$db->query($query1);
                                    while($show=$result->fetch_object()){ ?>
                                        <tr>
                                            <td><?php echo $No; ?></td>
                                            <td><?php echo $show->sdh_sinkron; ?></td>
                                            <td><?php echo $show->kompetensi; ?></td>
                                            <td><?php echo $show->industri_terlibat; ?></td>
                                            <td><?php echo $show->aspek; ?></td>
                                            <td><?php echo $show->hasil_sinkron; ?></td>
                                            <td>
                                            <a class="btn waves-effect waves-light btn-rounded btn-outline-info" href="edit_sinkronisasi.php?id=<?php echo $show->id;?>">Edit</a>
                                            <a class="btn waves-effect waves-light btn-rounded btn-outline-danger" href="hapus_sinkronisasi.php?id=<?php echo $show->id?>"
                                            onclick="javascript: return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a> 
                                            </td>
                                        </tr>
                                    <?php $No++;
                                    }
                                ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.html') ?>