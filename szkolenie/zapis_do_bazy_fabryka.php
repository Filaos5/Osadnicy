<?php 
      session_start();
      require_once "../secure.php";
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
      $czas=time();
    $armata_ilosc=(int)$_POST['armata_ilosc'];
    if($armata_ilosc>0){
    $jednostka=1;
    echo "$jednostka\n";
    echo "$armata_ilosc\n";
      $sql = "SELECT * FROM wojsko WHERE nazwa='Armata'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_armata = $rezultat2->fetch_assoc();    
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
      $koszt_szkolenie=$wiersz_armata['pieniadze']*$armata_ilosc; 
      $zywnosc_szkolenie=$wiersz_armata['zywnosc']*$armata_ilosc;
      $drewno_szkolenie=$wiersz_armata['drewno']*$armata_ilosc; 
      $kamien_szkolenie=$wiersz_armata['kamien']*$armata_ilosc; 
      $metal_szkolenie=$wiersz_armata['metal']*$armata_ilosc;
      $czas_szkolenia=$wiersz_armata['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;  
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
        $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
        VALUES ( $armata_ilosc, 'armata', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ratusz.php');
      }
  
  }
    $czolg_ilosc=(int)$_POST['czolg_ilosc'];
    if($czolg_ilosc>0){
      $jednostka=2;
      echo "$jednostka\n";
      echo "$czolg_ilosc\n";
      $sql = "SELECT * FROM wojsko WHERE nazwa='Czolg'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_czolg = $rezultat2->fetch_assoc();    
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
      $koszt_szkolenie=$wiersz_czolg['pieniadze']*$czolg_ilosc; 
      $zywnosc_szkolenie=$wiersz_czolg['zywnosc']*$czolg_ilosc;
      $drewno_szkolenie=$wiersz_czolg['drewno']*$czolg_ilosc; 
      $kamien_szkolenie=$wiersz_czolg['kamien']*$czolg_ilosc; 
      $metal_szkolenie=$wiersz_czolg['metal']*$czolg_ilosc;
      $czas_szkolenia=$wiersz_czolg['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;  
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
      VALUES ( $czolg_ilosc, 'czolg', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../fabryka.php');
      }
    }  



    $mustang_ilosc=(int)$_POST['mustang_ilosc'];
    if($mustang_ilosc>0){
      $jednostka=3;
      echo "$jednostka\n";
      echo "$mustang_ilosc\n";
      $sql = "SELECT * FROM wojsko WHERE nazwa='Mustang'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_mustang = $rezultat2->fetch_assoc();    
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
      echo $mustang_ilosc;
      $koszt_szkolenie=$wiersz_mustang['pieniadze']*$mustang_ilosc; 
      $zywnosc_szkolenie=$wiersz_mustang['zywnosc']*$mustang_ilosc;
      $drewno_szkolenie=$wiersz_mustang['drewno']*$mustang_ilosc; 
      $kamien_szkolenie=$wiersz_mustang['kamien']*$mustang_ilosc; 
      $metal_szkolenie=$wiersz_mustang['metal']*$mustang_ilosc;
      $czas_szkolenia=$wiersz_mustang['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;  
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
        $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
        VALUES ( $mustang_ilosc, 'mustang', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../fabryka.php');
      }
    }  

    $dzialolot_ilosc=(int)$_POST['dzialolot_ilosc'];
    if($dzialolot_ilosc>0){
      $jednostka=4;
      echo "$jednostka\n";
      echo "$dzialolot_ilosc\n";
      $sql = "SELECT * FROM wojsko WHERE nazwa='Dzialolot'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_dzialolotnicze = $rezultat2->fetch_assoc();    
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
      $koszt_szkolenie=$wiersz_dzialolotnicze['pieniadze']*$dzialolotnicze_ilosc; 
      $zywnosc_szkolenie=$wiersz_dzialolotnicze['zywnosc']*$dzialolotnicze_ilosc;
      $drewno_szkolenie=$wiersz_dzialolotnicze['drewno']*$dzialolotnicze_ilosc; 
      $kamien_szkolenie=$wiersz_dzialolotnicze['kamien']*$dzialolotnicze_ilosc; 
      $metal_szkolenie=$wiersz_dzialolotnicze['metal']*$dzialolotnicze_ilosc;
      $czas_szkolenia=$wiersz_dzialolotnicze['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;  
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
        $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
        VALUES ( $dzialolot_ilosc, 'dzialolot', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../fabryka.php');
      }
    }  

    $f35_ilosc=(int)$_POST['f35_ilosc'];
    if($f35_ilosc>0){
      $jednostka=5;
      echo "$jednostka\n";
      echo "$f35_ilosc\n";
      $sql = "SELECT * FROM wojsko WHERE nazwa='F35'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_f35 = $rezultat2->fetch_assoc();    
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
      $koszt_szkolenie=$wiersz_f35['pieniadze']*$f35_ilosc; 
      $zywnosc_szkolenie=$wiersz_f35['zywnosc']*$f35_ilosc;
      $drewno_szkolenie=$wiersz_f35['drewno']*$f35_ilosc; 
      $kamien_szkolenie=$wiersz_f35['kamien']*$f35_ilosc; 
      $metal_szkolenie=$wiersz_f35['metal']*$f35_ilosc;
      $czas_szkolenia=$wiersz_f35['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas; 
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
        $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
        VALUES ( $f35_ilosc, 'f35', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../fabryka.php');
      }
    } 

    $patriot_ilosc=(int)$_POST['patriot_ilosc'];
    if($patriot_ilosc>0){
      $jednostka=6;
      echo "$jednostka\n";
      echo "$patriot_ilosc\n";
      $sql = "SELECT * FROM wojsko WHERE nazwa='Patriot'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_patriot = $rezultat2->fetch_assoc();    
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
      $koszt_szkolenie=$wiersz_patriot['pieniadze']*$patriot_ilosc; 
      $zywnosc_szkolenie=$wiersz_patriot['zywnosc']*$patriot_ilosc;
      $drewno_szkolenie=$wiersz_patriot['drewno']*$patriot_ilosc; 
      $kamien_szkolenie=$wiersz_patriot['kamien']*$patriot_ilosc; 
      $metal_szkolenie=$wiersz_patriot['metal']*$patriot_ilosc;
      $czas_szkolenia=$wiersz_patriot['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;   
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
        $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
        VALUES ( $patriot_ilosc, 'patriot', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../fabryka.php');
      }
    } 

    $northropB2_ilosc=(int)$_POST['northropB2_ilosc'];
    if($northropB2_ilosc>0){
      $jednostka=7;
      echo "$jednostka\n";
      echo "$northropB2_ilosc\n";
      $sql = "SELECT * FROM wojsko WHERE nazwa='NorthropB2'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_northrop = $rezultat2->fetch_assoc();    
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
      $koszt_szkolenie=$wiersz_northrop['pieniadze']*$northrop_ilosc; 
      $zywnosc_szkolenie=$wiersz_northrop['zywnosc']*$northrop_ilosc;
      $drewno_szkolenie=$wiersz_northrop['drewno']*$northrop_ilosc; 
      $kamien_szkolenie=$wiersz_northrop['kamien']*$northrop_ilosc; 
      $metal_szkolenie=$wiersz_northrop['metal']*$northrop_ilosc; 
      $czas_szkolenia=$wiersz_northrop['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;  
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
      $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
      VALUES ( $northropB2_ilosc, 'northropB2', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../fabryka.php');
      }
    } 

    $tomahawk_ilosc=(int)$_POST['tomahawk_ilosc'];
    if($tomahawk_ilosc>0){
      $jednostka=8;
      echo "$jednostka\n";
      echo "$tomahawk_ilosc\n";
      $sql = "SELECT * FROM wojsko WHERE nazwa='Tomahawk'";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $wiersz_tomahawk = $rezultat2->fetch_assoc();    
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
      $koszt_szkolenie=$wiersz_tomahawk['pieniadze']*$tomahawk_ilosc; 
      $zywnosc_szkolenie=$wiersz_tomahawk['zywnosc']*$tomahawk_ilosc;
      $drewno_szkolenie=$wiersz_tomahawk['drewno']*$tomahawk_ilosc; 
      $kamien_szkolenie=$wiersz_tomahawk['kamien']*$tomahawk_ilosc; 
      $metal_szkolenie=$wiersz_tomahawk['metal']*$tomahawk_ilosc;
      $czas_szkolenia=$wiersz_tomahawk['czas_szkolenia'];
      $koniec_szkolenia= $czas_szkolenia+$czas;   
      if($pieniadze>$koszt_szkolenie && $zywnosc>$zywnosc_szkolenie && $drewno>$drewno_szkolenie && $kamien>$kamien_szkolenie && $metal>$metal_szkolenie){
        $sql = "INSERT INTO szkolenia ( ilosc, jednostka, mecz, wioska, kiedy_rozpoczeto, kiedy_koniec)
        VALUES ( $tomahawk_ilosc, 'tomahawk', $id_meczu, $id_wioski, $czas, $koniec_szkolenia)";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET pieniadze=pieniadze-$koszt_szkolenie, zywnosc=zywnosc-$zywnosc_szkolenie,
      drewno=drewno-$drewno_szkolenie,kamien=kamien-$kamien_szkolenie, metal=metal-$metal_szkolenie WHERE id=$id_wioski";
      $polaczenie->query($sql);  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../fabryka.php');
      }
    } 


      $polaczenie->close();
      header('Location: ../fabryka.php');
?>

