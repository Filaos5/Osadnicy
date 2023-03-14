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
?>
<script type="text/javascript" src="timer.js"></script>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Osadnicy</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
    
<body class="body">
    <Header class="header">
    <div class="tlo">
        <br>
        <div class="tresc_tlo">
            <div id="naglowek_na_tle">
            <h1 id="naglowek"> Osadnicy</h1>
            </div>
        </div>
        </div>  
        
    </Header>

    <div class="container">
    <a href="moje_konto.php">
        <div class="powrot">Moje konto</div></a>
        <div class="wylogowanie">
    <h2>
        <?php
       if(isset($_SESSION['login'])){
        echo "Użytkownik  ". $_SESSION['login'];
        ?>
        <a href="wyloguj.php">
            <div class="tilelink2">Wyloguj się
       </div>

        </a>
        <?php
        }
    ?>
    </h2>
        </div>
        <br><br>
        <?php
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
$_SESSION['uzytkownik_przeslany']==-1;
if(isset($_SESSION['mecz_przeslany'])){
    if($_SESSION['mecz_przeslany']==-1)
    {
        $_SESSION['mecz_przeslany']=$_POST['mName'];
    }
}
else{
    $_SESSION['mecz_przeslany']=$_POST['mName'];
}
//$_SESSION['mecz_przeslany']=$_POST['mName'];
?>
<script>
 function sprawdz(id){
    zmiennajava = id;
    document.getElementById("nazmienna").value = zmiennajava;
    document.getElementById("gracz_form").submit();
}
function usun(id){
    zmiennajava = id;
    document.getElementById("nazmienna2").value = zmiennajava;
    document.getElementById("gracz_usun_form").submit();
}
</script>

<h4>Mecz <?php echo $_SESSION['mecz_przeslany'] ?></h4>
<div class="objasnienia"> Wybierz uczestników meczu po zatwierdzeniu uczestnictwa nie będzie można edytować ilości graczy.</div>
<?php
$mecz_przeslany=$_SESSION['mecz_przeslany'];
$sql = "SELECT * FROM uczestnicy WHERE mecz='$mecz_przeslany'";
if($rezultat = @$polaczenie->query($sql))
 {
    $ilu_userow = $rezultat->num_rows;
    for($i=0;$i<$ilu_userow;$i++){
    $uczestnik = $rezultat->fetch_assoc();
if($id_user==$uczestnik['id_user']){
    $_SESSION['id_zalogowanego_uczestnika']= $uczestnik['id'];
     }
}}

 $sql = "SELECT * FROM uzytkownicy ";
 if($rezultatu = $polaczenie->query($sql))
 {
     $ilu_userow = $rezultatu->num_rows;
     for($i=0;$i<$ilu_userow;$i++){
     $wiersz = $rezultatu->fetch_assoc();

     $id_uzytkownik= $wiersz['id']; 
     $mecz_przeslany=$_SESSION['mecz_przeslany'];
     $sql = "SELECT * FROM uczestnicy WHERE id_user='$id_uzytkownik' AND mecz='$mecz_przeslany'";
     if($rezultat2 = $polaczenie->query($sql))
     {
        $ilu_uczestnikow = $rezultat2->num_rows;
        if($ilu_uczestnikow<=0){
            //$uczestnik = $rezultat2->fetch_assoc();

 ?>
 <div class="uzytkownik_meczu" onclick="sprawdz(id)" id=<?php echo $wiersz['id'];?>>Użytkownik <?php echo $wiersz['login'];?> </div>
 <?php
    }}
}}
 ?>
 <h4>Gracze biorący udział w meczu</h4>
 <?php
 $sql = "SELECT * FROM uzytkownicy ";
 if($rezultatu = @$polaczenie->query($sql))
 {
     $ilu_userow = $rezultatu->num_rows;
     for($i=0;$i<$ilu_userow;$i++){
     $uzytkownik = $rezultatu->fetch_assoc();
     $id_uzytkownik= $uzytkownik['id']; 
     $sql = "SELECT * FROM uczestnicy WHERE id_user='$id_uzytkownik' AND mecz='$mecz_przeslany'";
     if($rezultat2 = @$polaczenie->query($sql))
     {
        $ilu_uczestnikow = $rezultat2->num_rows;
        if($ilu_uczestnikow>0){
            $uczestnik = $rezultat2->fetch_assoc();
            if($_SESSION['id_zalogowanego_uczestnika']!=$uczestnik['id']){

 ?>

 
 <div class="uzytkownik_meczu" onclick="usun(id)" id=<?php echo $uzytkownik['id'];?>>Użytkownik <?php echo $uzytkownik['login'];?> </div>
 <?php
 }
 if($_SESSION['id_zalogowanego_uczestnika']==$uczestnik['id']){
 ?>
 <div class="ramka">
 <div class="objasnienia"> Założyciel meczu</div>
 <div class="uzytkownik_meczu"  id=<?php echo $uzytkownik['id'];?>>Użytkownik <?php echo $uzytkownik['login'];?> </div>
 </div>
 <?php
}}}}}

 $sql = "SELECT * FROM uczestnicy WHERE id_user=$id_user";
 //$sql=0;
 if($rezultat = @$polaczenie->query($sql))
 {
     $ilu_uczestnikow = $rezultat->num_rows;
     $wiersz_uczestnicy = $rezultat->fetch_assoc();
    
 }
 

 $polaczenie->close();
 }

//$_SESSION['mecz_przeslany']=$_POST['mName'];
        ?>
        <br>
        <a href="zatwierdz_mecz.php">
        <div class=tworzenie> Zatwierdź mecz</div>
        </a>
    </div>
    </div> 
    <form id="gracz_form" action="mapa_nowy_mecz.php" method="POST">
<input type="hidden" name="mPozycja"  id='nazmienna' required /><br />
<script>
document.getElementById("nazmienna").value = zmiennajava;</script>
</form>
<form id="gracz_usun_form" action="usuwanie_gracza.php" method="POST">
<input type="hidden" name="mGracz"  id='nazmienna2' required /><br />
<script>
document.getElementById("nazmienna2").value = zmiennajava;</script>
</form>
    <br>
     <br> 
    
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2023</p>
        </footer>
    
</body>

</html>