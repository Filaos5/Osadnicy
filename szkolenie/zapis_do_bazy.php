<?php 
      session_start();
      require_once "../secure.php";
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
      $czas=time();
    $miecznik_ilosc=(int)$_POST['miecz_ilosc'];
    if($miecznik_ilosc>0){
    $jednostka=1;
    echo "$jednostka\n";
    echo "$miecznik_ilosc\n";
    $sql = "SELECT * FROM wojsko WHERE nazwa='Miecznik'";
    if($rezultat2 = @$polaczenie->query($sql))
    {
        $wiersz_miecznik = $rezultat2->fetch_assoc();    
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
    $koszt_szkolenie=$wiersz_miecznik['pieniadze']*$miecznik_ilosc; 
    $zywnosc_szkolenie=$wiersz_miecznik['zywnosc']*$miecznik_ilosc;
    $drewno_szkolenie=$wiersz_miecznik['drewno']*$miecznik_ilosc; 
    $kamien_szkolenie=$wiersz_miecznik['kamien']*$miecznik_ilosc; 
    $metal_szkolenie=$wiersz_miecznik['metal']*$miecznik_ilosc;
    $czas_szkolenia=$wiersz_miecznik['czas_szkolenia'];
    $koniec_szkolenia= $czas_szkolenia+$czas;
    if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
    $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
            VALUES ( $miecznik_ilosc, 'miecznik', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
    $polaczenie->query($sql);
    $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
    drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
    $polaczenie->query($sql);  
     }
     else{
      $_SESSION['surowce_malo']=1;
      header('Location: ../koszary.php');
    }
  
  }
    $lucznik_ilosc=(int)$_POST['luk_ilosc'];
    if($lucznik_ilosc>0)
    $jednostka=2;
    echo "$jednostka\n";
    echo "$lucznik_ilosc\n";
    if($lucznik_ilosc>0){
      $jednostka=1;
      echo "$jednostka\n";
      echo "$miecznik_ilosc\n";

      $sql = "SELECT * FROM wojsko WHERE nazwa='Lucznik'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_lucznik = $rezultat2->fetch_assoc();    
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
      $koszt_szkolenie=$wiersz_lucznik['pieniadze']*$lucznik_ilosc; 
      $zywnosc_szkolenie=$wiersz_lucznik['zywnosc']*$lucznik_ilosc;
      $drewno_szkolenie=$wiersz_lucznik['drewno']*$lucznik_ilosc; 
      $kamien_szkolenie=$wiersz_lucznik['kamien']*$lucznik_ilosc; 
      $metal_szkolenie=$wiersz_lucznik['metal']*$lucznik_ilosc;  
      $czas_szkolenia=$wiersz_lucznik['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
        VALUES ( $lucznik_ilosc, 'lucznik', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../koszary.php');
      }
    }



    $karabin_ilosc=(int)$_POST['karabin_ilosc'];
    if($karabin_ilosc>0){
    $jednostka=3;
    echo "$jednostka\n";
    echo "$karabin_ilosc\n";

    $sql = "SELECT * FROM wojsko WHERE nazwa='Karabin'";
    if($rezultat2 = @$polaczenie->query($sql))
    {
        $wiersz_karabin = $rezultat2->fetch_assoc();    
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
    $koszt_szkolenie=$wiersz_karabin['pieniadze']*$karabin_ilosc; 
    $zywnosc_szkolenie=$wiersz_karabin['zywnosc']*$karabin_ilosc;
    $drewno_szkolenie=$wiersz_karabin['drewno']*$karabin_ilosc; 
    $kamien_szkolenie=$wiersz_karabin['kamien']*$karabin_ilosc; 
    $metal_szkolenie=$wiersz_karabin['metal']*$karabin_ilosc;  
    $czas_szkolenia=$wiersz_karabin['czas_szkolenia'];
    $koniec_szkolenia= $czas_szkolenia+$czas;
    if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
      VALUES ( $karabin_ilosc, 'karabin', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
    $polaczenie->query($sql);
    $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
    drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
    $polaczenie->query($sql);  
     }
     else{
      $_SESSION['surowce_malo']=1;
      header('Location: ../koszary.php');
    }
    }

    $karabinmaszynowy_ilosc=(int)$_POST['karabinmaszynowy_ilosc'];
    if($karabinmaszynowy_ilosc>0){
    $jednostka=4;
    echo "$jednostka\n";
    echo "$karabinmaszynowy_ilosc\n";

    $sql = "SELECT * FROM wojsko WHERE nazwa='Karabinmaszynowy'";
    if($rezultat2 = @$polaczenie->query($sql))
    {
        $wiersz_karabinmaszynowy = $rezultat2->fetch_assoc();    
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
    $koszt_szkolenie=$wiersz_karabinmaszynowy['pieniadze']*$karabinmaszynowy_ilosc; 
    $zywnosc_szkolenie=$wiersz_karabinmaszynowy['zywnosc']*$karabinmaszynowy_ilosc;
    $drewno_szkolenie=$wiersz_karabinmaszynowy['drewno']*$karabinmaszynowy_ilosc; 
    $kamien_szkolenie=$wiersz_karabinmaszynowy['kamien']*$karabinmaszynowy_ilosc; 
    $metal_szkolenie=$wiersz_karabinmaszynowy['metal']*$karabinmaszynowy_ilosc;  
    $czas_szkolenia=$wiersz_karabinmaszynowy['czas_szkolenia'];
    $koniec_szkolenia= $czas_szkolenia+$czas;
    if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
      VALUES ( $karabinmaszynowy_ilosc, 'karabinmaszynowy', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
    $polaczenie->query($sql);
    $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
    drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
    $polaczenie->query($sql);  
     }
     else{
      $_SESSION['surowce_malo']=1;
      header('Location: ../koszary.php');
    }


    }

      $polaczenie->close();
      header('Location: ../koszary.php');
?>

