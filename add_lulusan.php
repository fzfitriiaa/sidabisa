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

<?php include('header.html') ?>
<?php
ini_set('display_errors', '1');

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
    $bkk = test_input(isset($_POST['bkk']) ? $_POST['bkk'] : '');
    if ($bkk == '') {
        $error_bkk = "Field ini harus diisi";
        $valid = FALSE;
    }
    $jml_lulusan_txt = test_input($_POST['jml_lulusan_txt']);
    if ($jml_lulusan_txt == '') {
        $error_jml_lulusan_txt = "Jumlah lulusan harus diisi";
        $valid = FALSE;
    }
    $jml_lulusan = test_input(isset($_POST['total_lulusan']) ? $_POST['total_lulusan'] : '');
    if ($jml_lulusan == '') {
        $error_jml_lulusan = "Total jumlah lulusan harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_lulusan)){
        $error_jml_lulusan = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $jml_industri = test_input($_POST['jml_industri']);
    if ($jml_industri == '') {
        $error_jml_industri = "Jumlah lulusan yang ke industri harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_industri)){
        $error_jml_industri = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $jml_univ = test_input($_POST['jml_univ']);
    if ($jml_univ == '') {
        $error_jml_univ = "Jumlah lulusan yang ke univ harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_univ)){
        $error_jml_univ = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $jml_wirausaha = test_input($_POST['jml_wirausaha']);
    if ($jml_wirausaha == '') {
        $error_jml_wirausaha = "Jumlah lulusan yang berwirausaha harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_wirausaha)){
        $error_jml_wirausaha = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $jml_nganggur = test_input($_POST['jml_nganggur']);
    if ($jml_nganggur == '') {
        $error_jml_nganggur = "Jumlah lulusan yang menganggur harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_nganggur)){
        $error_jml_nganggur = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $terserapan = test_input($_POST['jml_serapan']);
    if ($terserapan == '') {
        $error_terserapan = "Jumlah keterserapan harus diisi";
        $valid = FALSE;
    }
    $jml_sesuai = test_input($_POST['jml_sesuai_kompetensi']);
    if ($jml_sesuai == '') {
        $error_jml_sesuai = "Jumlah lulusan yang sesuai kompetensi harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_sesuai)){
        $error_jml_sesuai = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $jml_tidak = test_input($_POST['jml_tdk_sesuai_kompetensi']);
    if ($jml_tidak == '') {
        $error_jml_tidak = "Jumlah lulusan yang tidak sesuai kompetensi harus diisi";
        $valid = FALSE;
    }
    elseif(!preg_match("/^[0-9]*$/", $jml_tidak)){
        $error_jml_tidak = "Hanya dapat memasukkan angka";
        $valid = FALSE;
    }
    $kerjasama = test_input($_POST['kerjasama_industri']);
    if ($kerjasama == '') {
        $error_kerjasama = "Nama Industri harus diisi";
        $valid = FALSE;
    }
    
    if ($valid){
        $bkk = $db->real_escape_string($bkk);
        $terserapan = $db ->real_escape_string($terserapan);
        $kerjasama = $db->real_escape_string($kerjasama);
        
        $query = " INSERT INTO tb_keterserapan(npsn,bkk,jml_lulusan_txt,total_lulusan,jml_industri,jml_univ,jml_wirausaha,jml_nganggur,jml_serapan,
                 jml_sesuai_kompetensi,jml_tdk_sesuai_kompetensi,kerjasama_industri)
                 VALUES($npsn,'".$bkk."','".$jml_lulusan_txt."',$jml_lulusan,$jml_industri,$jml_univ,$jml_wirausaha,$jml_nganggur,'".$terserapan."',
                 $jml_sesuai,$jml_tidak,'".$kerjasama."')";
        #execute query
        $result =$db->query($query);
        if (!$result) {
            die ("could not query the database: <br>".$db->error.'<br>Query:'.$query);
        }
        else {
            echo "<script>window.alert('Data berhasil ditambahkan'); window.location='lulusan.php'</script>";
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
                                    <li class="breadcrumb-item"><h2>Form Tambah Keterserapan Lulusan</h2></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <form method="POST" autocomplete="on" action="">
                    <div class="form-group">
                        <label for="npsn" class="col-lg-9" style="vertical-align: middle;">NPSN</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="npsn" name="npsn" value="<?php echo $baris['npsn']; ?>">
                                <div class="error"><?php if (isset($error_npsn)) echo $error_npsn;?></div>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="bkk" class="col-lg-9" style="vertical-align: middle;">Apakah sekolah saudara sudah memiliki BKK(Bursa Kerja Khusus)? <br></label>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bkk"
                                        id="bkk" value="sudah">
                                    <label class="form-check-label" for="bkk">Sudah</label>
                            </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bkk"
                                        id="bkk" value="belum">
                                    <label class="form-check-label" for="sbkk">Belum</label>
                                </div>
                                <div class="error" style="color: red;"><?php if (isset($error_bkk)) echo $error_bkk;?></div>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="jml_lulusan_txt" class="col-lg-9" style="vertical-align: middle;">Berapa tamatan lulusan tiap program keahlian saudara?</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="jml_lulusan_txt" name="jml_lulusan_txt">
                                <div class="error" style="color: red;"><?php if (isset($error_jml_lulusan_txt)) echo $error_jml_lulusan_txt;?></div>
                            </div>
                </div>
                    <div class="form-group">
                        <label for="jml_industri" class="col-lg-9" style="vertical-align: middle;">Jumlah Tamatan Lulusan yang masuk ke industri, </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="jml_industri" name="jml_industri">
                                <div class="error" style="color: red;"><?php if (isset($error_jml_industri)) echo $error_jml_industri;?></div>
                            </div>
                    </div>
                    <div class="form-group"> 
                        <label for="jml_univ" class="col-lg-9" style="vertical-align: middle;">Tamatan lulusan yang masuk universitas, </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="jml_univ" name="jml_univ">
                                <div class="error" style="color: red;"><?php if (isset($error_jml_univ)) echo $error_jml_univ;?></div>
                            </div>
                    </div>
                    <div class="form-group"> 
                            <label for="jml_wirausaha" class="col-lg-9" style="vertical-align: middle;">Tamatan lulusan yang berwirausaha, </label>
                                    <div class="col-md-6">
                                        <input type="textarea" class="form-control" id="jml_wirausaha" name="jml_wirausaha">
                                        <div class="error" style="color: red;"><?php if (isset($error_jml_wirausaha)) echo $error_jml_wirausaha;?></div>
                                    </div>
                    </div>
                    <div class="form-group"> 
                            <label for="jml_nganggur" class="col-lg-9" style="vertical-align: middle;">Tamatan lulusan yang menganggur </label>
                                    <div class="col-md-6">
                                        <input type="textarea" class="form-control" id="jml_nganggur" name="jml_nganggur">
                                        <div class="error" style="color: red;"><?php if (isset($error_jml_nganggur)) echo $error_jml_nganggur;?></div>
                                    </div>
                    </div>
                    <div class="form-group">
                        <label for="jml_industri" class="col-lg-9" style="vertical-align: middle;">Total jumlah lulusan </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="total_lulusan" name="total_lulusan">
                                <div class="error" style="color: red;"><?php if (isset($error_jml_lulusan)) echo $error_jml_lulusan;?></div>
                            </div>
                    </div>
                    <div class="form-group"> 
                        <label for="jml_lulusan" class="col-lg-9" style="vertical-align: middle;">Berapa Keterserapan Lulusan pada Tiap Program Keahlian? </label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="jml_serapan" name="jml_serapan" rows="5"
                                placeholder="dituliskan sesuai jumlah lulusan per program keahlian, contoh :
Tata Boga:
Industri=8
Universitas=2
Wirausaha=10
menganggur=0
Rekayasa Perangkat Lunak
Industri=10
Universitas=20
Wirausaha=5
Menganggur=5"></textarea>
                                <div class="error" style="color: red;"><?php if (isset($error_terserapan)) echo $error_terserapan;?></div>
                            </div>
                    </div>
                    <div class="form-group"> 
                        <label for="jml_lulusan" class="col-lg-9" style="vertical-align: middle;">Berapa jumlah lulusan yang diterima di industri yang sesuai kompetensi? </label>
                            <div class="col-md-6">
                                <input type="textarea" class="form-control" id="jml_sesuai_kompetensi" name="jml_sesuai_kompetensi">
                                <div class="error" style="color: red;"><?php if (isset($error_jml_sesuai)) echo $error_jml_sesuai;?></div>
                            </div>
                    </div>
                    <div class="form-group"> 
                        <label for="jml_lulusan" class="col-lg-9" style="vertical-align: middle;">Berapa jumlah lulusan yang diterima di industri yang tidak sesuai kompetensi? </label>
                            <div class="col-md-6">
                                <input type="textarea" class="form-control" id="jml_tdk_sesuai_kompetensi" name="jml_tdk_sesuai_kompetensi">
                                <div class="error" style="color: red;"><?php if (isset($error_jml_tidak)) echo $error_jml_tidak;?></div>
                            </div>
                    </div>
                    <div class="form-group"> 
                        <label for="jml_lulusan" class="col-lg-9" style="vertical-align: middle;">Industri yang diajak kerjasama</label>
                            <div class="col-md-6">
                                <input type="textarea" class="form-control" id="kerjasama_industri" name="kerjasama_industri">
                                <div class="error" style="color: red;"><?php if (isset($error_kerjasama)) echo $error_kerjasama;?></div>
                            </div>
                    </div>
                    <div class="form-actions">
                        <div class="text-right">
                            <input type="submit" name="submit" value="Tambah" class="btn btn-success">
                            <button type="reset" class="btn btn-danger" value="ulang">Ulang</button>
                            <a href="lulusan.php" class="btn btn-dark">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>

<?php include('footer.html') ?>