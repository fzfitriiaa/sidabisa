<?php
session_start();
include('header.html');
$_SESSION['login'];

unset($_SESSION['login']);
session_unset();
session_destroy();
echo "<script type='text/javascript'>
setTimeout(function (){
    swal({
        title: 'Logout berhasil!',
        text: 'Anda telah logout',
        icon: 'success',
    });
},1);
window.setTimeout(function(){
    window.location.replace('login.php');
} ,1000);
</script>";
?>