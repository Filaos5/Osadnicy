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
    $czas=time();
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($_SESSION['link']==0){
    $kolejne_przejscie=(string)$_POST['kolejne_przejscie'];
    if(empty((string)$_POST['kolejne_przejscie'])){
      $kolejne_przejscie=$_SESSION['kolejne_przejscie'];
    }
    //$kolejne_przejscie=$_SESSION['kolejne_przejscie'];
   // $kolejne_przejscie=(string)$_SESSION['link'];
    }
    else{
      $kolejne_przejscie=$_SESSION['kolejne_przejscie'];
     // $kolejne_przejscie=(string)$_SESSION['link'];
     //$kolejne_przejscie=(string)$_POST['kolejne_przejscie'];
    }
    if(isset($_SESSION['mapa'])){
    if($_SESSION['mapa']==1){
        $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
        $_SESSION['mapa']=0;
    }
    if($_SESSION['mapa']==2){
        $_SESSION['wioska_pozycja_atakowana']=$_POST['wioska_Pozycja'];
        $_SESSION['mapa']=0;
    }
  }
    echo "$kolejne_przejscie\n";
   
    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno." Opis: ". $polaczenie->connect_error;
        //header('Location: index.php');
    }
    else{
$id_user=$_SESSION['id_sesji'];
//$id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
//$id_meczu=$_SESSION['mecz_przeslany'];
echo "dddddd";
echo "oo";
$sql = "SELECT * FROM budowa WHERE zrobione=0 AND kiedy_koniec<$czas ORDER BY kiedy_koniec";
if($rezultat = @$polaczenie->query($sql))
{
$ile_zdarzen = $rezultat->num_rows;
echo $ile_zdarzen;
$wiersz = $rezultat->fetch_assoc();
echo "oo1";
for($i=0;$i<$ile_zdarzen;$i++){
    echo "oo2";
    $budynek=$wiersz['budynek'];
    $ilosc=$wiersz['ilosc'];
    $wioska=$wiersz['wioska'];
    $mecz=$wiersz['mecz'];
    $id=$wiersz['id'];
    echo "oo3";
    $koniec_budowy=$wiersz['kiedy_koniec'];
    $sql2 = "SELECT * FROM wioska WHERE mecz=$mecz AND id= $wioska";
    if($rezultat = @$polaczenie->query($sql2))
    {
        $wiersz2 = $rezultat->fetch_assoc();
        $czas=time();
        echo "oo4";
        if($czas>$koniec_budowy){
            echo "oo5";
            if($budynek != 'blok' && $budynek != 'dom'){
            $sql3 = "UPDATE wioska SET $budynek=$budynek+1 WHERE id=$wioska AND mecz=$mecz";
            @$polaczenie->query($sql3);
            $sql4 = "UPDATE budowa SET zrobione=1 WHERE id=$id";
            @$polaczenie->query($sql4);
            }
            $predkosc_wioski=2**($ilosc-1);
            if($budynek=='tartak'){
                $roznica=$czas-$koniec_budowy;
                $naliczenie=($predkosc_wioski/2)*$roznica;
            $sql = "UPDATE wioska SET predkosc_drewno=$predkosc_wioski, drewno=drewno+$naliczenie WHERE id=$wioska";
            $polaczenie->query($sql);
            }
            if($budynek=='gospodarstwo'){
                $roznica=$czas-$koniec_budowy;
                $naliczenie=($predkosc_wioski/2)*$roznica;
              $sql = "UPDATE wioska SET predkosc_zywnosc=$predkosc_wioski, zywnosc=zywnosc+$naliczenie WHERE id=$wioska";
              $polaczenie->query($sql);
            }
            //$id_w=$id_wioski;
            if($budynek=='kamieniolom'){
                $roznica=$czas-$koniec_budowy;
                $naliczenie=($predkosc_wioski/2)*$roznica;
              $sql = "UPDATE wioska SET predkosc_kamien=$predkosc_wioski, kamien=kamien+$naliczenie WHERE id=$wioska";
              $polaczenie->query($sql);
            }
            if($budynek=='kuznia' || $budynek=='huta'){
                echo "oo6";
                $sql = "SELECT kuznia, huta FROM wioska WHERE id=$wioska";
            if($rezultat = @$polaczenie->query($sql))
            {
                echo "oo7";
                $ile_wiosek = $rezultat->num_rows;
                $predkosc_cala=0;
                $wiersz = $rezultat->fetch_assoc();
                $predkosc_wioskih=0;
                $predkosc_wioskik=0;
                if($wiersz['huta']>0){
                $predkosc_wioskih=100*(2**($wiersz['huta']-1));
                }
                if($wiersz['kuznia']>0){
                $predkosc_wioskik=2**($wiersz['kuznia']-1);
                }
                $roznica=$czas-$koniec_budowy;
                $naliczenieh=($predkosc_wioskih/2)*$roznica;
                $naliczeniek=($predkosc_wioskik/2)*$roznica;
                $naliczenie=$naliczenieh+$naliczeniek;
                $predkosc_cala=$predkosc_cala+$predkosc_wioskih+$predkosc_wioskik;
                $sql = "UPDATE wioska SET predkosc_metal=$predkosc_cala, metal=metal+$naliczenie WHERE id=$wioska";
                $polaczenie->query($sql); 
            }
        }
        
            if($budynek=='blok' || $budynek=='dom'){
                $sql3 = "UPDATE wioska SET $budynek=$budynek+$ilosc WHERE id=$wioska AND mecz=$mecz";
            @$polaczenie->query($sql3);
            $sql4 = "UPDATE budowa SET zrobione=1 WHERE id=$id";
            @$polaczenie->query($sql4);
            }
            

        }
    }
}
}

echo "atak";
$sql = "SELECT * FROM ataki WHERE zrobione=0 AND czas_dotarcia<$czas ORDER BY czas_dotarcia";
if($rezultat_a = @$polaczenie->query($sql))
{
    $ile_zdarzen = $rezultat_a->num_rows;
    echo $ile_zdarzen;
    $wiersz = $rezultat_a->fetch_assoc();
    echo "aa1";
    if($ile_zdarzen==0){
      $sql = "SELECT * FROM szkolenia WHERE zrobione=0 AND kiedy_koniec<$czas ORDER BY kiedy_koniec";

        if($rezultat = @$polaczenie->query($sql))
        {
            $ile_szkolen = $rezultat->num_rows;
            $wiersz_szkolenie = $rezultat->fetch_assoc();
            for($i=0;$i<$ile_szkolen;$i++){
                $jednostka=$wiersz_szkolenie['jednostka'];
                $ilosc=$wiersz_szkolenie['ilosc'];
                $wioska=$wiersz_szkolenie['wioska'];
                $mecz=$wiersz_szkolenie['mecz'];
                $id=$wiersz_szkolenie['id'];
                $koniec_szkolenia=$wiersz_szkolenie['kiedy_koniec'];
                $sql2 = "SELECT * FROM wioska WHERE mecz=$mecz AND id= $wioska";
                if($rezultat = @$polaczenie->query($sql2))
                {
                    $wiersz2 = $rezultat->fetch_assoc();
                    $czas=time();
                    if($czas>$koniec_szkolenia){
                    $ilosc_wojska=$wiersz2[$jednostka];
                    $sql3 = "UPDATE wioska SET $jednostka=$ilosc_wojska+$ilosc WHERE id=$wioska AND mecz=$mecz";
                    @$polaczenie->query($sql3);
                    $sql4 = "UPDATE szkolenia SET zrobione=1 WHERE id=$id";
                    @$polaczenie->query($sql4);
                    }
                }
            }
        }

    }
    else{
    for($i=0;$i<$ile_zdarzen;$i++){
        $miecznik_ilosc=(int)$wiersz['miecznik'];
        $lucznik_ilosc=(int)$wiersz['lucznik'];
        $kawalerzysta_ilosc=(int)$wiersz['kawalerzysta'];
        $lucznikkon_ilosc=(int)$wiersz['lucznikkon'];
        $karabin_ilosc=(int)$wiersz['karabin'];
        $armata_ilosc=(int)$wiersz['armata'];
        $czolg_ilosc=(int)$wiersz['czolg'];
        $karabinmaszynowy_ilosc=(int)$wiersz['karabinmaszynowy'];
        $mustang_ilosc=(int)$wiersz['mustang'];
        $F35_ilosc=(int)$wiersz['F35'];
        $northropB2_ilosc=(int)$wiersz['NorthropB2'];
        $tomahawk_ilosc=(int)$wiersz['tomahawk'];
        $id_wioski=(int)$wiersz['wioska_poczatek'];
        $id_wioski_cel=(int)$wiersz['wioska_koniec'];
        $id_ataku=(int)$wiersz['id'];
        $uczestnik=(int)$wiersz['uczestnik'];
        $czas_dotarcia=(int)$wiersz['czas_dotarcia'];



        $sql = "SELECT * FROM szkolenia WHERE zrobione=0 AND kiedy_koniec<$czas_dotarcia ORDER BY kiedy_koniec";

        if($rezultat = @$polaczenie->query($sql))
        {
            $ile_szkolen = $rezultat->num_rows;
            $wiersz_szkolenie = $rezultat->fetch_assoc();
            for($i=0;$i<$ile_szkolen;$i++){
                $jednostka=$wiersz_szkolenie['jednostka'];
                $ilosc=$wiersz_szkolenie['ilosc'];
                $wioska=$wiersz_szkolenie['wioska'];
                $mecz=$wiersz_szkolenie['mecz'];
                $id=$wiersz_szkolenie['id'];
                $koniec_szkolenia=$wiersz_szkolenie['kiedy_koniec'];
                $sql2 = "SELECT * FROM wioska WHERE mecz=$mecz AND id= $wioska";
                if($rezultat = @$polaczenie->query($sql2))
                {
                    $wiersz2 = $rezultat->fetch_assoc();
                    $czas=time();
                    if($czas>$koniec_szkolenia){
                    $ilosc_wojska=$wiersz2[$jednostka];
                    $sql3 = "UPDATE wioska SET $jednostka=$ilosc_wojska+$ilosc WHERE id=$wioska AND mecz=$mecz";
                    @$polaczenie->query($sql3);
                    $sql4 = "UPDATE szkolenia SET zrobione=1 WHERE id=$id";
                    @$polaczenie->query($sql4);
                    }
                }
            }
        }
      

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
    if($wiersz['sojusz_atak']==0){
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

$sql = "UPDATE wioska SET miecznik=miecznik+$miecznik_ilosc, lucznik=lucznik+$lucznik_ilosc,
kawalerzysta=kawalerzysta+$kawalerzysta_ilosc, lucznikkon=lucznikkon+$lucznikkon_ilosc, karabin=karabin+$karabin_ilosc,
armata=armata+$armata_ilosc, czolg=czolg+$czolg_ilosc, karabinmaszynowy=karabinmaszynowy+$karabinmaszynowy_ilosc,
mustang=mustang+$mustang_ilosc, F35=F35+$F35_ilosc, northropB2=northropB2+$northropB2_ilosc, 
tomahawk=tomahawk+$tomahawk_ilosc WHERE id=$id_wioski_cel";
    $polaczenie->query($sql);
    
$sql2 = "UPDATE ataki SET zrobione=1 WHERE id=$id_ataku";
$polaczenie->query($sql2);
    } 
    
if($wiersz['sojusz_atak']==1){
$sql = "SELECT * FROM wioska WHERE id='$id_wioski_cel'";
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
 if($wioska_cel['lotnisko']==1){
 $mustang_cel=$wioska_cel['mustang'];
 }
 $dzialolot_cel=$wioska_cel['dzialolot'];
 if($wioska_cel['lotnisko']==1){
 $F35_cel=$wioska_cel['F35'];
 }
 $patriot_cel=$wioska_cel['patriot'];
 if($wioska_cel['lotnisko']==1){
 $northropB2_cel=$wioska_cel['northropB2'];
 $tomahawk_cel=$wioska_cel['tomahawk'];
 }
 if($wioska_cel['lotnisko']==0){
  $mustang_cel=0;
  $F35_cel=0;
  $northropB2_cel=0;
  $tomahawk_cel=0;
 }
 $cywile_cel=$wioska_cel['cywile'];
 $morale=$wioska_cel['morale'];
 $id_uczestnik_atakowany=$wioska_cel['id_uczestnika'];
 $sql = "SELECT * FROM morale WHERE id=$morale";
 if($rezultat3 = @$polaczenie->query($sql))
 {
     $morale_cel = $rezultat3->fetch_assoc();
 }
 $morale_wartosc=$morale_cel['poziom'];
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
/*
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
*/
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
 //echo 'atak ladowy '.$ladowy_atak_sila. ' <br>';
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
//  echo $bitwa_przeciwlotnicza. 'bitwa_przeciwlotnicza <br>';
 $mustang_ilosc_nowa=round($mustang_ilosc-$mustang_ilosc/$bitwa_przeciwlotnicza);
 $F35_ilosc_nowa=round($F35_ilosc-$F35_ilosc/$bitwa_przeciwlotnicza);
 $northropB2_ilosc_nowa=round($northropB2_ilosc-$northropB2_ilosc/$bitwa_przeciwlotnicza);
 $tomahawk_ilosc_nowa=round($tomahawk_ilosc-$tomahawk_ilosc/$bitwa_przeciwlotnicza);
 }
if($przeciwlotnicza_obrona_sila==0){
 $mustang_ilosc_nowa=$mustang_ilosc;
   $F35_ilosc_nowa=$F35_ilosc;
   $northropB2_ilosc_nowa=$northropB2_ilosc;
   $tomahawk_ilosc_nowa=$tomahawk_ilosc;
}
}
 else{
   $mustang_ilosc_nowa=0;
   $F35_ilosc_nowa=0;
   $northropB2_ilosc_nowa=0;
   $tomahawk_ilosc_nowa=0;
 }
 echo $mustang_ilosc;
 echo $northropB2_ilosc;
 /*
 echo $mustang_ilosc_nowa. ' mustang <br>';
 echo $F35_ilosc_nowa. ' f35 <br>';
 echo $northropB2_ilosc_nowa. ' northrop <br>';
 echo $tomahawk_ilosc_nowa. ' tomahawk <br>';
 */
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
//   echo $bitwa_przeciwlotnicza2. ' <br>';
   $patriot_cel_nowa=round($patriot_cel-$patriot_cel/$bitwa_przeciwlotnicza2);
   $dzialolot_cel_nowa=round($dzialolot_cel-$dzialolot_cel/$bitwa_przeciwlotnicza2);
   }
   if($powietrzny_atak_sila==0){
     $patriot_cel_nowa=$patriot_cel;
     $dzialolot_cel_nowa=$dzialolot_cel;
   }
 }
//   echo $patriot_cel_nowa. ' patriot <br>';
//   echo $dzialolot_cel_nowa. ' dzialolot <br>';
   $dzialolot_obrona_sila=$dzialolot_obrona*$dzialolot_cel_nowa;
   $patriot_obrona_sila=$patriot_obrona*$patriot_cel_nowa;
   $przeciwlotnicza_obrona_sila=$dzialolot_obrona_sila+$patriot_obrona_sila;
//   echo 'atak powietrzny '.$powietrzny_atak_sila. ' <br>';
//   echo 'obrona powetrzna '.$powietrzna_obrona_sila. ' <br>';
   if($powietrzna_obrona_sila>0 && $powietrzny_atak_sila>0){
     $powietrzna_obrona_sila=$powietrzna_obrona_sila*$morale_wartosc;
     if($powietrzny_atak_sila>$powietrzna_obrona_sila){
//        echo 'mocny atak <br>';
       $mustang_cel_nowa=0;
       $F35_cel_nowa=0;
       $northropB2_cel_nowa=0;
       $tomahawk_cel_nowa=0;
//       echo $F35_cel_nowa. ' f35 cel<br>';
       $bitwa_lotnicza=$powietrzny_atak_sila/$powietrzna_obrona_sila;
       $bitwa_lotnicza=$bitwa_lotnicza*$bitwa_lotnicza;
//       echo $bitwa_lotnicza. 'bitwa_lotnicza <br>';
       $mustang_ilosc_nowa=round($mustang_ilosc_nowa-$mustang_ilosc_nowa/$bitwa_lotnicza);
       $F35_ilosc_nowa=round($F35_ilosc_nowa-$F35_ilosc_nowa/$bitwa_lotnicza);
       $northropB2_ilosc_nowa=round($northropB2_ilosc_nowa-$northropB2_ilosc_nowa/$bitwa_lotnicza);
       $tomahawk_ilosc_nowa=round($tomahawk_ilosc_nowa-$tomahawk_ilosc_nowa/$bitwa_lotnicza);
     }
     if($powietrzny_atak_sila<$powietrzna_obrona_sila){
   //    echo 'mocna obrona <br>';
       $mustang_ilosc_nowa=0;
       $F35_ilosc_nowa=0;
       $northropB2_ilosc_nowa=0;
       $tomahawk_ilosc_nowa=0;
       $bitwa_lotnicza=$powietrzna_obrona_sila/$powietrzny_atak_sila;
       $bitwa_lotnicza=$bitwa_lotnicza*$bitwa_lotnicza;
  //     echo $bitwa_lotnicza. 'bitwa_lotnicza <br>';
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
   /*
     echo $mustang_ilosc_nowa. ' mustang <br>';
     echo $F35_ilosc_nowa. ' f35 <br>';
     echo $northropB2_ilosc_nowa. ' northrop <br>';
     echo $tomahawk_ilosc_nowa. ' tomahawk <br>';
     echo $mustang_cel_nowa. ' mustang cel<br>';
     echo $F35_cel_nowa. ' f35 cel<br>';
     echo $northropB2_cel_nowa. ' northrop cel<br>';
     echo $tomahawk_cel_nowa. ' tomahawk cel <br>';
     echo 'po bitwie lotniczej <br>';
     */
     $mustang_atak_sila=$mustang_ilosc_nowa*$mustang_atak;
     $F35_atak_sila=$F35_ilosc_nowa*$F35_atak;
     $northropB2_atak_sila=$northropB2_ilosc_nowa*$northropB2_atak;
     $tomahawk_atak_sila=$tomahawk_ilosc_nowa*$tomahawk_atak;
     $powietrzny_atak_sila=$mustang_atak_sila+$F35_atak_sila+$northropB2_atak_sila+$tomahawk_atak_sila;
 //    echo 'atak powietrzny '.$powietrzny_atak_sila. ' <br>';
    
     if($przeciwlotnicza_obrona_sila>0 && $powietrzny_atak_sila>0){
       if($powietrzny_atak_sila>$przeciwlotnicza_obrona_sila){
   //      echo 'mocny atak <br>';
         $patriot_cel_nowa=0;
         $dzialolot_cel_nowa=0;
         $bitwa_przeciwlotnicza=$powietrzny_atak_sila/$przeciwlotnicza_obrona_sila;
         $bitwa_przeciwlotnicza=$bitwa_przeciwlotnicza*$bitwa_przeciwlotnicza;
      //   echo $bitwa_lotnicza. 'bitwa_lotnicza <br>';
         $mustang_ilosc_nowa=round($mustang_ilosc_nowa-$mustang_ilosc_nowa/$bitwa_przeciwlotnicza);
         $F35_ilosc_nowa=round($F35_ilosc_nowa-$F35_ilosc_nowa/$bitwa_przeciwlotnicza);
         $northropB2_ilosc_nowa=round($northropB2_ilosc_nowa-$northropB2_ilosc_nowa/$bitwa_przeciwlotnicza);
         $tomahawk_ilosc_nowa=round($tomahawk_ilosc_nowa-$tomahawk_ilosc_nowa/$bitwa_przeciwlotnicza);
       }
       if($powietrzny_atak_sila<$przeciwlotnicza_obrona_sila){
   //      echo 'mocna obrona <br>';
         $mustang_ilosc_nowa=0;
         $F35_ilosc_nowa=0;
         $northropB2_ilosc_nowa=0;
         $tomahawk_ilosc_nowa=0;
         $bitwa_przeciwlotnicza=$przeciwlotnicza_obrona_sila/$powietrzny_atak_sila;
         $bitwa_przeciwlotnicza=$bitwa_przeciwlotnicza*$bitwa_przeciwlotnicza;
   //      echo $bitwa_przeciwlotnicza. 'bitwa_przeciwlotnicza <br>';
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
     /*
     echo $mustang_ilosc_nowa. ' mustang <br>';
     echo $F35_ilosc_nowa. ' f35 <br>';
     echo $northropB2_ilosc_nowa. ' northrop <br>';
     echo $tomahawk_ilosc_nowa. ' tomahawk <br>';
     echo $patriot_cel_nowa. ' patriot cel<br>';
     echo $dzialolot_cel_nowa. ' dzialolot cel<br>';
*/

     if($ladowa_obrona_sila>0 && $ladowy_atak_sila>0){
 //      echo ' bitwa lądowa<br>';
       $ladowa_obrona_sila=$ladowa_obrona_sila*$morale_wartosc;
       if($ladowy_atak_sila>$ladowa_obrona_sila){
    //     echo 'mocny atak <br>';
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
      //   echo $bitwa_ladowa. 'bitwa_ladowa <br>';
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
     //   echo 'mocna obrona <br>';
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
     //    echo $bitwa_ladowa. 'bitwa_ladowa <br>';
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
     /*
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
     */
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
   //  echo $bitwa_ladowo_lotnicza. 'bitwa lotnictwa atak i ladowej obrony <br>';
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
  //   echo 'bitwa lotnictwa atak i ladowej obrony <br>';
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
    // echo $bitwa_ladowo_lotnicza. 'bitwa lodowy atak i obrona lotnicza <br>';
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
   //  echo $bitwa_ladowo_lotnicza. 'bitwa lodowy atak i obrona lotnicza <br>';
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
   /*
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
*/
$sql = "UPDATE ataki SET zrobione=1 WHERE id=$id_ataku";
$polaczenie->query($sql);



$czas=time();
$sql = "SELECT * FROM wioska WHERE id=$id_wioski";   
if($rezultat3 = @$polaczenie->query($sql))
{
    $wioska_dane = $rezultat3->fetch_assoc();
    $pozycja_x_start=$wioska_dane['pozycjax'];
    $pozycja_y_start=$wioska_dane['pozycjay'];
}
$sql = "SELECT * FROM wioska WHERE id=$id_wioski_cel";   
if($rezultat4 = @$polaczenie->query($sql))
{
    $wioska_dane_cel = $rezultat4->fetch_assoc();
    $pozycja_x_cel=$wioska_dane_cel['pozycjax'];
    $pozycja_y_cel=$wioska_dane_cel['pozycjay'];
}
$pola=sqrt(($pozycja_x_start-$pozycja_x_cel) ** 2 + ($pozycja_y_start-$pozycja_y_cel) ** 2);
$predkosc=100000;
if($miecznik_ilosc>0){
$sql = "SELECT * FROM wojsko WHERE Nazwa='Miecznik'";   
if($rezultat4 = @$polaczenie->query($sql))
{
    $wojsko = $rezultat4->fetch_assoc();
    $predkosc_pobrana=$wojsko['predkosc'];
    if($predkosc_pobrana<$predkosc){
        $predkosc=$predkosc_pobrana;
    }
}
}
if($lucznik_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Lucznik'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($kawalerzysta_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Kawalerzysta'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($lucznikkon_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Lucznikkon'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($karabin_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Karabin'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($armata_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Armata'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($czolg_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Czolg'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($karabinmaszynowy_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Karabinmaszynowy'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($mustang_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Mustang'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($F35_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='F35'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($northropB2_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='NorthropB2'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
if($tomahawk_ilosc>0){
    $sql = "SELECT * FROM wojsko WHERE Nazwa='Tomahawk'";   
    if($rezultat4 = @$polaczenie->query($sql))
    {
        $wojsko = $rezultat4->fetch_assoc();
        $predkosc_pobrana=$wojsko['predkosc'];
        if($predkosc_pobrana<$predkosc){
            $predkosc=$predkosc_pobrana;
        }
    }
}
$czas_drogi=($pola*20*3600)/$predkosc;
$czas_dotarcia2=$czas_dotarcia+$czas_drogi;
   $sql = "INSERT INTO ataki ( uczestnik, zrobione, sojusz_atak, czas_dotarcia, wioska_poczatek, wioska_koniec, miecznik, lucznik, kawalerzysta, katapulta, karabin, armata, czolg, karabinmaszynowy, mustang, F35, NorthropB2, tomahawk)
   VALUES ( $uczestnik, 0, 0, $czas_dotarcia2, $id_wioski_cel, $id_wioski, $miecznik_ilosc_nowa, $lucznik_ilosc_nowa, $kawalerzysta_ilosc_nowa, $lucznikkon_ilosc_nowa, $karabin_ilosc_nowa, $armata_ilosc_nowa, $czolg_ilosc_nowa, $karabinmaszynowy_ilosc_nowa, $mustang_ilosc_nowa, $F35_ilosc_nowa, $northropB2_ilosc_nowa, $tomahawk_ilosc_nowa)";
   $polaczenie->query($sql);

  $sql = "UPDATE wioska SET miecznik=$miecznik_cel_nowa, lucznik=$lucznik_cel_nowa,
  kawalerzysta=$kawalerzysta_cel_nowa, lucznikkon=$lucznikkon_cel_nowa, karabin=$karabin_cel_nowa,
  armata=$armata_cel_nowa, czolg=$czolg_cel_nowa, karabinmaszynowy=$karabinmaszynowy_cel_nowa,
  mustang=$mustang_cel_nowa, F35=$F35_cel_nowa, northropB2=$northropB2_cel_nowa, 
  tomahawk=$tomahawk_cel_nowa WHERE id=$id_wioski_cel";
$polaczenie->query($sql);


if($obronca_wygrany==0){
  ?>
  <h4>Ataktujacy wygrany</h4>
  <?php 
  $cywile_sila=$cywile_cel*10;
  $sila_koniec=$powietrzny_atak_sila+$ladowy_atak_sila;
  //echo $cywile_sila.' cywile sila <br>';
  //echo $sila_koniec.' sila koniec <br>';
  if($cywile_sila<$sila_koniec){
    $morale=0;
   // echo 'wyzerowano morale <br>';
  }
 // echo 'cywile '.$cywile_cel.'<br>';

  if($morale<1){
    $sql_c = "SELECT * FROM wioska WHERE id=$id_wioski_cel";  
    if($rezultat_c = @$polaczenie->query($sql_c))
{
    $wiersz_c = $rezultat_c->fetch_assoc();
    $id_user_atakowany=$wiersz_c['id_uczestnika'];
}

    $sql = "UPDATE wioska SET id_uczestnika=$uczestnik WHERE id=$id_wioski_cel";
    $polaczenie->query($sql);
    }    
    $sql_d = "SELECT * FROM wioska WHERE id_uczestnika=$id_user_atakowany";  
    if($rezultat_d = @$polaczenie->query($sql_d))
    {
    $ile_wiosek = $rezultat_d->num_rows;
    }
          
        if($ile_wiosek==0){ 
          $sql = "UPDATE uczestnicy SET uczestnictwo=-1 WHERE id=$id_uczestnik_atakowany";
          $polaczenie->query($sql);
        }  
        }
          if($morale>1){
            $morale=$morale-1;
            $sql = "UPDATE wioska SET morale=$morale WHERE id=$id_wioski_cel";
          $polaczenie->query($sql);
          }
          if($morale<1){
            $morale=1;
            $sql = "UPDATE wioska SET morale=$morale WHERE id=$id_wioski_cel";
          $polaczenie->query($sql);
          }  
  }
}
}
}
}
if($_SESSION['link']==1){
  $kolejne_przejscie=$_SESSION['kolejne_przejscie'];
header('Location: '.$kolejne_przejscie.'.php');
}
else{
    $przekierowanie=$_SESSION['kolejne_przejscie'];
    //$kolejne_przejscie=$_SESSION['kolejne_przejscie'];
    $_SESSION['link']=0; 
    header('Location: '.$kolejne_przejscie.'.php');   
}
$polaczenie->close();
    
?>