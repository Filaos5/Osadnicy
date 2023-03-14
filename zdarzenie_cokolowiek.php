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
$id_user=$_SESSION['id_sesji'];
$id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
$id_meczu=$_SESSION['mecz_przeslany'];

$sql = "SELECT * FROM szkolenia WHERE zrobione==0 ORDER BY kiedy_koniec";
if($rezultat = @$polaczenie->query($sql))
{
    $ile_zdarzen = $rezultat->num_rows;
    $wiersz = $rezultat->fetch_assoc();
    for($i=0;$i<ile_zdarzen;$i++){
        $jednostka=$wiersz['jednostka'];
        $ilosc=$wiersz['ilosc'];
        $wioska=$wiersz['wioska'];
        $mecz=$wiersz['mecz'];
        $id=$wiersz["id"];
        $sql = "UPDATE wioska SET $jednostka=$jednostka+$ilosc WHERE id=$id_wioski";
        @$polaczenie->query($sql)
        $sql = "UPDATE wioska SET zrobione=1 WHERE id==$id";
    }
}

?>