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
    $mustang_ilosc=0;
    $F35_ilosc=0;
    $northropB2_ilosc=0;
    $tomahawk_ilosc=0;
    if(isset($_POST['mustang_ilosc'])){
    $mustang_ilosc=(int)$_POST['mustang_ilosc'];
    }
    if(isset($_POST['F35_ilosc'])){
    $F35_ilosc=(int)$_POST['F35_ilosc'];
    }
    if(isset($_POST['northropB2_ilosc'])){
    $northropB2_ilosc=(int)$_POST['northropB2_ilosc'];
    }
    if(isset($_POST['northropB2_ilosc'])){
    $tomahawk_ilosc=(int)$_POST['tomahawk_ilosc'];
    }
    $id_wioski=$_SESSION['id_wioski'];
    $id_wioski_cel=$_SESSION['wioska_cel'];
    if(isset($_SESSION['atak'])){
    $atak=$_SESSION['atak'];
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
    $czas_dotarcia=$czas+$czas_drogi;
    $sql = "INSERT INTO ataki ( uczestnik, zrobione, sojusz_atak, czas_dotarcia, wioska_poczatek, wioska_koniec, miecznik, lucznik, kawalerzysta, katapulta, karabin, armata, czolg, karabinmaszynowy, mustang, F35, NorthropB2, tomahawk)
    VALUES ( $id_uczestnik_zalogowany, 0, $atak, $czas_dotarcia, $id_wioski, $id_wioski_cel, $miecznik_ilosc, $lucznik_ilosc, $kawalerzysta_ilosc, $lucznikkon_ilosc, $karabin_ilosc, $armata_ilosc, $czolg_ilosc, $karabinmaszynowy_ilosc, $mustang_ilosc, $F35_ilosc, $northropB2_ilosc, $tomahawk_ilosc)";
    $polaczenie->query($sql);
    $sql = "UPDATE wioska SET miecznik=miecznik-$miecznik_ilosc, lucznik=lucznik-$lucznik_ilosc,
    kawalerzysta=kawalerzysta-$kawalerzysta_ilosc, lucznikkon=lucznikkon-$lucznikkon_ilosc, karabin=karabin-$karabin_ilosc,
    armata=armata-$armata_ilosc, czolg=czolg-$czolg_ilosc, karabinmaszynowy=karabinmaszynowy-$karabinmaszynowy_ilosc,
    mustang=mustang-$mustang_ilosc, F35=F35-$F35_ilosc, northropB2=northropB2-$northropB2_ilosc, 
    tomahawk=tomahawk-$tomahawk_ilosc WHERE id=$id_wioski";
  $polaczenie->query($sql);
    }
    header('Location: ratusz.php');
}

?>