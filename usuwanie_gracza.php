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
        if(isset($_SESSION['uzytkownik_przeslany'])){
            if($_SESSION['uzytkownik_przeslany']<1)
            {
                $_SESSION['uzytkownik_przeslany']=$_POST['mGracz'];
            }
        }
        else{
            $_SESSION['uzytkownik_przeslany']=$_POST['mGracz'];
        }
        //$_SESSION['uzytkownik_przeslany']=$_POST['mGracz'];
        $uzytkownik_przeslany=$_SESSION['uzytkownik_przeslany'];
        //echo "uzytkownik";
        //echo $_SESSION['uzytkownik_przeslany'];
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
        //echo "mecz";
        //echo $_SESSION['mecz_przeslany'];
    $sql = "SELECT * FROM uczestnicy WHERE id_user='$uzytkownik_przeslany' AND mecz='$id_meczu'";
    //echo $sql;
    if($rezultat = @$polaczenie->query($sql))
    {
        $gracz = $rezultat->fetch_assoc();          
    }
    //$era=$gracz['era'];
    //echo $era;
    $id_gracza=$gracz['id'];
    //echo $id_gracza;
    $sql = "UPDATE wioska SET id_uczestnika=0 WHERE mecz='$id_meczu' AND id_uczestnika='$id_gracza'";
    @$polaczenie->query($sql);

    $sql = "DELETE FROM uczestnicy WHERE id_user='$uzytkownik_przeslany' AND mecz='$id_meczu'";
    @$polaczenie->query($sql);
    $polaczenie->close();
    $_SESSION['uzytkownik_przeslany']=-1;
    }
    header('Location: tworzenie_meczu.php');
?>