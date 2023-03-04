<?php
    session_start();
    if(isset($_SESSION['zalogowany'])){
        if($_SESSION['zalogowany']!=true)
        {
            header('Location: logowanie.php');
        }
    }
    else{
    header('Location: logowanie.php');
    }

    require_once "secure.php";
 
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
   
    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno." Opis: ". $polaczenie->connect_error;
        //header('Location: index.php');
    }
    else{
    $id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
    $id_meczu=$_SESSION['mecz_przeslany'];  
    $miecznik_ilosc=(int)$_POST['miecznik_ilosc'];
    $lucznik_ilosc=(int)$_POST['lucznik_ilosc'];
    $kawalerzysta_ilosc=(int)$_POST['kawalerzysta_ilosc'];
    $lucznikkon_ilosc=(int)$_POST['lucznikkon_ilosc'];
    $karabin_ilosc=(int)$_POST['karabin_ilosc'];
    $armata_ilosc=(int)$_POST['armata_ilosc'];
    $czolg_ilosc=(int)$_POST['czolg_ilosc'];
    $karabinmaszynowy_ilosc=(int)$_POST['karabinmaszynowy_ilosc'];
    $mustang_ilosc=(int)$_POST['mustang_ilosc'];
    $F35_ilosc=(int)$_POST['F35_ilosc'];
    $northropB2_ilosc=(int)$_POST['northropB2_ilosc'];
    $tomahawk_ilosc=(int)$_POST['tomahawk_ilosc'];
    $id_wioski=$_SESSION['id_wioski'];
    $id_wioski_cel=$_SESSION['wioska_cel'];
    echo 'zrodlo '. $id_wioski.' cel '. $id_wioski_cel;
echo 'miecznik '.$miecznik_ilosc;
echo 'lucznik '.$lucznik_ilosc;
echo 'kawalerzysta '.$kawalerzysta_ilosc;
echo 'lucznik konny '.$lucznikkon_ilosc;
echo 'karabin '.$karabin_ilosc;
echo 'armata '.$armata_ilosc;
echo 'czolg '.$czolg_ilosc;
echo 'karabin maszynowy '.$karabinmaszynowy_ilosc;
echo 'mustang '.$mustang_ilosc;
echo 'F35 '.$F35_ilosc;
echo 'northropB2 '.$northropB2_ilosc;
echo 'tomahawk '.$tomahawk_ilosc;
echo("<br>");
$sql = "SELECT * FROM wioska WHERE id=$id_wioski";
 if($rezultat1 = @$polaczenie->query($sql))
 {
     $wioska_zrodlo = $rezultat1->fetch_assoc();
 }
 $miecznik_zrodlo=$wioska_zrodlo['miecznik'];
 $lucznik_zrodlo=$wioska_zrodlo['lucznik'];
 $kawalerzysta_zrodlo=$wioska_zrodlo['kawalerzysta'];
 $lucznikkon_zrodlo=$wioska_zrodlo['lucznikkon'];
 $karabin_zrodlo=$wioska_zrodlo['karabin'];
 $armata_zrodlo=$wioska_zrodlo['armata'];
 $czolg_zrodlo=$wioska_zrodlo['czolg'];
 $karabinmaszynowy_zrodlo=$wioska_zrodlo['karabinmaszynowy'];
 $mustang_zrodlo=$wioska_zrodlo['mustang'];
 $F35_zrodlo=$wioska_zrodlo['F35'];
 $northropB2_zrodlo=$wioska_zrodlo['northropB2'];
 $tomahawk_zrodlo=$wioska_zrodlo['tomahawk'];
 $id_uczestnika=$wioska_zrodlo['id_uczestnika'];
echo 'miecznik '.$miecznik_zrodlo;
echo 'lucznik '.$lucznik_zrodlo;
echo 'kawalerzysta '.$kawalerzysta_zrodlo;
echo 'lucznik konny '.$lucznikkon_zrodlo;
echo 'karabin '.$karabin_zrodlo;
echo 'armata '.$armata_zrodlo;
echo 'czolg '.$czolg_zrodlo;
echo 'karabin maszynowy '.$karabinmaszynowy_zrodlo;
echo 'mustang '.$mustang_zrodlo;
echo 'F35 '.$F35_zrodlo;
echo 'northropB2 '.$northropB2_zrodlo;
echo 'tomahawk '.$tomahawk_zrodlo;
echo 'uczestnik '.$id_uczestnika;
echo("<br>");
echo 'uczestnik '.$id_uczestnika. ' <br>';
$sql = "SELECT * FROM wioska WHERE id=$id_wioski_cel";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $wioska_cel = $rezultat2->fetch_assoc();
 }
 $miecznik_cel=$wioska_cel['miecznik'];
 $lucznik_cel=$wioska_cel['lucznik'];
 $kawalerzysta_cel=$wioska_cel['kawalerzysta'];
 $lucznikkon_cel=$wioska_cel['lucznikkon'];
 $karabin_cel=$wioska_cel['karabin'];
 $armata_cel=$wioska_cel['armata'];
 $czolg_cel=$wioska_cel['czolg'];
 $karabinmaszynowy_cel=$wioska_cel['karabinmaszynowy'];
 $mustang_cel=$wioska_cel['mustang'];
 $dzialolot_cel=$wioska_cel['dzialolot'];
 $F35_cel=$wioska_cel['F35'];
 $patriot_cel=$wioska_cel['patriot'];
 $northropB2_cel=$wioska_cel['northropB2'];
 $tomahawk_cel=$wioska_cel['tomahawk'];
 $cywile_cel=$wioska_cel['cywile'];
 $morale=$wioska_cel['morale'];
 $id_uczestnik_atakowany=$wioska_cel['id_uczestnika'];
