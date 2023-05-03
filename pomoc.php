<?php
    session_start();
    //$_SESSION['zalogowany']=false;
    if(isset($_SESSION['zalogowany'])){
        if($_SESSION['zalogowany']==true)
        {
            //header('Location: index.php');
        }
    }

    require_once "secure.php";
 
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
   
    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno." Opis: ". $polaczenie->connect_error;
        //header('Location: index.php');
    }
    else{
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
echo("<br>");
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


if( $miecznik_ilosc<=$miecznik_zrodlo && $lucznik_ilosc<=$lucznik_zrodlo && $kawalerzysta_ilosc<=$kawalerzysta_zrodlo
&& $lucznikkon_ilosc<=$lucznikkon_zrodlo && $karabin_ilosc<=$karabin_zrodlo && $armata_ilosc<=$armata_zrodlo
&& $czolg_ilosc<=$czolg_zrodlo && $karabinmaszynowy_ilosc<=$karabinmaszynowy_zrodlo && $mustang_ilosc<=$mustang_zrodlo
&& $F35_ilosc<=$F35_zrodlo && $northropB2_ilosc<=$northropB2_zrodlo && $tomahawk_ilosc<=$tomahawk_zrodlo &&
$miecznik_ilosc>=0 && $lucznik_ilosc>=0 && $kawalerzysta_ilosc>=0
&& $lucznikkon_ilosc>=0 && $karabin_ilosc>=0 && $armata_ilosc>=0
&& $czolg_ilosc>=0 && $karabinmaszynowy_ilosc>=0 && $mustang_ilosc>=0
&& $F35_ilosc>=0 && $northropB2_ilosc>=0 && $tomahawk_ilosc>=0){
  echo("<br>");
  echo 'wyslano';
  //$wioska_zrodlo['miecznik']=$wioska_zrodlo['miecznik']-$miecznik_ilosc;
  //$wioska_zrodlo['lucznik']=$wioska_zrodlo['lucznik']- $lucznik_ilosc;
  //$wioska_zrodlo['kawalerzysta']=$wioska_zrodlo['kawalerzysta']-$kawalerzysta_ilosc;
  //$wioska_zrodlo['lucznikkon']=$wioska_zrodlo['lucznikkon']-$lucznikkon_ilosc;
  //$wioska_zrodlo['karabin']=$wioska_zrodlo['karabin']-$karabin_ilosc;
  //$wioska_zrodlo['armata']=$wioska_zrodlo['armata']-$armata_ilosc;
  //$wioska_zrodlo['czolg']=$wioska_zrodlo['czolg']-$czolg_ilosc;
  //$wioska_zrodlo['karabinmaszynowy']=$wioska_zrodlo['karabinmaszynowy']-$karabinmaszynowy_ilosc;
  //$wioska_zrodlo['mustang']=$wioska_zrodlo['mustang']-$mustang_ilosc;
  //$wioska_zrodlo['F35']=$wioska_zrodlo['F35']-$F35_ilosc;
  //$wioska_zrodlo['northropB2']=$wioska_zrodlo['northropB2']-$northropB2_ilosc;
  //$wioska_zrodlo['tomahawk']=$wioska_zrodlo['tomahawk']-$tomahawk_ilosc;

  $sql = "UPDATE wioska SET miecznik=miecznik-$miecznik_ilosc, lucznik=lucznik-$lucznik_ilosc,
  kawalerzysta=kawalerzysta-$kawalerzysta_ilosc, lucznikkon=lucznikkon-$lucznikkon_ilosc, karabin=karabin-$karabin_ilosc,
  armata=armata-$armata_ilosc, czolg=czolg-$czolg_ilosc, karabinmaszynowy=karabinmaszynowy-$karabinmaszynowy_ilosc,
  mustang=mustang-$mustang_ilosc, F35=F35-$F35_ilosc, northropB2=northropB2-$northropB2_ilosc, 
  tomahawk=tomahawk-$tomahawk_ilosc WHERE id=$id_wioski";
      $polaczenie->query($sql);
  $sql = "UPDATE wioska SET miecznik=miecznik+$miecznik_ilosc, lucznik=lucznik+$lucznik_ilosc,
  kawalerzysta=kawalerzysta+$kawalerzysta_ilosc, lucznikkon=lucznikkon+$lucznikkon_ilosc, karabin=karabin+$karabin_ilosc,
  armata=armata+$armata_ilosc, czolg=czolg+$czolg_ilosc, karabinmaszynowy=karabinmaszynowy+$karabinmaszynowy_ilosc,
  mustang=mustang+$mustang_ilosc, F35=F35+$F35_ilosc, northropB2=northropB2+$northropB2_ilosc, 
  tomahawk=tomahawk+$tomahawk_ilosc WHERE id=$id_wioski_cel";
      $polaczenie->query($sql);
      $_SESSION['id_wioski']=$id_wioski;
}
else{
    echo('Location: ratusz.php');
    $_SESSION['atak_jednostki_malo']=1;
    header('Location: ratusz.php');
  }
    }
    header('Location: ratusz.php');

?>




