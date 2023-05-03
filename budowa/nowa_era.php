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
          $wiersz = $rezultat->fetch_assoc();     
      }
      $era=$wiersz['era'];
      $sql= "SELECT * FROM ery WHERE id=$era";
      if($ery_tablica = @$polaczenie->query($sql))
      {
          $era_cena_tablica = $ery_tablica->fetch_assoc();
      }
      $era_cena=$era_cena_tablica['cena'];
      $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
      if($rezultat = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat->fetch_assoc();
          $pieniadze=$pobranywiersz['pieniadze'];          
      }
      if($pieniadze>=$era_cena && $pobranywiersz['uniwersytet']==1){
        $sql = "UPDATE wioska SET pieniadze=pieniadze-$era_cena WHERE id=$id_wioski";
      $polaczenie->query($sql); 
      $sql = "UPDATE uczestnicy SET era=era+1 WHERE id=$id_uczestnik_zalogowany";
      @$polaczenie->query($sql);   
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: uniwersytet.php');
      }
      $polaczenie->close();
      header('Location: ../uniwersytet.php');
?>