<?php
session_start();
require_once('db_login.php');
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit; 
}
?>

<?php include('header.html');
$id = $_GET["id"];
$q2 = mysqli_query($db, " SELECT * FROM tb_kerjasama WHERE id_kerjasama=".$id." ");
while ($hasil = mysqli_fetch_array($q2)){
    $id=$hasil["id_kerjasama"];
    $industri=$hasil["industri"];
    $kompetensi=$hasil["id_kompetensi"];
    $npsn=$hasil["npsn"];
    $tgl_mulai=$hasil["tgl_mulai"];
    $tgl_selesai=$hasil["tgl_selesai"];
    $lingkup=$hasil["lingkup_kerjasama"];
}
if (isset($_POST["submit"])) {
    $valid = TRUE;
    $industri = test_input($_POST['industri']);
    if ($industri == '') {
        $error_industri = "Nama industri harus diisi";
        $valid = FALSE;
    }
    $kompetensi = test_input($_POST['kompetensi']);
    $npsn = test_input($_POST['npsn']);
    if ($npsn == '') {
        $error_npsn = "NPSN harus diisi";
        $valid = FALSE;
    }
    $tgl_mulai = test_input($_POST['tgl_mulai']);
    $tgl_selesai = test_input($_POST['tgl_selesai']);
    $tgl_mulai = date("Y-m-d", strtotime($tgl_mulai));
    $tgl_selesai = date("Y-m-d", strtotime($tgl_selesai));
    $lingkup = test_input($_POST['lingkup_kerjasama']);
    
    
    
    if ($valid){
        $industri = $db->real_escape_string($industri);
        $lingkup = $db->real_escape_string($lingkup);
        $tgl_mulai = $db->real_escape_string($tgl_mulai);
        $tgl_selesai = $db->real_escape_string($tgl_selesai);     

        $query = "UPDATE tb_kerjasama SET 
                    industri='".$industri."', 
                    id_kompetensi=$kompetensi,
                    tgl_mulai='$tgl_mulai',
                    tgl_selesai='$tgl_selesai',
                    lingkup_kerjasama='".$lingkup."'
                  WHERE id_kerjasama='".$id."'";
        #execute query
        $result =$db->query($query);
        if (!$result) {
            die ("could not query the database: <br>".$db->error.'<br>Query:'.$query);
        }
        else {
            echo "<script>window.alert('Data berhasil diubah'); window.location='kerjasama.php'</script>";
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
                                    <li class="breadcrumb-item"><h2>Form Edit Kerjasama Industri</h2></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <form method="POST" autocomplete="on" action="" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="id_kerjasama" name="id_kerjasama" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <div class="row">
                            <label for="nama_industri" class="col-lg-2" style="vertical-align: middle;">Nama Industri</label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="nama_industri" name="industri" value="<?php echo $industri; ?>">
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
                                        <input type="text" class="form-control" id="npsn" name="npsn" value="<?php echo $npsn; ?>" readonly>
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
                                        <input type="date" name="tgl_mulai" id="tgl_mulai" class=" form-control" value="<?php echo $tgl_mulai; ?>">
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
                                        <input type="date" name="tgl_selesai" id="tgl_selesai" class=" form-control" value="<?php echo $tgl_selesai; ?>">
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
                                            <option 
                                                value="Peningkatan kompetensi bidang ketenagalistrikan bagi peserta didik SMK di Provinsi Jateng" 
                                                <?php if(isset($lingkup) && $lingkup=="Peningkatan kompetensi bidang ketenagalistrikan bagi peserta didik SMK di Provinsi Jateng") echo 'selected=="true"'; ?>>
                                                Peningkatan kompetensi bidang ketenagalistrikan bagi peserta didik SMK di Provinsi Jateng
                                            </option>
                                            <option 
                                                value="Pembinaan dan pengembangan sekolah menengah kejuruan berbasis kompetensi melalui program Bright Olimart Academy" 
                                                <?php if(isset($lingkup) && $lingkup=="Pembinaan dan pengembangan sekolah menengah kejuruan berbasis kompetensi melalui program Bright Olimart Academy") echo 'selected=="true"'; ?>>
                                                Pembinaan dan pengembangan sekolah menengah kejuruan berbasis kompetensi melalui program Bright Olimart Academy
                                            </option>
                                            <option 
                                                value="Pengembangan dan penyelarasan kurikulum pembelajaran sesuai kebutuhan industri ketenagalistrikan" 
                                                <?php if(isset($lingkup) && $lingkup=="Pengembangan dan penyelarasan kurikulum pembelajaran sesuai kebutuhan industri ketenagalistrikan") echo 'selected=="true"'; ?>>
                                                Pengembangan dan penyelarasan kurikulum pembelajaran sesuai kebutuhan industri ketenagalistrikan
                                            </option>
                                            <option 
                                                value="Dukungan proses pembelajaran dan praktek kerja lapangan (magang) bagi guru dan peserta didik SMK" 
                                                <?php if(isset($lingkup) && $lingkup=="Dukungan proses pembelajaran dan praktek kerja lapangan (magang) bagi guru dan peserta didik SMK") echo 'selected=="true"'; ?>>
                                                Dukungan proses pembelajaran dan praktek kerja lapangan (magang) bagi guru dan peserta didik SMK
                                            </option>
                                            <option 
                                                value="Fasilitasi uji kompetensi (sertifikasi)" 
                                                <?php if(isset($lingkup) && $lingkup=="Fasilitasi uji kompetensi (sertifikasi)") echo 'selected=="true"'; ?>>
                                                Fasilitasi uji kompetensi (sertifikasi)
                                            </option>
                                            <option 
                                                value="Fasilitasi sarana dan prasarana pembelajaran yang terkait dengan metode praktek" 
                                                <?php if(isset($lingkup) && $lingkup=="Fasilitasi sarana dan prasarana pembelajaran yang terkait dengan metode praktek") echo 'selected=="true"'; ?>>
                                                Fasilitasi sarana dan prasarana pembelajaran yang terkait dengan metode praktek
                                            </option>
                                            <option 
                                                value="Peningkatan kompetensi bidang pembangkit tenaga listrik bagi peserta didik SMK" 
                                                <?php if(isset($lingkup) && $lingkup=="Peningkatan kompetensi bidang pembangkit tenaga listrik bagi peserta didik SMK") echo 'selected=="true"'; ?>>
                                                Peningkatan kompetensi bidang pembangkit tenaga listrik bagi peserta didik SMK
                                            </option>
                                            <option 
                                                value="Peningkatan kompetensi bidang ketenagalistrikan bagi peserta didik SMK di Provinsi Jateng" 
                                                <?php if(isset($lingkup) && $lingkup=="Peningkatan kompetensi bidang ketenagalistrikan bagi peserta didik SMK di Provinsi Jateng") echo 'selected=="true"'; ?>>
                                                Peningkatan kompetensi bidang ketenagalistrikan bagi peserta didik SMK di Provinsi Jateng
                                            </option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-actions">
                        <div class="text-right">
                            <input type="submit" name="submit" value="Edit" class="btn btn-success">
                            <button type="reset" class="btn btn-danger" name="reset" value="ulang">Ulang</button>
                            <a href="kerjasama.php" class="btn btn-dark">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>

<script>
        function previewPdf() {
            const pdf = document.getElementById('file');
            const pdf_title = document.getElementById('pdfTitle');
            const preview_pdf = document.getElementById('pdfViewer');

            const file_pdf = new FileReader();
            file_pdf.readAsDataURL(pdf.files[0]);
            pdf_title.innerText = pdf.files[0].name;
           
        }
    </script>

</html>

<?php include('footer.html') ?>