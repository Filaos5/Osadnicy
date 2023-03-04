<?php 
      session_start();
      require_once "../secure.php";
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
    $bloki_ilosc=(int)$_POST['blok_ilosc'];
      $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $wiersz = $rezultat->fetch_assoc();
          $pieniadze=$wiersz['pieniadze'];
          $kamien=$wiersz['kamien'];
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
     $wiersz_kamienilom = $rezultat2->fetch_assoc();
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
      $koszt=(int)$wiersz_blok['pieniadze']*$bloki_ilosc; 
      $kamien_budowa=(int)$wiersz_blok['kamien']*$bloki_ilosc;
      $metal_budowa=(int)$wiersz_blok['metal']*$bloki_ilosc;  
      if($pieniadze>$koszt && $kamien>$kamien_budowa && $metal>$metal_budowa){
      $sql = "UPDATE wioska SET bloki=bloki+$bloki_ilosc WHERE id=$id_wioski";
      @$polaczenie->query($sql);
      $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt, kamien=kamien-$kamien_budowa, metal=metal-$metal_budowa WHERE id=$id_uczestnik_zalogowany";
      @$polaczenie->query($sql);   
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ratusz.php');
      }
      $polaczenie->close();
      header('Location: ../ratusz.php');
?>