<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "rental_mobil";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$Id_Pegawai = "";
$Nama       = "";
$Alamat     = "";
$No_Telp    = "";

$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $Id_Pegawai = $_GET['id'];
    $sql1       = "delete from Pegawai where Id_Pegawai = '$Id_Pegawai'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $Id_Pegawai = $_GET['id'];
    $sql1       = "select * from Pegawai where Id_Pegawai = '$Id_Pegawai'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $Nama       = $r1['Nama'];
    $Alamat     = $r1['Alamat'];
    $No_Telp    = $r1['No_Telp'];

    if ($Nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $Nama       = $_POST['nama'];
    $Alamat     = $_POST['alamat'];
    $No_Telp    = $_POST['no_telp'];

    if ($Nama && $Alamat && $No_Telp) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update Pegawai set Nama='$Nama', Alamat = '$Alamat', No_Telp = '$No_Telp' where Id_Pegawai = '$Id_Pegawai'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into Pegawai(Nama, Alamat, No_Telp) values ('$Nama', '$Alamat', '$No_Telp')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <br>
        <a href="http://127.0.0.1:5500/LandingPage.html"><button class="btn btn-primary" >❮ Kembali ke halaman utama</button></a>
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Create / Edit Pegawai
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;url=Pegawai.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:3;url=Pegawai.php");
                }
                ?>
                <form action="" method="POST">

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $Nama ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $Alamat ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="no_telp" class="col-sm-2 col-form-label">No Telp</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $No_Telp ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Pegawai
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No Telp</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from Pegawai";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $Id_Pegawai         = $r2['Id_Pegawai'];
                            $Nama               = $r2['Nama'];
                            $Alamat             = $r2['Alamat'];
                            $No_Telp             = $r2['No_Telp'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $Id_Pegawai ?></th>
                                <td scope="row"><?php echo $Nama ?></td>
                                <td scope="row"><?php echo $Alamat ?></td>
                                <td scope="row"><?php echo $No_Telp ?></td>
                                <td scope="row">
                                    <a href="Pegawai.php?op=edit&id=<?php echo $Id_Pegawai ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="Pegawai.php?op=delete&id=<?php echo $Id_Pegawai?>" onclick="return confirm('Yakin?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>