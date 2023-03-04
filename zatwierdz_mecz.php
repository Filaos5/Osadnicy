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
    if(isset($_SESSION['mecz_przeslany'])){
        if($_SESSION['mecz_przeslany']>0)
        {
            $id_meczu=$_SESSION['mecz_przeslany'];
        }
    }
    else{
        header('Location: moje_konto.php');
    }
    $sql = "UPDATE uczestnicy SET zatwierdzone=1, predkosc_zl=20 WHERE mecz='$id_meczu'";
    @$polaczenie->query($sql);

    $polaczenie->close();
    }
    header('Location: moje_konto.php');
?>