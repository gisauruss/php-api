<?php 

include "koneksi.php";

if(function_exists($_GET['function'])){
    $_GET['function']();
}

// untuk menampilkan data

function tampilData(){
    global $koneksi;

    $sql = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object($sql)){
            $user[] = $data;
    }

    $respon = array(
        'status' => 200,
        'pesan' => 'berhasil menampilkan data',
        'users' => $user
    );

    header('Content-type: application/json');
    print json_encode($respon);
}

// menambahkan data

function tambahData(){
    global $koneksi;

    $isi = array(
        'nama' => '',
        'alamat' => '',
        'no_telp' => ''
    );

    $cek = count( array_intersect_key($_POST, $isi));

    if($cek == count ($isi)){
        $nama = $_POST ['nama'];
        $alamat = $_POST ['alamat'];
        $no_telp = $_POST ['no_telp'];

        $hasil = mysqli_query($koneksi, "INSERT INTO users VALUES ('', '$nama', '$alamat', '$no_telp')");

        if($hasil){
            return pesan(1, "berhasil memasukkan data $nama");
        }else{
            return pesan(0, "gagal menambahkan data $nama");
        }
    }else{
        return pesan(0, "gagal memnambahkan data, parameter salah");
    }
    
}

function pesan($status, $pesan){
    $respon = array(
        'status' => $status,
        'pesan' => $pesan
    );

    header('Content-type: application/json');
    print json_encode($respon);
}

// mengedit data

function editData(){
    global $koneksi;

    // untuk mengecek id ada atau tidak
    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $isi = array(
        'nama' => '',
        'alamat' => '',
        'no_telp' => ''
    );

    $cek = count(array_intersect_key($_POST, $isi));

    if($cek == count($isi)){
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        $sql = mysqli_query($koneksi, "UPDATE users set id='$id', nama='$nama', alamat='$alamat', no_telp='$no_telp' where id='$id'");

        if($sql){
            return pesan(1, "berhasil mengedit data $nama");
        }else{
            return pesan(0, "gagal mengubah data $nama");
        }
    }else{
        return pesan(0, "gagal mengubah data, paramter salah");
    }
}

// menghapus data

function hapusData(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $sql = mysqli_query($koneksi, "DELETE FROM users WHERE id='id'");

    if($sql){
        return pesan(1, "berhasil menghapus data");
    }else{
        return pesan(0, "gagal menghapus data");
    }
}

// mrnampilakn detail data

function detailData(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $sql = mysqli_query($koneksi, "SELECT * from users where id='$id'");
    $data = mysqli_fetch_object($sql);

    $respon = array(
        'status' => 200,
        'pesan' => 'berhasil menampilkan data',
        'user' => $data
    );

    header('Content-type: application/json');
    print json_encode($respon);
}