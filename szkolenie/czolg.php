<?php 
      session_start();
      require_once "../secure.php";
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
    $czolg_ilosc=(int)$_POST['czolg_ilosc'];
      $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $wiersz = $rezultat->fetch_assoc();
          $pieniadze=$wiersz['pieniadze'];
          $zywnosc=$wiersz['zywnosc'];
          $drewno=$wiersz['drewno'];
          $kamien=$wiersz['kamien'];
          $metal=$wiersz['metal'];
      }
      $sql = "SELECT * FROM wojsko WHERE nazwa='Czolg'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_czolg = $rezultat2->fetch_assoc();    
      }
      $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
      if($rezultat = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat->fetch_assoc();          
      }
      $koszt_szkolenie=$wiersz_czolg['pieniadze']*$czolg_ilosc; 
      $zywnosc_szkolenie=$wiersz_czolg['zywnosc']*$czolg_ilosc;
      $drewno_szkolenie=$wiersz_czolg['drewno']*$czolg_ilosc; 
      $kamien_szkolenie=$wiersz_czolg['kamien']*$czolg_ilosc; 
      $metal_szkolenie=$wiersz_czolg['metal']*$czolg_ilosc;  
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "UPDATE wioska SET czolg=czolg+$czolg_ilosc WHERE id=$id_wioski";
      $polaczenie->query($sql);
      $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_uczestnik_zalogowany";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../fabryka.php');
      }
      $polaczenie->close();
      header('Location: ../fabryka.php');
?>

