<?php
include "cart.php";
/* api function */
include "lib/apifunction.php";

include "lib/koneksi.php";
//session_start();

$item = $_SESSION['items'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
// insert ke pelanggan
//$qsimpanpelanggan = mysqli_query($koneksi, "insert into pelanggan values username, passwrod, nama, alamat, email, no_hp");

// insert ke jual
// mysqli_insert_id();

// Ini harus di kasih if biar misal gk ada yg ngirim method POST gk unidentified
// jadi kalo gk ada data POST nama pelanggan nanti balik ke page sebelumnya

if(!isset($_POST['nama_member'])){

  $host = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? 'http://localhost:8080/badrun_junior/index.php' : 'http://'.$_SERVER['HTTP_HOST'];
  header('Location: index.php');

}

// jika misal user udah login langsung aja kesini
if(isset($_SESSION['namauser'])){

  $idMember=$_SESSION['id_member'];
  $queryEdit=mysqli_query($koneksi, "SELECT * FROM member WHERE id_member='$idMember'");

  $hasilQuery=mysqli_fetch_array($queryEdit);

  $nama=$hasilQuery['namaMember'];
  $email=$hasilQuery['email'];
  $alamat=$hasilQuery['alamat'];
  $noHP=$hasilQuery['no_hp'];

}

$tgl_skrg = date("Y-m-d");
$nama = isset($_SESSION['namauser']) ? $nama : $_POST['nama_member'];
$alamat = isset($_SESSION['namauser']) ? $alamat : $_POST['alamat'];
$email = isset($_SESSION['namauser']) ? $email : $_POST['email'];
$nohp = isset($_SESSION['namauser']) ? $noHP : $_POST['no_hp'];

$qsimpanjual = mysqli_query($koneksi, "insert into jual (status, tgl_jual, nama, alamat, email, no_hp) values ('On Process', '$tgl_skrg', '$nama', '$alamat', '$email', '$nohp')")
or die(mysqli_error($koneksi));


$id_jual=mysqli_insert_id($koneksi);

$query = mysqli_query($koneksi, "select * from jual where id_jual = '$id_jual'");
$invoiceData = mysqli_fetch_array($query);

//echo $id_order;

    //print_r($item);
    //exit();   
 // insert ke detail jual

foreach ($_SESSION['items'] as $idProduk => $val) {

  $query = mysqli_query($koneksi, "select * from produk where id_produk = '$idProduk'");
  $data = mysqli_fetch_array($query);
  $produk=$data['id_produk'];
  $jumlah_harga = $data['harga'] * $val;
            //$total += $jumlah_harga;
            //$no = 1;

           // mysqli_query($koneksi, "insert into detail_jual (id_jual) values ('$id_order')");
  mysqli_query($koneksi, "insert into detail_jual (id_jual, id_produk, jumlah, harga) values ('$id_jual', '$produk', '$val','$jumlah_harga')");

}

            // insert sendMail(lib/helpers.php) function here
            // definisikan var input utk parameter fungsi sendMail
            /*$html = '
              <h3>Order Details</h3>
              <table border="1">
                <caption>Customer Details</caption>
                <tr>
                  <td>Nama</td>
                  <td>E-mail</td>
                  <td>Code Transaksi</td>
                  <td>Tanggal Transaksi</td>
                </tr>
                <tr>
                  <td>'.$invoiceData['nama'].'</td>
                  <td>'.$invoiceData['email'].'l</td>
                  <td>'.$invoiceData['id_jual'].'</td>
                  <td>'.$invoiceData['tgl_jual'].'</td>
                </tr>
              </table>
              <table border="1">
                <caption>Items Details</caption>
                <tr>
                  <td>Nama</td>
                  <td>Harga</td>
                  <td>Qty</td>
                  <td>Sub-total</td>
                </tr>
                ';*/

                $total = 0;
                foreach ($_SESSION['items'] as $idProduk => $val) {

                  $query = mysqli_query($koneksi, "select * from produk where id_produk = '$idProduk'");
                  $data = mysqli_fetch_array($query);
                  $jumlah_harga = $data['harga'] * $val;
                  $total = $jumlah_harga + $total;

                }

                $nohp = $_POST['no_hp'];
                $pesan = 'Terima kasih telah berbelanja di toko kami dengan nomer Transaksi '.$invoiceData[id_jual].' silahkan melanjutkan ke tahap pembayaran sebesar Rp. '.$_POST['total'].' dan bisa dikirimkan melalui Rekening BCA cirebon dengan nomer rekening 9078796759 atas nama badrun junior, dan harap mengirim bukti pembayaran melau link ini badrunjunior@gmail.com dengan subject nomer Transaksi ';

            // fungsi sendmail mempunyai nilai kembalian berupa boolean(true/false)
                //$response = sendsms($nohp, $pesan);

                //untuk mengetahui pesan sudah terkirim atau belum
                // if ($response == 'OK') echo "<p>SMS telah dikirim</p>";
                // else if ($response == 'USERNAME INVALID') echo "<p>Username API salah</p>";
                // else if ($response == 'API KEY INVALID') echo "<p>API Key salah</p>";
                // else if ($response == 'UNSUFFICIENT SMS TOKENS') echo "<p>Token SMS tidak cukup</p>";

                session_destroy();

           //header('location:selesai.php');

                include "template/header.php";
//include "pages/main_selesai.php";
                ?>
                <div id="wrapper">

                  <!-- start: Container -->
                  <div class="container">

                    <!-- start: Table -->
                    <div class="table-responsive">
                     <div class="title"><h3>Checkout Selesai</h3></div>
                     <div class="hero-unit">Selamat Anda telah berhasil checkout, silahkan catat info di bawah ini..</div>
                     <div class="hero-unit">
                      <?php
      //if($_POST['finish']){
                      session_destroy();
                      echo 'Terima kasih Anda sudah berbelanja di Toko Online kami dan berikut ini adalah data yang perlu Anda catat.';
                      echo 'nomer id Transaksi anda adalah : ';
                      echo $id_jual;
                      echo '<p>Total biaya untuk pembelian Produk adalah <b>Rp. '.$_POST['total'].',-</b> dan biaya bisa di kirimkan melalui Rekening Bank BCA cabang Cikarang dengan nomor rekening 634567978 atas nama badrun junior.</p>';
                      echo '<p>Dan barang akan kami kirim ke alamat di bawah ini:</p>';
                      echo '<p>Nama Lengkap : <b>'.$_POST['nama_member'].'</b><br>';
                      echo 'Email : <b>'.$_POST['email'].'</b><br>';
                      echo 'Alamat : '.$_POST['alamat'].'<br>';
                      echo 'No Telepon : '.$_POST['no_hp'].'<br>';
                      echo 'Total Belanja : Rp. '.$_POST['total'].',-</p>';
      //////}else{
      //  header("Location: index.php");
      //}
                      ?>
                    </div>

                    <!-- end: Table -->
                  </div>
                  <!-- end: Container -->

                </div>
                <?php include "template/footer.php";
                ?>