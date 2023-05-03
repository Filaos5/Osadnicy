<?php 
      session_start();
      require_once "../secure.php";
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
      $czas=time();

    $kawalerzysta_ilosc=(int)$_POST['kawaler_ilosc'];
    if($kawalerzysta_ilosc>0){
    echo "$kawalerzysta_ilosc\n";

    $sql = "SELECT * FROM wojsko WHERE nazwa='Kawalerzysta'";
    if($rezultat2 = @$polaczenie->query($sql))
    {
        $wiersz_kawalerzysta = $rezultat2->fetch_assoc();    
    }
    $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
    if($rezultat = @$polaczenie->query($sql))
    {
        $pobranywiersz = $rezultat->fetch_assoc();
        $pieniadze=$pobranywiersz['pieniadze'];
        $zywnosc=$pobranywiersz['zywnosc'];
        $drewno=$pobranywiersz['drewno'];
        $kamien=$pobranywiersz['kamien'];
        $metal=$pobranywiersz['metal'];       
    }
    $koszt_szkolenie=$wiersz_kawalerzysta['pieniadze']*$kawalerzysta_ilosc; 
    $zywnosc_szkolenie=$wiersz_kawalerzysta['zywnosc']*$kawalerzysta_ilosc;
    $drewno_szkolenie=$wiersz_kawalerzysta['drewno']*$kawalerzysta_ilosc; 
    $kamien_szkolenie=$wiersz_kawalerzysta['kamien']*$kawalerzysta_ilosc; 
    $metal_szkolenie=$wiersz_kawalerzysta['metal']*$kawalerzysta_ilosc;
    $czas_szkolenia=$wiersz_kawalerzysta['czas_szkolenia'];
    $koniec_szkolenia= $czas_szkolenia+$czas;  
    if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
      VALUES ( $kawalerzysta_ilosc, 'kawalerzysta', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
    $polaczenie->query($sql);
    $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
    drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
    $polaczenie->query($sql);  
     }
     else{
      $_SESSION['surowce_malo']=1;
      header('Location: ../stajnia.php');
    }
    }

    $lucznikkon_ilosc=(int)$_POST['lucznikkon_ilosc'];
    if($lucznikkon_ilosc>0){
      echo "$lucznikkon_ilosc\n";
      $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $wiersz = $rezultat->fetch_assoc();
      }
      $sql = "SELECT * FROM wojsko WHERE nazwa='Lucznikkon'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_lucznikkon = $rezultat2->fetch_assoc();    
      }
      $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
      if($rezultat = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat->fetch_assoc();
          $pieniadze=$pobranywiersz['pieniadze'];
          $zywnosc=$pobranywiersz['zywnosc'];
          $drewno=$pobranywiersz['drewno'];
          $kamien=$pobranywiersz['kamien'];
          $metal=$pobranywiersz['metal'];         
      }
      $koszt_szkolenie=$wiersz_lucznikkon['pieniadze']*$lucznikkon_ilosc; 
      $zywnosc_szkolenie=$wiersz_lucznikkon['zywnosc']*$lucznikkon_ilosc;
      $drewno_szkolenie=$wiersz_lucznikkon['drewno']*$lucznikkon_ilosc; 
      $kamien_szkolenie=$wiersz_lucznikkon['kamien']*$lucznikkon_ilosc; 
      $metal_szkolenie=$wiersz_lucznikkon['metal']*$lucznikkon_ilosc;  
      $czas_szkolenia=$wiersz_lucznikkon['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
        VALUES ( $lucznikkon_ilosc, 'lucznikkon', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../stajnia.php');
      }
    }

      $polaczenie->close();
      header('Location: ../stajnia.php');
?>

