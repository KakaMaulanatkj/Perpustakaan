<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "perpustakaan";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$id             = "";
$nama           = "";
$kelas          = "";
$jurusan        = "";
$error          = "";
$sukses         = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from peminjaman where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
        header('location:home-page.php');
    }else{
        $error  = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from peminjaman where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $id         = $r1['id'];
    $nama       = $r1['nama'];
    $kelas      = $r1['kelas'];
    $jurusan    = $r1['jurusan'];

    if ($id == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { //untuk create
    $id         = $_POST['id'];
    $nama       = $_POST['nama'];
    $kelas      = $_POST['kelas'];
    $jurusan    = $_POST['jurusan'];

    if ($id && $nama && $kelas && $jurusan) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update peminjaman set id = '$id',nama = '$nama',kelas = '$kelas',jurusan = '$jurusan' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
                header('location:home-page.php');
            } else {
                $error  = "Data gagal diupdate";
            }
            
        } else { //untuk insert
            $sql1 = "insert into peminjaman(id,nama,kelas,jurusan) values ('$id','$nama','$kelas','$jurusan')";
            $q1   = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
                header('location:home-page.php');
            } else{
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}
?>