<?php
session_start();
require_once('db_login.php');
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}

$npsn = $_SESSION['npsn'];
$q = "SELECT * FROM tb_sekolah WHERE npsn=$npsn";
$hasil = mysqli_query($db, $q);
$baris=mysqli_fetch_array($hasil);
?>


<?php include('header.html') ?>
<?php
ini_set('display_errors', '1');

if (isset($_POST["submit"])) {
    $valid = TRUE;
    $industri = test_input($_POST['industri']);
    if ($industri == '') {
        $error_industri = "Nama industri harus diisi";
        $valid = FALSE;
    }
    $kompetensi = test_input($_POST['kompetensi']);
    if ($kompetensi == '-- Pilih Kompetensi --') {
        $error_kompetensi = "Kompetensi harus diisi";
        $valid = FALSE;
    }
    $npsn = test_input($_POST['npsn']);
    if ($npsn == '') {
        $error_npsn = "NPSN harus diisi";
        $valid = FALSE;
    }
    $tgl_mulai = test_input($_POST['tgl_mulai']);
    if ($tgl_mulai == '') {
        $error_tgl_mulai = "Tanggal mulai harus diisi";
        $valid = FALSE;
    }
    $tgl_selesai = test_input($_POST['tgl_selesai']);
    if ($tgl_selesai == '') {
        $error_tgl_selesai = "Tanggal selesai harus diisi";
        $valid = FALSE;
    }
    $tgl_mulai = date("Y-m-d", strtotime($tgl_mulai));
    $tgl_selesai = date("Y-m-d", strtotime($tgl_selesai));
    $lingkup = test_input(isset($_POST['lingkup_kerjasama']) ? $_POST['lingkup_kerjasama'] : '');
    if ($lingkup == '-- Pilih Lingkup Kerjasama --') {
        $error_lingkup = "Lingkup kerjasama harus diisi";
        $valid = FALSE;
    }
    
    $mou = $_FILES['mou']['name'];
    $error = $_FILES['mou']['error']; 
    $tmpName = $_FILES['mou']['tmp_name'];
    $size = $_FILES['mou']['size'];
    $tipe = $_FILES['mou']['type'];
    if($error == 4){
        $error_mou = "Pilih file terlebih dahulu!";
        $valid = FALSE;
    }
    else if($tipe != "application/pdf"){
        $error_mou = "Yang anda upload bukan PDF!";
        $valid = FALSE;
    }
    $path = "files/".$mou;
    $upload = move_uploaded_file($tmpName,$path);
    
    if ($valid){
        $industri = $db->real_escape_string($industri);
        $lingkup = $db->real_escape_string($lingkup);
        $tgl_mulai = $db->real_escape_string($tgl_mulai);
        $tgl_selesai = $db->real_escape_string($tgl_selesai);
        $mou = $db->real_escape_string($mou);


        $query = " INSERT INTO tb_kerjasama(industri,id_kompetensi,npsn,tgl_mulai,tgl_selesai,lingkup_kerjasama,mou) 
                 VALUES('".$industri."',$kompetensi,$npsn,'$tgl_mulai','$tgl_selesai','".$lingkup."','$mou')";
        #execute query
        $result =$db->query($query);
        if (!$result) {
            die ("could not query the database: <br>".$db->error.'<br>Query:'.$query);
        }
        else {?>
           <script>window.alert('Data berhasil ditambahkan'); window.location='kerjasama.php'</script>
        <?php }
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
                                    <li class="breadcrumb-item"><h2>Form Tambah Kerjasama Industri</h2></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <form method="POST" autocomplete="on" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label for="nama_industri" class="col-lg-2" style="vertical-align: middle;">Nama Industri</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="nama_industri" name="industri">
                                        <div class="error" style="color: red;"><?php if (isset($error_industri)) echo $error_industri;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="kompetensi" class="col-lg-2" style="vertical-align: middle;">Nama Kompetensi</label>
                            <div class="col-lg-10">
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
                                                $result->free();
                                                $db->close();
                                            ?>
                                        </select>  
                                        <div class="error" style="color: red;"><?php if (isset($error_kompetensi)) echo $error_kompetensi;?></div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="npsn" class="col-lg-2" style="vertical-align: middle;">NPSN</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="npsn" name="npsn" value="<?php echo $baris['npsn']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama_kota" class="col-lg-2" style="vertical-align: middle;">Tanggal Mulai</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" name="tgl_mulai" id="tgl_mulai" class=" form-control">
                                        <div class="error" style="color: red;"><?php if (isset($error_tgl_mulai)) echo $error_tgl_mulai;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama_kota" class="col-lg-2" style="vertical-align: middle;">Tanggal Selesai</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" name="tgl_selesai" id="tgl_selesai" class=" form-control">
                                        <div class="error" style="color: red;"><?php if (isset($error_tgl_selesai)) echo $error_tgl_selesai;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="lingkup_kerjasama" class="col-lg-2" style="vertical-align: middle;">Lingkup Kerjasama</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select id="lingkup_kerjasama" name="lingkup_kerjasama" class="form-control">
                                            <option selected>-- Pilih Lingkup Kerjasama --</option>
                                            <option value="Kerjasama dibidang edukasi dengan institusi Pendidikan di wilayah Provinsi Jawa Tengah">
                                            Kerjasama dibidang edukasi dengan institusi Pendidikan di wilayah Provinsi Jawa Tengah</option>
                                            <option value="Pembinaan dan pengembangan sekolah menengah kejuruan berbasis kompetensi melalui program Bright Olimart Academy">
                                            Pembinaan dan pengembangan sekolah menengah kejuruan berbasis kompetensi melalui program Bright Olimart Academy</option>
                                            <option value="Pengembangan dan penyelarasan kurikulum pembelajaran sesuai kebutuhan industri ketenagalistrikan">
                                            Pengembangan dan penyelarasan kurikulum pembelajaran sesuai kebutuhan industri ketenagalistrikan</option>
                                            <option value="Dukungan proses pembelajaran dan praktek kerja lapangan (magang) bagi guru dan peserta didik SMK">
                                            Dukungan proses pembelajaran dan praktek kerja lapangan (magang) bagi guru dan peserta didik SMK</option>
                                            <option value="Fasilitasi uji kompetensi (sertifikasi)">
                                            Fasilitasi uji kompetensi (sertifikasi)</option>
                                            <option value="Fasilitasi sarana dan prasarana pembelajaran yang terkait dengan metode praktek">
                                            Fasilitasi sarana dan prasarana pembelajaran yang terkait dengan metode praktek</option>
                                            <option value="Peningkatan kompetensi bidang pembangkit tenaga listrik bagi peserta didik SMK">
                                            Peningkatan kompetensi bidang pembangkit tenaga listrik bagi peserta didik SMK</option>
                                            <option value="Peningkatan kompetensi bidang ketenagalistrikan bagi peserta didik SMK di Provinsi Jateng">
                                            Peningkatan kompetensi bidang ketenagalistrikan bagi peserta didik SMK di Provinsi Jateng</option>
                                        </select>  
                                        <div class="error" style="color: red;"><?php if (isset($error_lingkup)) echo $error_lingkup;?></div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="mou" class="col-lg-2" style="vertical-align: middle;">MOU</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file" id="mou" name="mou">
                                        <div style="color: black;">*tipe file harus PDF</div>
                                        <div class="error" style="color: red;"><?php if (isset($error_mou)) echo $error_mou;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="text-right">
                            <input type="submit" name="submit" value="Tambah" class="btn btn-success" onclick="javascript: return confirm('Apakah Anda yakin ingin menambahkan data? Lampiran MOU yang sudah ditambahkan tidak dapat diubah.')">
                            <button type="reset" class="btn btn-danger" name="reset" value="ulang">Ulang</button>
                            <a href="kerjasama.php" class="btn btn-dark">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>

<?php include('footer.html') ?>