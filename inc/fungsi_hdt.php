<?php
function sukses_masuk($username,$pass){
	// Apabila username dan password ditemukan
	$login=_query("SELECT * FROM user WHERE user='$username' AND pass='$pass' AND blokir='N'");
	$ketemu=_num_rows($login);
	$r=_fetch_array($login);
	if ($ketemu > 0){
        include "timeout.php";
        $_SESSION['id']     = $r['id_user'];
        $_SESSION['username']     = $r['user'];
        $_SESSION['passuser']     = $r['pass'];
        $_SESSION['level']    = $r['level'];
        $_SESSION['nama']    = $r['nama'];

        if ($r['level'] == "admin-kelurahan")
        {  header('location:admin-kelurahan/?module=home');
        }
        else if ($r['level'] == "admin-kecamatan")
        { header('location:admin-kecamatan/?module=home');
        }
        else if ($r['level'] == "admin")
        { header('location:admin/?module=home');
        }
		// session timeout
		$_SESSION['login'] = 1;
		timer();
	}
	return false;
}

function msg(){
  echo "<link href='css/screen.css' rel='stylesheet' type='text/css'>
  <link href='css/reset.css' rel='stylesheet' type='text/css'>
  <link href='css/style_button.css' rel='stylesheet' type='text/css'>
  <center><br><br><br><br><br><br>Maaf, silahkan cek kembali <b>Username</b> dan <b>Password</b> Anda<br><br>Kesalahan $_SESSION[salah]";
  echo "<div> <a href='index.php'><img src='images/kunci.png'  height=176 width=176></a>
  </div>";
  echo "<input type=button class='button buttonblue mediumbtn' value='KEMBALI' onclick=location.href='index.php'></a></center>";
  return false;
}

function salah_blokir($username){
  echo "<link href='css/screen.css' rel='stylesheet' type='text/css'>
  <link href='css/reset.css' rel='stylesheet' type='text/css'>
  <link href='css/style_button.css' rel='stylesheet' type='text/css'>
  <center><br><br><br><br><br><br>Maaf, Username <b>$username</b> telah <b>TERBLOKIR</b>, silahkan hubungi Administrator.";
  echo "<div style=''> <a href='index.php'><img src='images/kunci.png'  height=176 width=176></a>
  </div>";
  echo "<input type=button class='button buttonblue mediumbtn' value='KEMBALI' onclick=location.href='index.php'></a></center>";
  return false;
}
function salah_username($username){
  echo "<link href='css/screen.css' rel='stylesheet' type='text/css'>
  <link href='css/reset.css' rel='stylesheet' type='text/css'>
  <link href='css/style_button.css' rel='stylesheet' type='text/css'>
  <center><br><br><br><br><br><br>Maaf, Username <b>$username</b> tidak dikenal.";
  echo "<div> <a href='index.php'><img src='images/kunci.png'  height=176 width=176></a>
  </div>";
  echo "<input type=button class='button buttonblue mediumbtn' value='KEMBALI' onclick=location.href='index.php'></a></center>";	
  return false;
}

function salah_password(){
  echo "<link href='css/screen.css' rel='stylesheet' type='text/css'>
  <link href='css/reset.css' rel='stylesheet' type='text/css'>
  <link href='css/style_button.css' rel='stylesheet' type='text/css'>
  <center><br><br><br><br><br><br>Maaf, silahkan cek kembali <b>Password</b> Anda<br><br>Kesalahan $_SESSION[salah]";
  echo "<div> <a href='index.php'><img src='images/kunci.png'  height=176 width=176></a>
  </div>";
  echo "<input type=button class='button buttonblue mediumbtn' value='KEMBALI' onclick=location.href='index.php'></a></center>";
   return false;
}

function blokir($username){
//	_query($sql);
	session_destroy();
	 return false;
}    


//mengambil status benfit/cost dari tabel kriteria
function getStatusKriteria($idkriteria){
  $q = _query("SELECT * FROM kriteria where id_kriteria = '$idkriteria'");
  $d = _fetch_array($q);
  return $d['tipe_kriteria'];
}

function getBobotKriteria($idkriteria){
  $q = _query("SELECT * FROM kriteria where id_kriteria = '$idkriteria'");
  $d = _fetch_array($q);
  return round($d['bobot']/100, 2);
}

function GetMaxMinArray($arraydata,$kriteria, $status){
  $arrayTemp = array();
  foreach($arraydata as $value){
      $arrayTemp[] = $value[$kriteria];
  }
  if(strtolower($status) == 'benefit')
      return max($arrayTemp);
  return min($arrayTemp);
}

//pada tahap 2 saw akan ada normalisasi
//fungsi ini dgunakan untuk menghitung normalisasi dari tiap-tiap data
function GetNormalisasi($data, $maxmin, $status){
  if(strtolower($status) == 'benefit'){
      return round( $data / $maxmin, 2);
  }else{
      return round($maxmin / $data, 2);
  }
}
?>