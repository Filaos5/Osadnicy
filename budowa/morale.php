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
      }
      $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
      if($rezultat2 = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat2->fetch_assoc();          
      }
      $morale=$pobranywiersz['morale']+1;
      $sql= "SELECT * FROM morale WHERE id=$morale";
      if($morale_tablica = @$polaczenie->query($sql))
      {
          $morale_cena_tablica = $morale_tablica->fetch_assoc();
      }
      $morale_cena=$morale_cena_tablica['koszt'];
      if($pieniadze>$morale_cena && $pobranywiersz['kosciol']==1){
      $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$morale_cena WHERE id=$id_uczestnik_zalogowany";
      $polaczenie->query($sql);
      $sql = "UPDATE wioska SET morale=morale+1 WHERE id=$id_wioski";
      $polaczenie->query($sql);    
       }
       else{
        $_SESSION['surowce_malo']=1;
        header('Location: ../kosciol.php');
      }
       echo $morale_cena; 
      $polaczenie->close();
      header('Location: ../kosciol.php');
?>