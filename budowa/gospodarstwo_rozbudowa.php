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
    $sql = "SELECT * FROM wioska WHERE id='$id_wioski'";     
      if($rezultat = @$polaczenie->query($sql))
      {
          $pobranywiersz = $rezultat->fetch_assoc();          
      }
      $id_wioski=$pobranywiersz['id'];
      $koszt_podstawowy=(int)$wiersz_gospoda['pieniadze']; 
      $koszt=$koszt_podstawowy*(2**$pobranywiersz['gospodarstwo']);
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']<10){
           //$koszt=$koszt_podstawowy*(2**$pobranywiersz['gospodarstwo']);
            $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id='$id_wioski'";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id_uczestnik_zalogowany";
            $polaczenie->query($sql);  
            $sql = "SELECT gospodarstwo FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_zalogowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $ile_wiosek = $rezultat->num_rows;
          $predkosc_cala=0;
          for($i=0;$i<$ile_wiosek;$i++){
          $wiersz = $rezultat->fetch_assoc();
          $predkosc_wioski=2**($wiersz['gospodarstwo']-1);
          $predkosc_cala=$predkosc_cala+$predkosc_wioski;
          }
          $sql = "UPDATE uczestnicy SET predkosc_zywnosc=$predkosc_cala WHERE id=$id_uczestnik_zalogowany";
          $polaczenie->query($sql); 
      }
            
        }
        else{
            $_SESSION['surowce_malo']=1;
            header('Location: ratusz.php');
          }
      $polaczenie->close();
      
      header('Location: ../gospodarstwo.php');






      /*
       if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==1){
        $koszt=$koszt*2;
        $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
        @$polaczenie->query($sql);
        $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
        @$polaczenie->query($sql);   
        }
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==2){
            $koszt=$koszt*4;
            $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
            @$polaczenie->query($sql);   
        }
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==3){
            $koszt=$koszt*8;
             $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
            @$polaczenie->query($sql);   
            }
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==4){
            $koszt=$koszt*16;
            $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
            $polaczenie->query($sql);   
        }
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==5){
            $koszt=$koszt*32;
            $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
            $polaczenie->query($sql);   
        }
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==6){
            $koszt=$koszt*64;
            $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
            $polaczenie->query($sql);   
        }
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==7){
            $koszt=$koszt*128;
            $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
            $polaczenie->query($sql);   
        }
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==8){
            $koszt=$koszt*256;
            $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
            $polaczenie->query($sql);   
        }
        if($pieniadze>$koszt && $pobranywiersz['gospodarstwo']==9){
            $koszt=$koszt*512;
            $sql = "UPDATE wioska SET gospodarstwo=gospodarstwo+1 WHERE id=1";
            @$polaczenie->query($sql);
            $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=$id";
            $polaczenie->query($sql);   
        }
        */
?>



