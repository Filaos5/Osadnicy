<?php 
      session_start();
      require_once "../secure.php";
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
    $domy_ilosc=(int)$_POST['dom_ilosc'];

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
          $pieniadze=$pobranywiersz['pieniadze'];
          $drewno=$pobranywiersz['drewno'];        
      }
      $koszt=(int)$wiersz_dom['pieniadze']*$domy_ilosc; 
      $drewno_budowa=(int)$wiersz_dom['drewno']*$domy_ilosc; 
      if($pieniadze>$koszt && $drewno>$drewno_budowa){
     
      $sql = "UPDATE wioska SET domy=domy+$domy_ilosc, pieniadze=pieniadze-$koszt, drewno=drewno-$drewno_budowa WHERE id=$id_wioski";
      @$polaczenie->query($sql); 
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ratusz.php');
      }
      $polaczenie->close();
      header('Location: ../ratusz.php');
?>