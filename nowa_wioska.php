<?php
    session_start();
    require_once "secure.php";
 
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno." Opis: ". $polaczenie->connect_error;
        //header('Location: index.php');
    }
    else
    {
    $id_user=$_SESSION['id_sesji'];
    $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika']; 
    if($_SESSION['mecz_przeslany']==0)
    {
        header('Location: moje_konto.php');
    }
    $id_meczu=$_SESSION['mecz_przeslany'];
    $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
    $wioska_pozycja=(int)$_SESSION['wioska_pozycja'];
    $_SESSION['wioska_pozycja']=-1;
   $pozycja_x=((int)$wioska_pozycja)%20;
   $pozycja_y=((((int)$wioska_pozycja)-$pozycja_x)/20)+1;
   $pozycja_x=$pozycja_x+1;
   $sql = "SELECT * FROM budynki";
   if($rezultat2 = @$polaczenie->query($sql))
   {
       $wiersz_ratusz = $rezultat2->fetch_assoc();
   }
   $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
   if($rezultat = @$polaczenie->query($sql))
   {
       $wiersz = $rezultat->fetch_assoc();
       $pieniadze=$wiersz['pieniadze'];
       $drewno=$wiersz['drewno'];
       $metal=$wiersz['metal'];
       $kamien=$wiersz['kamien'];
   }
   //echo 'idmeczu';
   //echo $id_meczu;
   //echo 'pozx';
   //echo $pozycja_x;
   //echo 'pozy';
   //echo $pozycja_y;
    $czas=time();
    $koszt=(int)$wiersz_ratusz['pieniadze']; 
    $drewno_budowa=(int)$wiersz_ratusz['drewno']; 
    $metal_budowa=(int)$wiersz_ratusz['metal'];
    $kamien_budowa=(int)$wiersz_ratusz['kamien'];
    if($pieniadze>$koszt && $drewno>$drewno_budowa && $metal>$metal_budowa && $kamien>$kamien_budowa){
   $sql = "UPDATE wioska SET id_uczestnika='$id_uczestnik_zalogowany' WHERE mecz='$id_meczu' AND id_uczestnika=0 AND pozycjax=$pozycja_x AND pozycjay=$pozycja_y";
    $polaczenie->query($sql);
    $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt, drewno=drewno-$drewno_budowa, metal=metal-$metal_budowa, kamien=kamien-$kamien_budowa WHERE id=$id_uczestnik_zalogowany";
    $polaczenie->query($sql); 
    $polaczenie->close();
    }
    else{
        $_SESSION['alert_nowa_wioska']=1;
    }
}
    header('Location: index.php');
?>