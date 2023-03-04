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
          $kamien=$wiersz['kamien'];
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
      $koszt=(int)$wiersz_huta['pieniadze']; 
      $drewno_budowa=(int)$wiersz_huta['drewno']; 
      $metal_budowa=(int)$wiersz_huta['metal'];
      $kamien_budowa=(int)$wiersz_huta['kamien'];  
      if($pieniadze>$koszt && $drewno>$drewno_budowa && $metal>$metal_budowa && $kamien>$kamien_budowa && $pobranywiersz['huta']==0){
      $sql = "UPDATE wioska SET huta=1 WHERE id=$id_wioski";
      @$polaczenie->query($sql);
      $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt, drewno=drewno-$drewno_budowa, metal=metal-$metal_budowa, kamien=kamien-$kamien_budowa WHERE id=$id_uczestnik_zalogowany";
      @$polaczenie->query($sql);       
      $sql = "SELECT huta, kuznia FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $ile_wiosek = $rezultat->num_rows;
          $predkosc_cala=0;
          for($i=0;$i<$ile_wiosek;$i++){
          $wiersz = $rezultat->fetch_assoc();
          $predkosc_wioskih=100*(2**($wiersz['huta']-1));
          $predkosc_wioskik=2**($wiersz['kuznia']-1);
          $predkosc_cala=$predkosc_cala+$predkosc_wioskih+$predkosc_wioskik;
          }
          $sql = "UPDATE uczestnicy SET predkosc_metal=$predkosc_cala WHERE id=$id_uczestnik_zalogowany";
          $polaczenie->query($sql); 
      }  
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ratusz.php');
      }
      $polaczenie->close();
      header('Location: ../ratusz.php');
?>