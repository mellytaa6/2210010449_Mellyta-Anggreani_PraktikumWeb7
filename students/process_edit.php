<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$nis = $_POST['nis'];
$nisn = $_POST['nisn'];
$kelas_id = $_POST['kelas_id'] ? $_POST['kelas_id'] : 'NULL';
$tahun_masuk = $_POST['tahun_masuk'];
$status = $_POST['status'];

$nama_lengkap = $_POST['nama_lengkap'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'] ? $_POST['tanggal_lahir'] : 'NULL';
$jenis_kelamin = $_POST['jenis_kelamin'];
$agama = $_POST['agama'];
$no_telepon = $_POST['no_telepon'];
$email = $_POST['email'];

$alamat = $_POST['alamat'];
$rt_rw = $_POST['rt_rw'];
$kelurahan = $_POST['kelurahan'];
$kecamatan = $_POST['kecamatan'];
$kota = $_POST['kota'];
$provinsi = $_POST['provinsi'];
$kode_pos = $_POST['kode_pos'];

$nama_ayah = $_POST['nama_ayah'];
$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
$nama_ibu = $_POST['nama_ibu'];
$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
$no_telepon_ortu = $_POST['no_telepon_ortu'];

// Handle Photo
$sql_foto = "";
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $upload = uploadImage($_FILES['foto']);
    if (isset($upload['success'])) {
        $foto_name = $upload['success'];
        $sql_foto = ", foto = '$foto_name'";
    } else {
        die($upload['error']);
    }
}

$tgl_sql = ($tanggal_lahir && $tanggal_lahir != 'NULL') ? "'$tanggal_lahir'" : "NULL";

$sql = "UPDATE students SET 
        nis='$nis', 
        nisn='$nisn',
        kelas_id=$kelas_id, 
        tahun_masuk='$tahun_masuk',
        status='$status',
        nama_lengkap='$nama_lengkap', 
        tempat_lahir='$tempat_lahir',
        tanggal_lahir=$tgl_sql,
        jenis_kelamin='$jenis_kelamin', 
        agama='$agama',
        no_telepon='$no_telepon',
        email='$email',
        alamat='$alamat', 
        rt_rw='$rt_rw',
        kelurahan='$kelurahan',
        kecamatan='$kecamatan',
        kota='$kota',
        provinsi='$provinsi',
        kode_pos='$kode_pos',
        nama_ayah='$nama_ayah',
        pekerjaan_ayah='$pekerjaan_ayah',
        nama_ibu='$nama_ibu',
        pekerjaan_ibu='$pekerjaan_ibu',
        no_telepon_ortu='$no_telepon_ortu'
        $sql_foto 
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'EDIT_STUDENT', "Edited student: $nama_lengkap ($nisn)");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>