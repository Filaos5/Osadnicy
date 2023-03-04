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
        <h1 id="naglowek"> Osadnicy</h1>


    </Header>

    <div class="container">
    <a href="tworzenie_meczu.php">
        <div class="powrot">Powrot</div></a>
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
        <br><br><br>
        <script>
 function sprawdz_pozycja(id){
    zmiennajava = id;
    document.getElementById("nazmienna").value = zmiennajava;
    document.getElementById("pozycja_form").submit();
}
</script>
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

$id_uzytkownik=$_SESSION['id_sesji'];
echo $_SESSION['mecz_przeslany'];
$id_meczu=$_SESSION['mecz_przeslany'];
$sql = "SELECT * FROM uczestnicy WHERE id_user='$id_uzytkownik' AND mecz='$id_meczu'";
if($rezultat2 = @$polaczenie->query($sql))
{
   $ilu_uczestnikow = $rezultat2->num_rows;
   if($ilu_uczestnikow>0){
       $uczestnik = $rezultat2->fetch_assoc();
       $_SESSION['id_zalogowanego_uczestnika']=$uczestnik['id'];
       }
    }
$id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
//echo $_POST['mPozycja'];
echo $_SESSION['id_zalogowanego_uczestnika'];
/*
if(isset($_SESSION['uzytkownik_przeslany'])){
    if($_SESSION['uzytkownik_przeslany']==0)
    {
        $_SESSION['uzytkownik_przeslany']=$_POST['mPozycja'];
    }
}
else{
    $_SESSION['uzytkownik_przeslany']=$_POST['mPozycja'];
}
$_SESSION['uzytkownik_przeslany']=$_POST['mPozycja'];
*/
//echo $_SESSION['uzytkownik_przeslany'];
 $uzytkownik_przeslany=$_SESSION['id_zalogowanego_uczestnika'];
 if(isset($_SESSION['mecz_przeslany'])){
    if($_SESSION['mecz_przeslany']==0)
    {
        header('Location: moje_konto.php');
    }
}
else{
    header('Location: moje_konto.php');
}

 $sql = "SELECT * FROM uzytkownicy WHERE id=$id_uzytkownik";
 //$sql=0;
 if($rezultat = $polaczenie->query($sql))
 {
     //$ilu_userow = $rezultat->num_rows;
     $wiersz = $rezultat->fetch_assoc();
     $login_gracza=$wiersz['login'];
 }
 $_SESSION['uzytkownik_przeslany']=$id_uzytkownik;
 ?>

    <h4>Mapa mecz numer <?php echo $id_meczu ?></h4>
    <div class="objasnienia"> <?php echo $login_gracza ?> zaznacz gdzie chcesz mieć wioskę.</div>
    <div class="tabela">
        <?php
        $sql = "SELECT * FROM wioska WHERE mecz=$id_meczu";
        if($rezultat = $polaczenie->query($sql))
        {
            echo $id_uczestnik_zalogowany;
            for($y=0;$y<20;$y++){
                ?>
                <div class="wiersz">         
                    <?php
                    for($x=0;$x<20;$x++){
                    $wiersz = $rezultat->fetch_assoc();
                    if($wiersz['id_uczestnika']==0){
                    ?>		  
                <div class="pole" onclick="sprawdz_pozycja(id)" id=<?php echo $y*20+$x;?>>
                </div>
                <?php
                }
                if($wiersz['id_uczestnika']>0){
                if($wiersz['id_uczestnika']!=$id_uczestnik_zalogowany){
                    echo $wiersz['id_uczestnika'];
                ?>		  
                <div class="przeciwnik2" id=<?php echo $y*20+$x;?>>
                </div>
                <?php
                }
                else if($wiersz['id_uczestnika']==$id_uczestnik_zalogowany){
                    echo $wiersz['id_uczestnika'];
                ?>		  
                <div class="moja2" id=<?php echo $y*20+$x;?>>
                </div>
                <?php  
                }}} 
                ?>	 
                </div>
                <?php
                }
                ?>	
                </div>
                <?php
        }
        $polaczenie->close();
    }
        ?>
    </div>
    </div>  
    <br> <br> 
    <form id="pozycja_form" action="dodaj_wioske.php" method="POST">
<input type="hidden" name="wioska_Pozycja"  id='nazmienna' required /><br />
<script>
document.getElementById("nazmienna").value = zmiennajava;</script>
</form>
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2022 </p>
        </footer>
    
</body>

</html>