<?php 
require_once "../secure.php";
      session_start();
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
      $co_rozbudowac=(string)$_POST['kolejne_przejscie'];
      $sql = "SELECT * FROM budynki WHERE nazwa='$co_rozbudowac'";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $ilu_userow = $rezultat2->num_rows;
     $wiersz_budynek = $rezultat2->fetch_assoc();
 }
      $sql = "SELECT * FROM wioska WHERE id='$id_wioski'";
      if($rezultat = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat->fetch_assoc(); 
          $pieniadze=$pobranywiersz['pieniadze'];
          $drewno=$pobranywiersz['drewno'];  
          $kamien=$pobranywiersz['kamien'];  
          $metal=$pobranywiersz['metal'];    
          $budynek_rozbudowa_poziom=$pobranywiersz[$co_rozbudowac];     
      }
      $koszt_podstawowy=(int)$wiersz_budynek['pieniadze']; 
      $drewno_budowa_podstawowy=(int)$wiersz_budynek['drewno']; 
      $metal_budowa_podstawowa=(int)$wiersz_budynek['metal'];
      $kamien_budowa_podstawowy=(int)$wiersz_budynek['kamien'];  
      $koszt=$koszt_podstawowy*(2**$pobranywiersz[$co_rozbudowac]);
      $drewno_budowa=$drewno_budowa_podstawowy*(2**$pobranywiersz[$co_rozbudowac]);
      $metal_budowa=$metal_budowa_podstawowa*(2**$pobranywiersz[$co_rozbudowac]);
      $kamien_budowa=$kamien_budowa_podstawowy*(2**$pobranywiersz[$co_rozbudowac]);
      echo $co_rozbudowac.'\n';
      echo $pieniadze.'\n';
      echo $koszt.'\n';
      if($pieniadze>$koszt && $drewno>$drewno_budowa && $metal>$metal_budowa && $kamien>$kamien_budowa){
      $sql = "UPDATE wioska SET $co_rozbudowac=$co_rozbudowac+1, pieniadze=pieniadze-$koszt, drewno=drewno-$drewno_budowa, metal=metal-$metal_budowa, kamien=kamien-$kamien_budowa WHERE id=$id_wioski";
      $polaczenie->query($sql);
      //$sql = "UPDATE wioska SET  WHERE id=$id_wioski";
     // $polaczenie->query($sql);    
      $predkosc_wioski=1;
      echo 'jestem';
      $sql = "SELECT * FROM wioska";
      /*
      TUTAJ JEST COS DZIWNEGO
      */
      if($co_rozbudowac=='tartak'){
      $sql = "UPDATE wioska SET predkosc_drewno=$predkosc_wioski WHERE id=$id_wioski";
      }
      if($co_rozbudowac=='gospodarstwo'){
        $sql = "UPDATE wioska SET predkosc_zywnosc=$predkosc_wioski WHERE id=$id_wioski";
      }
      if($co_rozbudowac=='kamieniolom'){
        $sql = "UPDATE wioska SET predkosc_kamien=$predkosc_wioski WHERE id=$id_wioski";
      }
      $polaczenie->query($sql); 
      }
      else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../ratusz.php');
      }
      $polaczenie->close();
      header('Location: ../ratusz.php');
?>