<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}
?>

<script>
    function hapus(){
        return confirm('Apakah anda yakin akan menghapus data ini?');
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
                                    <li class="breadcrumb-item"><a href="kerjasama.php" ><h2>Kerjasama Industri</h2></a>
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
                        <a href="add_kerjasama.php" type="submit" class="btn waves-effect waves-light btn-rounded btn-primary" style="margin-left: -15px;" name="submit" value="submit">Tambah Data</a>
                    </div>
                    <br> <br>
                    <div class="table-responsive">
                    <table id="zero_config" class="table  table-hover">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama Industri</th>
                                <th>Nama Kompetensi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Lingkup Kerjasama</th>
                                <th>MOU</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $No = 1;     
                                require_once('db_login.php');
                                $npsn = $_SESSION['npsn'];
                                function tanggal_indo($tanggal = false)
                                {
                                    $bulan = array (1 =>   'Januari',
                                                'Februari',
                                                'Maret',
                                                'April',
                                                'Mei',
                                                'Juni',
                                                'Juli',
                                                'Agustus',
                                                'September',
                                                'Oktober',
                                                'November',
                                                'Desember'
                                            );
                                    $split 	  = explode('-', $tanggal);
                                    $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
                                    
                                    return $tgl_indo;
                                }
                                $query = "SELECT id_kerjasama, industri, kompetensi, a.npsn, tgl_mulai, tgl_selesai, lingkup_kerjasama, mou 
                                FROM tb_kerjasama as a JOIN tb_kompetensi as b ON a.id_kompetensi=b.id_kompetensi JOIN tb_sekolah as c ON a.npsn=c.npsn
                                WHERE a.npsn=$npsn";
                                $result = mysqli_query($db, $query);
                                while($tampil=mysqli_fetch_assoc($result)){
                                    $tgl_mulai = date('Y-m-d', strtotime($tampil['tgl_mulai']));
                                    $tgl_selesai = date('Y-m-d', strtotime($tampil['tgl_selesai']));?>
                                    <tr>
                                        <td><?php echo $No; ?></td>
                                        <td><?php echo $tampil["industri"]; ?></td>
                                        <td><?php echo $tampil["kompetensi"]; ?></td>
                                        <td><?php echo tanggal_indo($tgl_mulai, true); ?></td>
                                        <td><?php echo tanggal_indo($tgl_selesai, true); ?></td>
                                        <td><?php echo $tampil["lingkup_kerjasama"]; ?></td>
                                        <td>
                                        <a href="view_mou.php?id=<?php echo $tampil["id_kerjasama"];?>">Lihat</a></td>
                                        <td>
                                        <a class="btn waves-effect waves-light btn-rounded btn-outline-info" href="edit_kerjasama.php?id=<?php echo $tampil["id_kerjasama"]; ?>">Edit</a> 
                                        <a class="btn waves-effect waves-light btn-rounded btn-outline-danger" href="hapus_kerjasama.php?id=<?php echo $tampil["id_kerjasama"]; ?>"
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
    </div>

  
<?php include('footer.html') ?>