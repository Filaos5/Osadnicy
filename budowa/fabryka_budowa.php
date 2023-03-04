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
      $koszt=(int)$wiersz_fabryka['pieniadze']; 
      $drewno_budowa=(int)$wiersz_fabryka['drewno']; 
      $metal_budowa=(int)$wiersz_fabryka['metal'];
      $kamien_budowa=(int)$wiersz_fabryka['kamien'];  
      if($pieniadze>$koszt && $drewno>$drewno_budowa && $metal>$metal_budowa && $kamien>$kamien_budowa && $pobranywiersz['fabryka']==0){
      $sql = "UPDATE wioska SET fabryka=1 WHERE id=$id_wioski";
      @$polaczenie->query($sql);
      $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt, drewno=drewno-$drewno_budowa, metal=metal-$metal_budowa, kamien=kamien-$kamien_budowa WHERE id=$id_uczestnik_zalogowany";
      @$polaczenie->query($sql);   
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ratusz.php');
      }
      $polaczenie->close();
      header('Location: ../ratusz.php');
?>