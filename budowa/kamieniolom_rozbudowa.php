<?php 
      require_once "../secure.php";
      session_start();
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
      $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          //$ilu_userow = $rezultat->num_rows;
          $wiersz = $rezultat->fetch_assoc();
          $pieniadze=$wiersz['pieniadze'];
          $drewno=$wiersz['drewno'];
          $metal=$wiersz['metal'];
      }
      $sql = "SELECT * FROM budynki";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $ilu_userow = $rezultat2->num_rows;
     $wiersz_ratusz = $rezultat2->fetch_assoc();
     $wiersz_gospoda = $rezultat2->fetch_assoc();
     $wiersz_tartak = $rezultat2->fetch_assoc();
     $wiersz_kuznia = $rezultat2->fetch_assoc();
     $wiersz_kamieniolom = $rezultat2->fetch_assoc();
     $wiersz_dom = $rezultat2->fetch_assoc();
     $wiersz_blok = $rezultat2->fetch_assoc();
     $wiersz_kosciol = $rezultat2->fetch_assoc();
     $wiersz_koszary = $rezultat2->fetch_assoc();
     $wiersz_stajnia = $rezultat2->fetch_assoc();
     $wiersz_huta = $rezultat2->fetch_assoc();
     $wiersz_fabryka = $rezultat2->fetch_assoc();
     $wiersz_lotnisko = $rezultat2->fetch_assoc();
     $wiersz_uniwersytet = $rezultat2->fetch_assoc();
    
 }
      $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
      if($rezultat = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat->fetch_assoc();          
      }
      $koszt_podstawowy=(int)$wiersz_kamieniolom['pieniadze']; 
      $drewno_budowa_podstawowy=(int)$wiersz_kamieniolom['drewno']; 
      $metal_budowa_podstawowy=(int)$wiersz_kamieniolom['metal']; 
      $koszt=$koszt_podstawowy*(2**$pobranywiersz['kamieniolom']);
      $drewno_budowa=$drewno_budowa_podstawowy*(2**$pobranywiersz['kamieniolom']);
      $metal_budowa=$metal_budowa_podstawowy*(2**$pobranywiersz['kamieniolom']);
      if($pieniadze>$koszt && $drewno>$drewno_budowa && $metal>$metal_budowa && $pobranywiersz['kamieniolom']<10){  
      $sql = "UPDATE wioska SET kamieniolom=kamieniolom+1 WHERE id=$id_wioski";
      $polaczenie->query($sql);
      $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt, drewno=drewno-$drewno_budowa, metal=metal-$metal_budowa WHERE id=$id_uczestnik_zalogowany";
      $polaczenie->query($sql);
      $sql = "SELECT kamieniolom FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $ile_wiosek = $rezultat->num_rows;
          $predkosc_cala=0;
          for($i=0;$i<$ile_wiosek;$i++){
          $wiersz = $rezultat->fetch_assoc();
          $predkosc_wioski=2**($wiersz['kamieniolom']-1);
          $predkosc_cala=$predkosc_cala+$predkosc_wioski;
          }
          $sql = "UPDATE uczestnicy SET predkosc_kamien=$predkosc_cala WHERE id=$id_uczestnik_zalogowany";
          $polaczenie->query($sql); 
      }   
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../kamieniolom.php');
      }
      $polaczenie->close();
      header('Location: ../kamieniolom.php');
?>