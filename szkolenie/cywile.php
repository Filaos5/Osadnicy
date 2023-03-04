<?php 
      session_start();
      require_once "../secure.php";
      $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
      $id_user=$_SESSION['id_sesji'];
      $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
      $id_meczu=$_SESSION['mecz_przeslany'];
      $id_wioski=$_SESSION['id_wioski'];
    $cywile_ilosc=(int)$_POST['ludzie_ilosc'];
    echo $cywile_ilosc;
      $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $wiersz = $rezultat->fetch_assoc();
          $pieniadze=$wiersz['pieniadze'];
          $zywnosc=$wiersz['zywnosc'];
      }
      $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
      if($rezultat = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat->fetch_assoc();          
      }
      $koszt=2000*$cywile_ilosc; 
      $zywnosc_szkolenie=200*$cywile_ilosc; 
      $ludnosc=$pobranywiersz['cywile'];
      $ludnosc_maksymalna=$pobranywiersz['domy']*5+$pobranywiersz['bloki']*200+100;
      if($pieniadze>$koszt && $zywnosc>$zywnosc_szkolenie && $ludnosc_maksymalna>=$cywile_ilosc+$ludnosc){
        echo 'robie2';
      $sql = "UPDATE wioska SET cywile=cywile+$cywile_ilosc WHERE id=$id_wioski";
      $polaczenie->query($sql);
      $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt, zywnosc=zywnosc-$zywnosc_szkolenie WHERE id=$id_uczestnik_zalogowany";
      $polaczenie->query($sql); 
      $sql = "SELECT cywile FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $ile_wiosek = $rezultat->num_rows;
          $predkosc_cala=0;
          for($i=0;$i<$ile_wiosek;$i++){
          $wiersz = $rezultat->fetch_assoc();
          $predkosc_wioski=$wiersz['cywile'];
          $predkosc_cala=$predkosc_cala+$predkosc_wioski;
          }
          $sql = "UPDATE uczestnicy SET predkosc_zl=$predkosc_cala WHERE id=$id_uczestnik_zalogowany";
          $polaczenie->query($sql); 
        }
  
       }
       else{
        if($ludnosc_maksymalna<$cywile_ilosc+$ludnosc){
        $_SESSION['atak_jednostki_malo']=1;
        }
        else{
          $_SESSION['surowce_malo']=1;
          }
        header('Location: ../ratusz.php');
      }
      $polaczenie->close();
      header('Location: ../ratusz.php');
      //$pieniadze>$koszt && $zywnosc>$zywnosc_szkolenie && $ludnosc_maksymalna>=$cywile_ilosc+$ludnosc
?>

