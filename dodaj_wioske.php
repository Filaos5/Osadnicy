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
    //$id_user=$_SESSION['id_sesji'];
    if(isset($_SESSION['uzytkownik_przeslany'])){
        if($_SESSION['uzytkownik_przeslany']==-1)
        {
            header('Location: moje_konto.php');
        }
    }
    else{
        header('Location: moje_konto.php');
    }
     $uzytkownik_przeslany=$_SESSION['uzytkownik_przeslany'];
     if(isset($_SESSION['mecz_przeslany'])){
        if($_SESSION['mecz_przeslany']==0)
        {
            header('Location: moje_konto.php');
        }
    }
    else{
        header('Location: moje_konto.php');
    }
    $id_meczu=$_SESSION['mecz_przeslany'];
    if(isset($_SESSION['wioska_pozycja'])){
        if($_SESSION['wioska_pozycja']<0)
        {
            $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
        }
    }
    else{
        $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
    }
    $wioska_pozycja=(int)$_SESSION['wioska_pozycja'];
 
    //$sql = "SELECT * FROM uczestnicy WHERE mecz='$mecz'";
   // if($rezultat2 = @$polaczenie->query($sql))
   // {
   //     $wiersz2 = $rezultat2->fetch_assoc();
   //     $id_uczestnika=$wiersz2['id'];
   // }
   $pozycja_x=((int)$wioska_pozycja)%20;
   $pozycja_y=((((int)$wioska_pozycja)-$pozycja_x)/20)+1;
   $pozycja_x=$pozycja_x+1;
        //    }
        //}
    $czas=(int)time();
    if($_SESSION['uzytkownik_zalogowany']!=$uzytkownik_przeslany){
    $sql = "INSERT INTO uczestnicy ( id_user, mecz, era, czas, uczestnictwo, zatwierdzone)
            VALUES ( '$uzytkownik_przeslany', '$id_meczu', 1, '$czas', 1, 0)";
            $polaczenie->query($sql);    

    }
    $sql = "SELECT id FROM uczestnicy WHERE id_user='$uzytkownik_przeslany' AND mecz='$id_meczu'";
    if($rezultat = $polaczenie->query($sql))
 {
     $ilu_userow = $rezultat->num_rows;
     $wiersz = $rezultat->fetch_assoc();
     $id=$wiersz['id'];

    
 }
 //echo $id;
    $sql = "UPDATE wioska SET id_uczestnika='$id', cywile=20, predkosc_zl=20 WHERE mecz='$id_meczu' AND pozycjax=$pozycja_x AND pozycjay=$pozycja_y";
    $polaczenie->query($sql);
    $_SESSION['uzytkownik_przeslany']=0;
    $_SESSION['wioska_pozycja']=-1;
    $polaczenie->close();
    }
    header('Location: tworzenie_meczu.php');
?>