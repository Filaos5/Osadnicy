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

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Osadnicy</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body class="body" onload="odliczanie();">
    <Header class="header">
        <h1 id="naglowek"> Osadnicy</h1>


    </Header>
    
        <a href="mapa_pomoc.php">
        <div class="powrot">Powrót</div></a>
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
        <div id="zegar"></div>
        <script>
function ile_wojska(){
    document.getElementById("wojska_ilosc").submit();
    
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

$id_user=$_SESSION['id_sesji'];
$id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
$id_meczu=$_SESSION['mecz_przeslany'];
$id_wioski=$_SESSION['id_wioski'];
/*
if(isset($_SESSION['wioska_pozycja'])){
    if($_SESSION['wioska_pozycja']<0)
    {
        $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
    }
}
else{
    $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
}
*/
$_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
$wioska_pozycja=(int)$_SESSION['wioska_pozycja'];
$pobranyczas = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
if($rezultat = $polaczenie->query($pobranyczas))
{
    $ilu_userow = $rezultat->num_rows;
    $wiersz = $rezultat->fetch_assoc();
   
}
$pobranyczas=$wiersz['czas'];
$czas=time();
$zmiana=$czas-(int)$pobranyczas;  
$pozycja_x=((int)$wioska_pozycja)%20;
$pozycja_y=((((int)$wioska_pozycja)-$pozycja_x)/20)+1;
$pozycja_x=$pozycja_x+1;
 $sql = "SELECT * FROM wioska WHERE id_uczestnika=$id_uczestnik_zalogowany AND mecz=$id_meczu AND pozycjax=$pozycja_x AND pozycjay=$pozycja_y";
 if($rezultat3 = $polaczenie->query($sql))
 {
     $wioska_budynki = $rezultat3->fetch_assoc();
 }
 $id_wioski_cel=$wioska_budynki['id'];
 $lotnisko_cel=$wioska_budynki['lotnisko'];
 $_SESSION['wioska_cel']=$id_wioski_cel;
 echo 'zrodlo '. $id_wioski.' cel '. $id_wioski_cel;
 $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
 if($rezultat4 = @$polaczenie->query($sql))
 {
     $wioska_wojska = $rezultat4->fetch_assoc();
 }
 $lotnisko_zrodlo=$wioska_wojska['lotnisko'];
 $polaczenie->close();
 }
 ?>
    <br>
    <div class="container">
        <div class="nazwa_budynku"> Jednostki</div>
        <br>
        
        <form id="wojska_ilosc" action="pomoc.php" method="POST">
    <div class="wojsko_atak">
    <div class="b_budowa3"> Miecznik
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['miecznik']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="miecznik_ilosc"  id='miecznik' required /></li>

        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Łucznik
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['lucznik']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="lucznik_ilosc"  id='lucznik' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Kawalerzysta
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['kawalerzysta']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="kawalerzysta_ilosc"  id='kawalerzysta' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Łucznik na koniu
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['lucznikkon']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="lucznikkon_ilosc"  id='lucznikkon' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Żołnierz z karabinem
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['karabin']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="karabin_ilosc"  id='karabin' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Armata
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['armata']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="armata_ilosc"  id='armata' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Czołg
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['czolg']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="czolg_ilosc"  id='czolg' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Żołnierz z karabinem maszynowym
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['karabinmaszynowy']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="karabinmaszynowy_ilosc"  id='karabinmaszynowy' required /></li>
        </ul> 
    </div>
    <?php if($lotnisko_zrodlo>0 && $lotnisko_cel>0 ){?>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Mustang
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['mustang']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="mustang_ilosc"  id='mustang' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> F-35
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['F35']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="F35_ilosc"  id='F35' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Northrop B-2
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['northropB2']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="northropB2_ilosc"  id='northropB2' required /></li>
        </ul> 
    </div>
    <div class="wojsko_atak">
    <div class="b_budowa3"> Tomahawk
        </div>       
        <ul class="przesyl_wojska">
             <li>   Dostępne <?php echo $wioska_wojska['tomahawk']; ?></li>
             <li>  Wysyłana ilość <input type="number" name="tomahawk_ilosc"  id='tomahawk' required /></li>
        </ul> 
    </div>
    <?php }?>
    </form>
    <br> <br> 
    <div class=tworzenie onclick="ile_wojska()"> Przekaż pomoc</div> 
    </div>
  
    <br> <br> 
    
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2022 </p>
        </footer>
    
</body>

</html>