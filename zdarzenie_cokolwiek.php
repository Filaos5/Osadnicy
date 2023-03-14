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
    if($_SESSION['link']==0){
    $kolejne_przejscie=(string)$_POST['kolejne_przejscie'];
    
    }
    if($_SESSION['mapa']==1){
        $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
        $_SESSION['mapa']=0;
    }
    if($_SESSION['mapa']==2){
        $_SESSION['wioska_pozycja_atakowana']=$_POST['wioska_Pozycja'];
        $_SESSION['mapa']=0;
    }
    echo "$kolejne_przejscie\n";
   
    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno." Opis: ". $polaczenie->connect_error;
        //header('Location: index.php');
    }
    else{
$id_user=$_SESSION['id_sesji'];
$id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
$id_meczu=$_SESSION['mecz_przeslany'];

$sql = "SELECT * FROM szkolenia WHERE zrobione=0 ORDER BY kiedy_koniec";

if($rezultat = @$polaczenie->query($sql))
{
    $ile_zdarzen = $rezultat->num_rows;
    $wiersz = $rezultat->fetch_assoc();
    for($i=0;$i<$ile_zdarzen;$i++){
        $jednostka=$wiersz['jednostka'];
        $ilosc=$wiersz['ilosc'];
        $wioska=$wiersz['wioska'];
        $mecz=$wiersz['mecz'];
        $id=$wiersz['id'];
        $koniec_szkolenia=$wiersz['kiedy_koniec'];
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
if($_SESSION['link']==0){
header('Location: '.$kolejne_przejscie.'.php');
}
else{
    $przekierowanie=$_SESSION['link'];
    $_SESSION['link']=0; 
    header('Location: '.$przekierowanie.'.php');   
}
$polaczenie->close();

?>