echo 'miecznik '.$miecznik_cel;
echo 'lucznik '.$lucznik_cel;
echo 'kawalerzysta '.$kawalerzysta_cel;
echo 'lucznik konny '.$lucznikkon_cel;
echo 'karabin '.$karabin_cel;
echo 'armata '.$armata_cel;
echo 'czolg '.$czolg_cel;
echo 'karabin maszynowy '.$karabinmaszynowy_cel;
echo 'mustang '.$mustang_cel;
echo 'dzialoprzeciwlotnicze '.$dzialolot_cel;
echo 'F35 '.$F35_cel;
echo 'patriot '.$patriot_cel;
echo 'northropB2 '.$northropB2_cel;
echo 'tomahawk '.$tomahawk_cel;
echo 'cywile '.$cywile_cel;
echo 'morale '.$morale. ' <br>';
echo 'uczestnik_atakowany '.$id_uczestnik_atakowany. ' <br>';
$sql = "SELECT * FROM morale WHERE id=$morale";
if($rezultat3 = @$polaczenie->query($sql))
{
    $morale_cel = $rezultat3->fetch_assoc();
}
$morale_wartosc=$morale_cel['poziom'];
echo 'morale wartosc '.$morale_wartosc;
if( $miecznik_ilosc<=$miecznik_zrodlo && $lucznik_ilosc<=$lucznik_zrodlo && $kawalerzysta_ilosc<=$kawalerzysta_zrodlo
&& $lucznikkon_ilosc<=$lucznikkon_zrodlo && $karabin_ilosc<=$karabin_zrodlo && $armata_ilosc<=$armata_zrodlo
&& $czolg_ilosc<=$czolg_zrodlo && $karabinmaszynowy_ilosc<=$karabinmaszynowy_zrodlo && $mustang_ilosc<=$mustang_zrodlo
&& $F35_ilosc<=$F35_zrodlo && $northropB2_ilosc<=$northropB2_zrodlo && $tomahawk_ilosc<=$tomahawk_zrodlo){
  echo("<br>");
  echo 'wyslano';
  echo("<br>");
  $sql = "SELECT atak, obrona FROM wojsko";
  if($rezultat = @$polaczenie->query($sql))
  {
      $wojsko_sila = $rezultat->fetch_assoc();
      $miecznik_atak=$wojsko_sila['atak'];
      $miecznik_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $lucznik_atak=$wojsko_sila['atak'];
      $lucznik_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $kawalerzysta_atak=$wojsko_sila['atak'];
      $kawalerzysta_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $lucznikkon_atak=$wojsko_sila['atak'];
      $lucznikkon_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $karabin_atak=$wojsko_sila['atak'];
      $karabin_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $armata_atak=$wojsko_sila['atak'];
      $armata_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $czolg_atak=$wojsko_sila['atak'];
      $czolg_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $karabinmaszynowy_atak=$wojsko_sila['atak'];
      $karabinmaszynowy_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $mustang_atak=$wojsko_sila['atak'];
      $mustang_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $dzialolot_atak=$wojsko_sila['atak'];
      $dzialolot_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $F35_atak=$wojsko_sila['atak'];
      $F35_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $patriot_atak=$wojsko_sila['atak'];
      $patriot_obrona=$wojsko_sila['obrona'];

      $wojsko_sila = $rezultat->fetch_assoc();
      $northropB2_atak=$wojsko_sila['atak'];
      $northropB2_obrona=$wojsko_sila['obrona'];
      
      $wojsko_sila = $rezultat->fetch_assoc();
      $tomahawk_atak=$wojsko_sila['atak'];
      $tomahawk_obrona=$wojsko_sila['obrona'];
  }

  echo 'miecznik_atak '.$miecznik_atak.' miecznik_obrona '.$miecznik_obrona. ' <br>';
  echo 'lycznik_atak '.$lucznik_atak.' lucznik_obrona '.$lucznik_obrona. ' <br>';
  echo 'kawalerzysta_atak '.$kawalerzysta_atak.' kawalerzysta_obrona '.$kawalerzysta_obrona. ' <br>';
  echo 'lucznikkon_atak '.$lucznikkon_atak.' lucznikkonobrona '.$lucznikkon_obrona. ' <br>';
  echo 'karabin_atak '.$karabin_atak.' karabinobrona '.$karabin_obrona. ' <br>';
  echo 'armata_atak '.$armata_atak.' armataobrona '.$armata_obrona. ' <br>';
  echo 'czolg_atak '.$czolg_atak.' czolg_obrona '.$czolg_obrona. ' <br>';
  echo 'karabinmaszynowy_atak '.$karabinmaszynowy_atak.' karabinmaszynowy_obrona '.$karabinmaszynowy_obrona. ' <br>';
  echo 'mustang_atak '.$mustang_atak.' mustang_obrona '.$mustang_obrona. ' <br>';
  echo 'dzialolot_atak '.$dzialolot_atak.' dzialolot_obrona '.$dzialolot_obrona. ' <br>';
  echo 'F35_atak '.$F35_atak.' F35_obrona '.$F35_obrona. ' <br>';
  echo 'patriot_atak '.$patriot_atak.' patriot_obrona '.$patriot_obrona. ' <br>';
  echo 'northropB2_atak '.$northropB2_atak.' northropB2_obrona '.$northropB2_obrona. ' <br>';
  echo 'tomahawk_atak '.$tomahawk_atak.' tomahawk_obrona '.$tomahawk_obrona. ' <br>';

  $miecznik_atak_sila=$miecznik_atak*$miecznik_ilosc;
  $lucznik_atak_sila=$lucznik_atak*$lucznik_ilosc;
  $kawalerzysta_atak_sila=$kawalerzysta_atak*$kawalerzysta_ilosc;
  $lucznikkon_atak_sila=$lucznikkon_atak*$lucznikkon_ilosc;
  $karabin_atak_sila=$karabin_atak*$karabin_ilosc;
  $armata_atak_sila=$armata_atak*$armata_ilosc;
  $czolg_atak_sila=$czolg_atak*$czolg_ilosc;
  $karabinmaszynowy_atak_sila=$karabinmaszynowy_atak*$karabinmaszynowy_ilosc;
  $mustang_atak_sila=$mustang_atak*$mustang_ilosc;
  $F35_atak_sila=$F35_atak*$F35_ilosc;
  $northropB2_atak_sila=$northropB2_atak*$northropB2_ilosc;
  $tomahawk_atak_sila=$tomahawk_atak*$tomahawk_ilosc;
  $ladowy_atak_sila=$miecznik_atak_sila+$lucznik_atak_sila+$kawalerzysta_atak_sila+$lucznikkon_atak_sila+$karabin_atak_sila+$armata_atak_sila+$czolg_atak_sila+$karabinmaszynowy_atak_sila;
  echo 'atak ladowy '.$ladowy_atak_sila. ' <br>';
  $powietrzny_atak_sila=$mustang_atak_sila+$F35_atak_sila+$northropB2_atak_sila+$tomahawk_atak_sila;
  echo 'atak powietrzny '.$powietrzny_atak_sila. ' <br>';

  $miecznik_obrona_sila=$miecznik_obrona*$miecznik_cel;
  $lucznik_obrona_sila=$lucznik_obrona*$lucznik_cel;
  $kawalerzysta_obrona_sila=$kawalerzysta_obrona*$kawalerzysta_cel;
  $lucznikkon_obrona_sila=$lucznikkon_obrona*$lucznikkon_cel;
  $karabin_obrona_sila=$karabin_obrona*$karabin_cel;
  $armata_obrona_sila=$armata_obrona*$armata_cel;
  $czolg_obrona_sila=$czolg_obrona*$czolg_cel;
  $karabinmaszynowy_obrona_sila=$karabinmaszynowy_obrona*$karabinmaszynowy_cel;
  $mustang_obrona_sila=$mustang_obrona*$mustang_cel;
  $dzialolot_obrona_sila=$dzialolot_obrona*$dzialolot_cel;
  $F35_obrona_sila=$F35_obrona*$F35_cel;
  $patriot_obrona_sila=$patriot_obrona*$patriot_cel;
  $northropB2_obrona_sila=$northropB2_obrona*$northropB2_cel;
  $tomahawk_obrona_sila=$tomahawk_obrona*$tomahawk_cel;
  $ladowa_obrona_sila=$miecznik_obrona_sila+$lucznik_obrona_sila+$kawalerzysta_obrona_sila+$lucznikkon_obrona_sila+$karabin_obrona_sila+$armata_obrona_sila+$czolg_obrona_sila+$karabinmaszynowy_obrona_sila;
  echo 'obrona ladowa '.$ladowa_obrona_sila. ' <br>';
  $powietrzna_obrona_sila=$mustang_obrona_sila+$F35_obrona_sila+$northropB2_obrona_sila+$tomahawk_obrona_sila;
  echo 'obrona powietrzna '.$powietrzna_obrona_sila. ' <br>';
  $przeciwlotnicza_obrona_sila=$dzialolot_obrona_sila+$patriot_obrona_sila;
  echo 'obrona przeciwlotnicza '.$przeciwlotnicza_obrona_sila. ' <br>';
  if($powietrzny_atak_sila>$przeciwlotnicza_obrona_sila){
    if($przeciwlotnicza_obrona_sila>0){
  $bitwa_przeciwlotnicza=$powietrzny_atak_sila/$przeciwlotnicza_obrona_sila;
  $bitwa_przeciwlotnicza=$bitwa_przeciwlotnicza*$bitwa_przeciwlotnicza;
  echo $bitwa_przeciwlotnicza. 'bitwa_przeciwlotnicza <br>';
  $mustang_ilosc_nowa=round($mustang_ilosc-$mustang_ilosc/$bitwa_przeciwlotnicza);
  $F35_ilosc_nowa=round($F35_ilosc-$F35_ilosc/$bitwa_przeciwlotnicza);
  $northropB2_ilosc_nowa=round($northropB2_ilosc-$northropB2_ilosc/$bitwa_przeciwlotnicza);
  $tomahawk_ilosc_nowa=round($tomahawk_ilosc-$tomahawk_ilosc/$bitwa_przeciwlotnicza);
  }}
  else{
    $mustang_ilosc_nowa=$mustang_ilosc;
    $F35_ilosc_nowa=$F35_ilosc;
    $northropB2_ilosc_nowa=$northropB2_ilosc;
    $tomahawk_ilosc_nowa=$tomahawk_ilosc;
  }
  echo $mustang_ilosc_nowa. ' mustang <br>';
  echo $F35_ilosc_nowa. ' f35 <br>';
  echo $northropB2_ilosc_nowa. ' northrop <br>';
  echo $tomahawk_ilosc_nowa. ' tomahawk <br>';
  $mustang_atak_sila=$mustang_atak*$mustang_ilosc_nowa;
  $F35_atak_sila=$F35_atak*$F35_ilosc_nowa;
  $northropB2_atak_sila=$northropB2_atak*$northropB2_ilosc_nowa;
  $tomahawk_atak_sila=$tomahawk_atak*$tomahawk_ilosc_nowa;
  $powietrzny_atak_sila=$mustang_atak_sila+$F35_atak_sila+$northropB2_atak_sila+$tomahawk_atak_sila;
  if($powietrzny_atak_sila>$przeciwlotnicza_obrona_sila){
    $patriot_cel_nowa=0;
    $dzialolot_cel_nowa=0;
    }
  else{
    if($powietrzny_atak_sila>0){
    $bitwa_przeciwlotnicza2=$przeciwlotnicza_obrona_sila/$powietrzny_atak_sila;
    $bitwa_przeciwlotnicza2=$bitwa_przeciwlotnicza2*$bitwa_przeciwlotnicza2;
    echo $bitwa_przeciwlotnicza2. ' <br>';
    $patriot_cel_nowa=round($patriot_cel-$patriot_cel/$bitwa_przeciwlotnicza2);
    $dzialolot_cel_nowa=round($dzialolot_cel-$dzialolot_cel/$bitwa_przeciwlotnicza2);
    }
    if($powietrzny_atak_sila==0){
      $patriot_cel_nowa=$patriot_cel;
      $dzialolot_cel_nowa=$dzialolot_cel;
    }
  }
    echo $patriot_cel_nowa. ' patriot <br>';
    echo $dzialolot_cel_nowa. ' dzialolot <br>';
    $dzialolot_obrona_sila=$dzialolot_obrona*$dzialolot_cel_nowa;
    $patriot_obrona_sila=$patriot_obrona*$patriot_cel_nowa;
    $przeciwlotnicza_obrona_sila=$dzialolot_obrona_sila+$patriot_obrona_sila;
    echo 'atak powietrzny '.$powietrzny_atak_sila. ' <br>';
    echo 'obrona powetrzna '.$powietrzna_obrona_sila. ' <br>';
    if($powietrzna_obrona_sila>0 && $powietrzny_atak_sila>0){
      $powietrzna_obrona_sila=$powietrzna_obrona_sila*$morale_wartosc;
      if($powietrzny_atak_sila>$powietrzna_obrona_sila){
        echo 'mocny atak <br>';
        $mustang_cel_nowa=0;
        $F35_cel_nowa=0;
        $northropB2_cel_nowa=0;
        $tomahawk_cel_nowa=0;
        echo $F35_cel_nowa. ' f35 cel<br>';
        $bitwa_lotnicza=$powietrzny_atak_sila/$powietrzna_obrona_sila;
        $bitwa_lotnicza=$bitwa_lotnicza*$bitwa_lotnicza;
        echo $bitwa_lotnicza. 'bitwa_lotnicza <br>';
        $mustang_ilosc_nowa=round($mustang_ilosc_nowa-$mustang_ilosc_nowa/$bitwa_lotnicza);
        $F35_ilosc_nowa=round($F35_ilosc_nowa-$F35_ilosc_nowa/$bitwa_lotnicza);
        $northropB2_ilosc_nowa=round($northropB2_ilosc_nowa-$northropB2_ilosc_nowa/$bitwa_lotnicza);
        $tomahawk_ilosc_nowa=round($tomahawk_ilosc_nowa-$tomahawk_ilosc_nowa/$bitwa_lotnicza);
      }
      if($powietrzny_atak_sila<$powietrzna_obrona_sila){
        echo 'mocna obrona <br>';
        $mustang_ilosc_nowa=0;
        $F35_ilosc_nowa=0;
        $northropB2_ilosc_nowa=0;
        $tomahawk_ilosc_nowa=0;
        $bitwa_lotnicza=$powietrzna_obrona_sila/$powietrzny_atak_sila;
        $bitwa_lotnicza=$bitwa_lotnicza*$bitwa_lotnicza;
        echo $bitwa_lotnicza. 'bitwa_lotnicza <br>';
        $mustang_cel_nowa=round($mustang_cel-$mustang_cel/$bitwa_lotnicza);
        $F35_cel_nowa=round($F35_cel-$F35_cel/$bitwa_lotnicza);
        $northropB2_cel_nowa=round($northropB2_cel-$northropB2_cel/$bitwa_lotnicza);
        $tomahawk_cel_nowa=round($tomahawk_cel-$tomahawk_cel/$bitwa_lotnicza);
      }}
      else{
        $mustang_cel_nowa=$mustang_cel;
        $F35_cel_nowa=$F35_cel;
        $northropB2_cel_nowa=$northropB2_cel;
        $tomahawk_cel_nowa=$tomahawk_cel;
      }
    
    if($powietrzny_atak_sila==$powietrzna_obrona_sila){
      $mustang_cel_nowa=0;
      $F35_cel_nowa=0;
      $northropB2_cel_nowa=0;
      $tomahawk_cel_nowa=0;
      $mustang_ilosc_nowa=0;
      $F35_ilosc_nowa=0;
      $northropB2_ilosc_nowa=0;
      $tomahawk_ilosc_nowa=0;
    }
      echo $mustang_ilosc_nowa. ' mustang <br>';
      echo $F35_ilosc_nowa. ' f35 <br>';
      echo $northropB2_ilosc_nowa. ' northrop <br>';
      echo $tomahawk_ilosc_nowa. ' tomahawk <br>';
      echo $mustang_cel_nowa. ' mustang cel<br>';
      echo $F35_cel_nowa. ' f35 cel<br>';
      echo $northropB2_cel_nowa. ' northrop cel<br>';
      echo $tomahawk_cel_nowa. ' tomahawk cel <br>';
      echo 'po bitwie lotniczej <br>';
      $mustang_atak_sila=$mustang_ilosc_nowa*$mustang_atak;
      $F35_atak_sila=$F35_ilosc_nowa*$F35_atak;
      $northropB2_atak_sila=$northropB2_ilosc_nowa*$northropB2_atak;
      $tomahawk_atak_sila=$tomahawk_ilosc_nowa*$tomahawk_atak;
      $powietrzny_atak_sila=$mustang_atak_sila+$F35_atak_sila+$northropB2_atak_sila+$tomahawk_atak_sila;
      echo 'atak powietrzny '.$powietrzny_atak_sila. ' <br>';
     
      if($przeciwlotnicza_obrona_sila>0 && $powietrzny_atak_sila>0){
        if($powietrzny_atak_sila>$przeciwlotnicza_obrona_sila){
          echo 'mocny atak <br>';
          $patriot_cel_nowa=0;
          $dzialolot_cel_nowa=0;
          $bitwa_przeciwlotnicza=$powietrzny_atak_sila/$przeciwlotnicza_obrona_sila;
          $bitwa_przeciwlotnicza=$bitwa_przeciwlotnicza*$bitwa_przeciwlotnicza;
          echo $bitwa_lotnicza. 'bitwa_lotnicza <br>';
          $mustang_ilosc_nowa=round($mustang_ilosc_nowa-$mustang_ilosc_nowa/$bitwa_przeciwlotnicza);
          $F35_ilosc_nowa=round($F35_ilosc_nowa-$F35_ilosc_nowa/$bitwa_przeciwlotnicza);
          $northropB2_ilosc_nowa=round($northropB2_ilosc_nowa-$northropB2_ilosc_nowa/$bitwa_przeciwlotnicza);
          $tomahawk_ilosc_nowa=round($tomahawk_ilosc_nowa-$tomahawk_ilosc_nowa/$bitwa_przeciwlotnicza);
        }
        if($powietrzny_atak_sila<$przeciwlotnicza_obrona_sila){
          echo 'mocna obrona <br>';
          $mustang_ilosc_nowa=0;
          $F35_ilosc_nowa=0;
          $northropB2_ilosc_nowa=0;
          $tomahawk_ilosc_nowa=0;
          $bitwa_przeciwlotnicza=$przeciwlotnicza_obrona_sila/$powietrzny_atak_sila;
          $bitwa_przeciwlotnicza=$bitwa_przeciwlotnicza*$bitwa_przeciwlotnicza;
          echo $bitwa_przeciwlotnicza. 'bitwa_przeciwlotnicza <br>';
          $patriot_cel_nowa=round($patriot_cel-$patriot_cel/$bitwa_przeciwlotnicza);
          $dzialolot_cel_nowa=round($dzialolot_cel-$dzialolot_cel/$bitwa_przeciwlotnicza);
        }
      }
      if($powietrzny_atak_sila==$przeciwlotnicza_obrona_sila){
        $patriot_cel_nowa=0;
        $dzialolot_cel_nowa=0;
        $mustang_ilosc_nowa=0;
        $F35_ilosc_nowa=0;
        $northropB2_ilosc_nowa=0;
        $tomahawk_ilosc_nowa=0;
      }
      echo $mustang_ilosc_nowa. ' mustang <br>';
      echo $F35_ilosc_nowa. ' f35 <br>';
      echo $northropB2_ilosc_nowa. ' northrop <br>';
      echo $tomahawk_ilosc_nowa. ' tomahawk <br>';
      echo $patriot_cel_nowa. ' patriot cel<br>';
      echo $dzialolot_cel_nowa. ' dzialolot cel<br>';


      if($ladowa_obrona_sila>0 && $ladowy_atak_sila>0){
        echo ' bitwa lądowa<br>';
        $ladowa_obrona_sila=$ladowa_obrona_sila*$morale_wartosc;
        if($ladowy_atak_sila>$ladowa_obrona_sila){
          echo 'mocny atak <br>';
          $miecznik_cel_nowa=0;
          $lucznik_cel_nowa=0;
          $kawalerzysta_cel_nowa=0;
          $lucznikkon_cel_nowa=0;
          $karabin_cel_nowa=0;
          $armata_cel_nowa=0;
          $czolg_cel_nowa=0;
          $karabinmaszynowy_cel_nowa=0;
          $bitwa_ladowa=$ladowy_atak_sila/$ladowa_obrona_sila;
          $bitwa_ladowa=$bitwa_ladowa*$bitwa_ladowa;
          echo $bitwa_ladowa. 'bitwa_ladowa <br>';
          $miecznik_ilosc_nowa=round($miecznik_ilosc-$miecznik_ilosc/$bitwa_ladowa);
          $lucznik_ilosc_nowa=round($lucznik_ilosc-$lucznik_ilosc/$bitwa_ladowa);
          $kawalerzysta_ilosc_nowa=round($kawalerzysta_ilosc-$kawalerzysta_ilosc/$bitwa_ladowa);
          $lucznikkon_ilosc_nowa=round($lucznikkon_ilosc-$lucznikkon_ilosc/$bitwa_ladowa);
          $karabin_ilosc_nowa=round($karabin_ilosc-$karabin_ilosc/$bitwa_ladowa);
          $armata_ilosc_nowa=round($armata_ilosc-$armata_ilosc/$bitwa_ladowa);
          $czolg_ilosc_nowa=round($czolg_ilosc-$czolg_ilosc/$bitwa_ladowa);
          $karabinmaszynowy_ilosc_nowa=round($karabinmaszynowy_ilosc-$karabinmaszynowy_ilosc/$bitwa_ladowa);
        }
        if($ladowy_atak_sila<$ladowa_obrona_sila){
          echo 'mocna obrona <br>';
          $miecznik_ilosc_nowa=0;
          $lucznik_ilosc_nowa=0;
          $kawalerzysta_ilosc_nowa=0;
          $lucznikkon_ilosc_nowa=0;
          $karabin_ilosc_nowa=0;
          $armata_ilosc_nowa=0;
          $czolg_ilosc_nowa=0;
          $karabinmaszynowy_ilosc_nowa=0;
          $bitwa_ladowa=$ladowa_obrona_sila/$ladowy_atak_sila;
          $bitwa_ladowa=$bitwa_ladowa*$bitwa_ladowa;
          echo $bitwa_ladowa. 'bitwa_ladowa <br>';
          $miecznik_cel_nowa=round($miecznik_cel-$miecznik_cel/$bitwa_ladowa);
          $lucznik_cel_nowa=round($lucznik_cel-$lucznik_cel/$bitwa_ladowa);
          $kawalerzysta_cel_nowa=round($kawalerzysta_cel-$kawalerzysta_cel/$bitwa_ladowa);
          $lucznikkon_cel_nowa=round($lucznikkon_cel-$lucznikkon_cel/$bitwa_ladowa);
          $karabin_cel_nowa=round($karabin_cel-$karabin_cel/$bitwa_ladowa);
          $armata_cel_nowa=round($armata_cel-$armata_cel/$bitwa_ladowa);
          $czolg_cel_nowa=round($czolg_cel-$czolg_cel/$bitwa_ladowa);
          $karabinmaszynowy_cel_nowa=round($karabinmaszynowy_cel-$karabinmaszynowy_cel/$bitwa_ladowa);
        }
      }
      else{
        $miecznik_ilosc_nowa=$miecznik_ilosc;
        $lucznik_ilosc_nowa=$lucznik_ilosc;
        $kawalerzysta_ilosc_nowa=$kawalerzysta_ilosc;
        $lucznikkon_ilosc_nowa=$lucznikkon_ilosc;
        $karabin_ilosc_nowa=$karabin_ilosc;
        $armata_ilosc_nowa=$armata_ilosc;
        $czolg_ilosc_nowa=$czolg_ilosc;
        $karabinmaszynowy_ilosc_nowa=$karabinmaszynowy_ilosc;
        $miecznik_cel_nowa=$miecznik_cel;
        $lucznik_cel_nowa=$lucznik_cel;
        $kawalerzysta_cel_nowa=$kawalerzysta_cel;
        $lucznikkon_cel_nowa=$lucznikkon_cel;
        $karabin_cel_nowa=$karabin_cel;
        $armata_cel_nowa=$armata_cel;
        $czolg_cel_nowa=$czolg_cel;
        $karabinmaszynowy_cel_nowa=$karabinmaszynowy_cel;
      }
      if($ladowy_atak_sila==$ladowa_obrona_sila){
        $miecznik_ilosc_nowa=0;
        $lucznik_ilosc_nowa=0;
        $kawalerzysta_ilosc_nowa=0;
        $lucznikkon_ilosc_nowa=0;
        $karabin_ilosc_nowa=0;
        $armata_ilosc_nowa=0;
        $czolg_ilosc_nowa=0;
        $karabinmaszynowy_ilosc_nowa=0;
        $miecznik_cel_nowa=0;
        $lucznik_cel_nowa=0;
        $kawalerzysta_cel_nowa=0;
        $lucznikkon_cel_nowa=0;
        $karabin_cel_nowa=0;
        $armata_cel_nowa=0;
        $czolg_cel_nowa=0;
        $karabinmaszynowy_cel_nowa=0;
      }
      echo $miecznik_ilosc_nowa. ' miecznik <br>';
      echo $lucznik_ilosc_nowa. ' lucznik <br>';
      echo $kawalerzysta_ilosc_nowa. ' kawalerzysta <br>';
      echo $lucznikkon_ilosc_nowa. ' lucznikkon <br>';
      echo $karabin_ilosc_nowa. ' karabin <br>';
      echo $armata_ilosc_nowa. ' armata <br>';
      echo $czolg_ilosc_nowa. ' czolg <br>';
      echo $karabinmaszynowy_ilosc_nowa. ' karabinmaszynowy<br>';
      echo $miecznik_cel_nowa. ' miecznik cel<br>';
      echo $lucznik_cel_nowa. ' lucznik cel<br>';
      echo $kawalerzysta_cel_nowa. ' kawalerzysta cel<br>';
      echo $lucznikkon_cel_nowa. ' lucznikkon cel<br>';
      echo $karabin_cel_nowa. ' karabin cel<br>';
      echo $armata_cel_nowa. ' armata cel<br>';
      echo $czolg_cel_nowa. ' czolg cel<br>';
      echo $karabinmaszynowy_cel_nowa. ' karabinmaszynowy cel<br>';
      echo 'po bitwie ladowej <br>';
      $mustang_atak_sila=$mustang_ilosc_nowa*$mustang_atak;
      $F35_atak_sila=$F35_ilosc_nowa*$F35_atak;
      $northropB2_atak_sila=$northropB2_ilosc_nowa*$northropB2_atak;
      $tomahawk_atak_sila=$tomahawk_ilosc_nowa*$tomahawk_atak;
      $powietrzny_atak_sila=$mustang_atak_sila+$F35_atak_sila+$northropB2_atak_sila+$tomahawk_atak_sila;

      $mustang_obrona_sila=$mustang_cel_nowa*$mustang_obrona;
      $F35_obrona_sila=$F35_cel_nowa*$F35_obrona;
      $northropB2_obrona_sila=$northropB2_cel_nowa*$northropB2_obrona;
      $tomahawk_obrona_sila=$tomahawk_cel_nowa*$tomahawk_obrona;
      $powietrzna_obrona_sila=$mustang_obrona_sila+$F35_obrona_sila+$northropB2_obrona_sila+$tomahawk_obrona_sila;

      $miecznik_atak_sila=$miecznik_ilosc_nowa*$miecznik_atak;
      $lucznik_atak_sila=$lucznik_ilosc_nowa*$lucznik_atak;
      $kawalerzysta_atak_sila=$kawalerzysta_ilosc_nowa*$kawalerzysta_atak;
      $lucznikkon_atak_sila=$lucznikkon_ilosc_nowa*$lucznikkon_atak;
      $karabin_atak_sila=$karabin_ilosc_nowa*$karabin_atak;
      $armata_atak_sila=$armata_ilosc_nowa*$armata_atak;
      $czolg_atak_sila=$czolg_ilosc_nowa*$czolg_atak;
      $karabinmaszynowy_atak_sila=$karabinmaszynowy_ilosc_nowa*$karabinmaszynowy_atak;
      $ladowy_atak_sila=$miecznik_atak_sila+$lucznik_atak_sila+$kawalerzysta_atak_sila+$lucznikkon_atak_sila+$karabin_atak_sila+$armata_atak_sila+$czolg_atak_sila+$karabinmaszynowy_atak_sila;

      $miecznik_obrona_sila=$miecznik_cel_nowa*$miecznik_obrona;
      $lucznik_obrona_sila=$lucznik_cel_nowa*$lucznik_obrona;
      $kawalerzysta_obrona_sila=$kawalerzysta_cel_nowa*$kawalerzysta_obrona;
      $lucznikkon_obrona_sila=$lucznikkon_cel_nowa*$lucznikkon_obrona;
      $karabin_obrona_sila=$karabin_cel_nowa*$karabin_obrona;
      $armata_obrona_sila=$armata_cel_nowa*$armata_obrona;
      $czolg_obrona_sila=$czolg_cel_nowa*$czolg_obrona;
      $karabinmaszynowy_obrona_sila=$karabinmaszynowy_cel_nowa*$karabinmaszynowy_obrona;
      $ladowa_obrona_sila=$miecznik_obrona_sila+$lucznik_obrona_sila+$kawalerzysta_obrona_sila+$lucznikkon_obrona_sila+$karabin_obrona_sila+$armata_obrona_sila+$czolg_obrona_sila+$karabinmaszynowy_obrona_sila;
  
  if($powietrzny_atak_sila>0 && $ladowa_obrona_sila>0){
    $ladowa_obrona_sila=$ladowa_obrona_sila*$morale_wartosc;
    if($ladowa_obrona_sila>$powietrzny_atak_sila){
      $obronca_wygrany=1;
      $bitwa_ladowo_lotnicza=$powietrzny_atak_sila/$ladowa_obrona_sila;
      $bitwa_ladowo_lotnicza=$bitwa_ladowo_lotnicza*$bitwa_ladowo_lotnicza;
      echo $bitwa_ladowo_lotnicza. 'bitwa lotnictwa atak i ladowej obrony <br>';
      $miecznik_cel_nowa=round($miecznik_cel_nowa-$miecznik_cel_nowa/$bitwa_ladowo_lotnicza);
      $lucznik_cel_nowa=round($lucznik_cel_nowa-$lucznik_cel_nowa/$bitwa_ladowo_lotnicza);
      $kawalerzysta_cel_nowa=round($kawalerzysta_cel_nowa-$kawalerzysta_cel_nowa/$bitwa_ladowo_lotnicza);
      $lucznikkon_cel_nowa=round($lucznikkon_cel_nowa-$lucznikkon_cel_nowa/$bitwa_ladowo_lotnicza);
      $karabin_cel_nowa=round($karabin_cel_nowa-$karabin_cel_nowa/$bitwa_ladowo_lotnicza);
      $armata_cel_nowa=round($armata_cel_nowa-$armata_cel_nowa/$bitwa_ladowo_lotnicza);
      $czolg_cel_nowa=round($czolg_cel_nowa-$czolg_cel_nowa/$bitwa_ladowo_lotnicza);
      $karabinmaszynowy_cel_nowa=round($karabinmaszynowy_cel_nowa-$karabinmaszynowy_cel_nowa/$bitwa_ladowo_lotnicza);
    }
    if($ladowa_obrona_sila<=$powietrzny_atak_sila){
      $obronca_wygrany=0;
      echo 'bitwa lotnictwa atak i ladowej obrony <br>';
      $miecznik_cel_nowa=0;
      $lucznik_cel_nowa=0;
      $kawalerzysta_cel_nowa=0;
      $lucznikkon_cel_nowa=0;
      $karabin_cel_nowa=0;
      $armata_cel_nowa=0;
      $czolg_cel_nowa=0;
      $karabinmaszynowy_cel_nowa=0;
    }
  }
  if($ladowy_atak_sila>0 && $powietrzna_obrona_sila>0){
    $powietrzna_obrona_sila=$powietrzna_obrona_sila*$morale_wartosc;
    if($powietrzna_obrona_sila<$ladowy_atak_sila){
      $obronca_wygrany=0;
      $bitwa_ladowo_lotnicza=$ladowy_atak_sila/$powietrzna_obrona_sila;
      $bitwa_ladowo_lotnicza=$bitwa_ladowo_lotnicza*$bitwa_ladowo_lotnicza;
      echo $bitwa_ladowo_lotnicza. 'bitwa lodowy atak i obrona lotnicza <br>';
      $mustang_cel_nowa=0;
      $F35_cel_nowa=0;
      $northropB2_cel_nowa=0;
      $tomahawk_cel_nowa=0;
      $miecznik_ilosc_nowa=round($miecznik_ilosc_nowa-$miecznik_ilosc_nowa/$bitwa_ladowo_lotnicza);
      $lucznik_ilosc_nowa=round($lucznik_ilosc_nowa-$lucznik_ilosc_nowa/$bitwa_ladowo_lotnicza);
      $kawalerzysta_ilosc_nowa=round($kawalerzysta_ilosc_nowa-$kawalerzysta_ilosc_nowa/$bitwa_ladowo_lotnicza);
      $lucznikkon_ilosc_nowa=round($lucznikkon_ilosc_nowa-$lucznikkon_ilosc_nowa/$bitwa_ladowo_lotnicza);
      $karabin_ilosc_nowa=round($karabin_ilosc_nowa-$karabin_ilosc_nowa/$bitwa_ladowo_lotnicza);
      $armata_ilosc_nowa=round($armata_ilosc_nowa-$armata_ilosc_nowa/$bitwa_ladowo_lotnicza);
      $czolg_ilosc_nowa=round($czolg_ilosc_nowa-$czolg_ilosc_nowa/$bitwa_ladowo_lotnicza);
      $karabinmaszynowy_ilosc_nowa=round($karabinmaszynowy_ilosc_nowa-$karabinmaszynowy_ilosc_nowa/$bitwa_ladowo_lotnicza);
    }
    if($powietrzna_obrona_sila>=$ladowy_atak_sila){
      $obronca_wygrany=1;
      echo $bitwa_ladowo_lotnicza. 'bitwa lodowy atak i obrona lotnicza <br>';
      $miecznik_ilosc_nowa=0;
      $lucznik_ilosc_nowa=0;
      $kawalerzysta_ilosc_nowa=0;
      $lucznikkon_ilosc_nowa=0;
      $karabin_ilosc_nowa=0;
      $armata_ilosc_nowa=0;
      $czolg_ilosc_nowa=0;
      $karabinmaszynowy_ilosc_nowa=0;
    }
  }
    $mustang_atak_sila=$mustang_ilosc_nowa*$mustang_atak;
    $F35_atak_sila=$F35_ilosc_nowa*$F35_atak;
    $northropB2_atak_sila=$northropB2_ilosc_nowa*$northropB2_atak;
    $tomahawk_atak_sila=$tomahawk_ilosc_nowa*$tomahawk_atak;
    $powietrzny_atak_sila=$mustang_atak_sila+$F35_atak_sila+$northropB2_atak_sila+$tomahawk_atak_sila;

    $mustang_obrona_sila=$mustang_cel_nowa*$mustang_obrona;
    $F35_obrona_sila=$F35_cel_nowa*$F35_obrona;
    $northropB2_obrona_sila=$northropB2_cel_nowa*$northropB2_obrona;
    $tomahawk_obrona_sila=$tomahawk_cel_nowa*$tomahawk_obrona;
    $powietrzna_obrona_sila=$mustang_obrona_sila+$F35_obrona_sila+$northropB2_obrona_sila+$tomahawk_obrona_sila;

    $miecznik_atak_sila=$miecznik_ilosc_nowa*$miecznik_atak;
    $lucznik_atak_sila=$lucznik_ilosc_nowa*$lucznik_atak;
    $kawalerzysta_atak_sila=$kawalerzysta_ilosc_nowa*$kawalerzysta_atak;
    $lucznikkon_atak_sila=$lucznikkon_ilosc_nowa*$lucznikkon_atak;
    $karabin_atak_sila=$karabin_ilosc_nowa*$karabin_atak;
    $armata_atak_sila=$armata_ilosc_nowa*$armata_atak;
    $czolg_atak_sila=$czolg_ilosc_nowa*$czolg_atak;
    $karabinmaszynowy_atak_sila=$karabinmaszynowy_ilosc_nowa*$karabinmaszynowy_atak;
    $ladowy_atak_sila=$miecznik_atak_sila+$lucznik_atak_sila+$kawalerzysta_atak_sila+$lucznikkon_atak_sila+$karabin_atak_sila+$armata_atak_sila+$czolg_atak_sila+$karabinmaszynowy_atak_sila;

    $miecznik_obrona_sila=$miecznik_cel_nowa*$miecznik_obrona;
    $lucznik_obrona_sila=$lucznik_cel_nowa*$lucznik_obrona;
    $kawalerzysta_obrona_sila=$kawalerzysta_cel_nowa*$kawalerzysta_obrona;
    $lucznikkon_obrona_sila=$lucznikkon_cel_nowa*$lucznikkon_obrona;
    $karabin_obrona_sila=$karabin_cel_nowa*$karabin_obrona;
    $armata_obrona_sila=$armata_cel_nowa*$armata_obrona;
    $czolg_obrona_sila=$czolg_cel_nowa*$czolg_obrona;
    $karabinmaszynowy_obrona_sila=$karabinmaszynowy_cel_nowa*$karabinmaszynowy_obrona;
    $ladowa_obrona_sila=$miecznik_obrona_sila+$lucznik_obrona_sila+$kawalerzysta_obrona_sila+$lucznikkon_obrona_sila+$karabin_obrona_sila+$armata_obrona_sila+$czolg_obrona_sila+$karabinmaszynowy_obrona_sila;
  
    if($powietrzny_atak_sila+$ladowy_atak_sila==0){
      $obronca_wygrany=1;
    }
    if($powietrzna_obrona_sila>0){
      $obronca_wygrany=1;
    }
    if($ladowa_obrona_sila>0){
      $obronca_wygrany=1;
    }
    if($powietrzna_obrona_sila+$ladowa_obrona_sila==0){
      $obronca_wygrany=0;
    }
    $miecznik_straty=$miecznik_ilosc-$miecznik_ilosc_nowa;
    $lucznik_straty=$lucznik_ilosc-$lucznik_ilosc_nowa;
    $kawalerzysta_straty=$kawalerzysta_ilosc-$kawalerzysta_ilosc_nowa;
    $lucznikkon_straty=$lucznikkon_ilosc-$lucznikkon_ilosc_nowa;
    $karabin_straty=$karabin_ilosc-$karabin_ilosc_nowa;
    $armata_straty=$armata_ilosc-$miecznik_ilosc_nowa;
    $czolg_straty=$czolg_ilosc-$czolg_ilosc_nowa;
    $karabinmaszynowy_straty=$karabinmaszynowy_ilosc-$karabinmaszynowy_ilosc_nowa;
    $mustang_straty=$mustang_ilosc-$mustang_ilosc_nowa;
    $F35_straty=$F35_ilosc-$F35_ilosc_nowa;
    $northropB2_straty=$northropB2_ilosc-$northropB2_ilosc_nowa;
    $tomahawk_straty=$tomahawk_ilosc-$tomahawk_ilosc_nowa;
    

    if($obronca_wygrany==0){
      $cywile_sila=$cywile_cel*10;
      $sila_koniec=$powietrzny_atak_sila+$ladowy_atak_sila;
      echo $cywile_sila.' cywile sila <br>';
      echo $sila_koniec.' sila koniec <br>';
      if($cywile_sila<$sila_koniec){
        $morale=0;
        echo 'wyzerowano morale <br>';
      }
      echo 'cywile '.$cywile_cel.'<br>';
      if($morale==0){
        $sql = "UPDATE wioska SET id_uczestnika=$id_uczestnika WHERE id=$id_wioski_cel";
        $polaczenie->query($sql);
        $sql = "UPDATE wioska SET miecznik=miecznik-$miecznik_straty, lucznik=lucznik-$lucznik_straty,
        kawalerzysta=kawalerzysta-$kawalerzysta_straty, lucznikkon=lucznikkon-$lucznikkon_straty, karabin=karabin-$karabin_straty,
        armata=armata-$armata_straty, czolg=czolg-$czolg_straty, karabinmaszynowy=karabinmaszynowy-$karabinmaszynowy_straty,
        mustang=mustang-$mustang_straty, F35=F35-$F35_straty, northropB2=northropB2-$northropB2_straty, 
        tomahawk=tomahawk-$tomahawk_straty WHERE id=$id_wioski";
      $polaczenie->query($sql);
        $sql = "UPDATE wioska SET miecznik=$miecznik_cel_nowa, lucznik=$lucznik_cel_nowa,
        kawalerzysta=$kawalerzysta_cel_nowa, lucznikkon=$lucznikkon_cel_nowa, karabin=$karabin_cel_nowa,
        armata=$armata_cel_nowa, czolg=$czolg_cel_nowa, karabinmaszynowy=$karabinmaszynowy_cel_nowa,
        mustang=$mustang_cel_nowa, F35=$F35_cel_nowa, northropB2=$northropB2_cel_nowa, 
        tomahawk=$tomahawk_cel_nowa WHERE id=$id_wioski_cel";
      $polaczenie->query($sql);
  $sql = "SELECT * FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_atakowany";
  if($rezultat = $polaczenie->query($sql))
      {
          $ile_wiosek = $rezultat->num_rows;
      }
if($ile_wiosek>0){
  $sql = "SELECT gospodarstwo FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_atakowany";
      if($rezultat = $polaczenie->query($sql))
      {
          $ile_wiosek = $rezultat->num_rows;
          $predkosc_cala=0;
          for($i=0;$i<$ile_wiosek;$i++){
          $wiersz = $rezultat->fetch_assoc();
          $predkosc_wioski=2**$wiersz['gospodarstwo'];
          $predkosc_cala=$predkosc_cala+$predkosc_wioski;
          }
          $sql = "UPDATE uczestnicy SET predkosc_zywnosc=$predkosc_cala WHERE id=$id_uczestnik_atakowany";
          $polaczenie->query($sql); 
      }    
  $sql = "SELECT tartak FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_atakowany";
  if($rezultat = $polaczenie->query($sql))
  {
      $ile_wiosek = $rezultat->num_rows;
      $predkosc_cala=0;
      for($i=0;$i<$ile_wiosek;$i++){
      $wiersz = $rezultat->fetch_assoc();
      $predkosc_wioski=2**$wiersz['tartak'];
      $predkosc_cala=$predkosc_cala+$predkosc_wioski;
      }
      $sql = "UPDATE uczestnicy SET predkosc_drewno=$predkosc_cala WHERE id=$id_uczestnik_atakowany";
      $polaczenie->query($sql); 
  }
  $sql = "SELECT kamieniolom FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_atakowany";
      if($rezultat = $polaczenie->query($sql))
      {
          $ile_wiosek = $rezultat->num_rows;
          $predkosc_cala=0;
          for($i=0;$i<$ile_wiosek;$i++){
          $wiersz = $rezultat->fetch_assoc();
          $predkosc_wioski=2**$wiersz['kamieniolom'];
          $predkosc_cala=$predkosc_cala+$predkosc_wioski;
          }
          $sql = "UPDATE uczestnicy SET predkosc_kamien=$predkosc_cala WHERE id=$id_uczestnik_atakowany";
          $polaczenie->query($sql); 
      }
  $sql = "SELECT kuznia, huta FROM wioska WHERE mecz=$id_meczu AND id_uczestnika=$id_uczestnik_atakowany";
      if($rezultat = @$polaczenie->query($sql))
      {
          $ile_wiosek = $rezultat->num_rows;
          $predkosc_cala=0;
          for($i=0;$i<$ile_wiosek;$i++){
          $wiersz = $rezultat->fetch_assoc();
          $predkosc_wioskih=100*(2**$wiersz['huta']);
          $predkosc_wioskik=2**$wiersz['kuznia'];
          $predkosc_cala=$predkosc_cala+$predkosc_wioskih+$predkosc_wioskik;
          }
          $sql = "UPDATE uczestnicy SET predkosc_metal=$predkosc_cala WHERE id=$id_uczestnik_atakowany";
          $polaczenie->query($sql); 
      }       
    }  
    if($ile_wiosek==0){ 
      $sql = "UPDATE uczestnicy SET uczestnictwo=-1 WHERE id=$id_uczestnik_atakowany";
      $polaczenie->query($sql);
    }  
    }
      if($morale>0){
        $morale=$morale-1;
      }
    }
    echo $obronca_wygrany. ' wynik (1 oznacza wygrał obrońca) <br>';
    echo $morale. ' morale po bitwie <br>';
}
$polaczenie->close();
    }
    //header('Location: ratusz.php');

?>




