<?php 
      session_start();
      require_once "../secure.php";
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
    $karabinmaszynowy_ilosc=(int)$_POST['karabinmaszynowy_ilosc'];
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
      $sql = "SELECT * FROM wojsko WHERE nazwa='Karabinmaszynowy'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_karabinmaszynowy = $rezultat2->fetch_assoc();    
      }
      $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
      if($rezultat = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat->fetch_assoc();          
      }
      $koszt_szkolenie=$wiersz_karabinmaszynowy['pieniadze']*$karabinmaszynowy_ilosc; 
      $zywnosc_szkolenie=$wiersz_karabinmaszynowy['zywnosc']*$karabinmaszynowy_ilosc;
      $drewno_szkolenie=$wiersz_karabinmaszynowy['drewno']*$karabinmaszynowy_ilosc; 
      $kamien_szkolenie=$wiersz_karabinmaszynowy['kamien']*$karabinmaszynowy_ilosc; 
      $metal_szkolenie=$wiersz_karabinmaszynowy['metal']*$karabinmaszynowy_ilosc;  
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "UPDATE wioska SET karabinmaszynowy=karabinmaszynowy+$karabinmaszynowy_ilosc WHERE id=$id_wioski";
      $polaczenie->query($sql);
      $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_uczestnik_zalogowany";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../koszary.php');
      }
      $polaczenie->close();
      header('Location: ../koszary.php');
?>

