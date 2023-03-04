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
        <a href="wioska.php">
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
        <h4>SUROWCE</h4>
        <div id="zegar"></div>
        <script>
 function ile_armat(){
    document.getElementById("armaty_ilosc").submit();
}
function ile_czolgow(){
    document.getElementById("czolgi_ilosc").submit();
}
function ile_mustangow(){
    document.getElementById("mustangi_ilosc").submit();
}
function ile_dziallot(){
    document.getElementById("dzialolot_ilosc").submit();
}
function ile_f35(){
    document.getElementById("f35_ilosc").submit();
}
function ile_patriot(){
    document.getElementById("patriot_ilosc").submit();
}
function ile_northrop(){
    document.getElementById("northrop_ilosc").submit();
}
function ile_tomahawk(){
    document.getElementById("tomahawk_ilosc").submit();
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
$pobranyczas = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
if($rezultat = @$polaczenie->query($pobranyczas))
{
    $ilu_userow = $rezultat->num_rows;
    $wiersz = $rezultat->fetch_assoc();
   
}
$pobranyczas=$wiersz['czas'];
$czas=time();
$zmiana=$czas-(int)$pobranyczas;  
$predkosc_zywnosc=$wiersz['predkosc_zywnosc'];
$predkosc_drewno=$wiersz['predkosc_drewno'];
$predkosc_kamien=$wiersz['predkosc_kamien'];
$predkosc_metal=$wiersz['predkosc_metal'];
$predkosc_zl=$wiersz['predkosc_zl'];
$sql = "UPDATE uczestnicy SET zywnosc=zywnosc+ $zmiana*$predkosc_zywnosc, drewno =drewno+ $zmiana*$predkosc_drewno,
kamien=kamien+ $zmiana*$predkosc_kamien, metal=metal+ $zmiana*$predkosc_metal, pieniadze=pieniadze+ $zmiana*$predkosc_zl,
czas=$czas WHERE id=$id_uczestnik_zalogowany";
$polaczenie->query($sql);
 $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
 if($rezultat = @$polaczenie->query($sql))
 {
     $ilu_userow = $rezultat->num_rows;
     $wiersz = $rezultat->fetch_assoc();
    
 }
$predkosc_zywnosc=$wiersz['predkosc_zywnosc'];
$predkosc_drewno=$wiersz['predkosc_drewno'];
$predkosc_kamien=$wiersz['predkosc_kamien'];
$predkosc_metal=$wiersz['predkosc_metal'];
$predkosc_zl=$wiersz['predkosc_zl'];
 $sql = "SELECT * FROM wojsko WHERE nazwa='Armata' OR nazwa='Czolg' OR nazwa='Mustang' OR nazwa='Dzialolot' 
 OR nazwa='F-35' OR nazwa='Patriot' OR nazwa='NorthropB2' OR nazwa='Tomahawk'";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $wiersz_armata = $rezultat2->fetch_assoc();
     $wiersz_czolg = $rezultat2->fetch_assoc();
     $wiersz_mustang = $rezultat2->fetch_assoc();
     $wiersz_dzialolot = $rezultat2->fetch_assoc();
     $wiersz_f35 = $rezultat2->fetch_assoc();
     $wiersz_patriot = $rezultat2->fetch_assoc();
     $wiersz_northrop = $rezultat2->fetch_assoc();
     $wiersz_tomahawk = $rezultat2->fetch_assoc();
 }
 $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
 if($rezultat3 = @$polaczenie->query($sql))
 {
     $wioska_jednostki = $rezultat3->fetch_assoc();
 }
 $polaczenie->close();
 }
 ?>
<script>
        window.onload = surowce_odliczac;
        var zywnosc_liczba = <?php echo $wiersz['zywnosc']; ?>;
        var drewno_liczba = <?php echo $wiersz['drewno']; ?>;
        var kamien_liczba = <?php echo $wiersz['kamien']; ?>;
        var metal_liczba = <?php echo $wiersz['metal']; ?>;
        var zl_liczba = <?php echo $wiersz['pieniadze']; ?>;
        var predkosc_zywnosc = <?php echo $predkosc_zywnosc; ?>;
        var predkosc_drewno = <?php echo $predkosc_drewno; ?>;
        var predkosc_kamien = <?php echo $predkosc_kamien; ?>;
        var predkosc_metal = <?php echo $predkosc_metal; ?>;
        var predkosc_zl = <?php echo $predkosc_zl; ?>;
    function surowce_odliczac()
        {
            zywnosc_liczba = zywnosc_liczba+predkosc_zywnosc;
            drewno_liczba = drewno_liczba+predkosc_drewno;
            kamien_liczba = kamien_liczba+predkosc_kamien;
            metal_liczba = metal_liczba+predkosc_metal;
            zl_liczba = zl_liczba+predkosc_zl;
            document.getElementById("zywnosc").innerHTML = zywnosc_liczba ;
            document.getElementById("drewno").innerHTML = drewno_liczba ;
            document.getElementById("kamien").innerHTML = kamien_liczba ;
            document.getElementById("metal").innerHTML = metal_liczba ;
            document.getElementById("zl").innerHTML = zl_liczba ;
            setTimeout("surowce_odliczac()",1000);
        }
</script>
        <div class="surowce">
            <ul class="surowiec">
             <li>   Żywność:<div id="zywnosc"></div></li>
             <li>   Drewno:<div id="drewno"></div></li>
             <li>   Kamień:<div id="kamien"></div></li>
             <li>   Metal:<div id="metal"></div></li>
             <li>   Złotówki:<div id="zl"></div></li>
    </ul>
    </div>
    <div class="container">
    <br>  
        <div class="nazwa_budynku"> Lotnisko </div>
    <br>
    <h3>Dostępne wysyłanie ataków lotniczych</h3><br>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Mustang</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_mustang['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_mustang['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_mustang['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_jednostki['mustang']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/Mustang.jpg">
<div class="koniec"></div>
    </div>
    <br> <br>  
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">F-35</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_f35['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_f35['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_f35['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_jednostki['F35']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/f-35.jpg">
<div class="koniec"></div>
    </div>
    <br> <br>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Northrop B2 Spirit</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_northrop['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_northrop['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_northrop['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_jednostki['northropB2']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/northrop_b2.jpg">
<div class="koniec"></div>
    </div>
    <br> <br>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Tomahawk</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_tomahawk['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_tomahawk['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_tomahawk['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_jednostki['tomahawk']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/tomahawk.png">
<div class="koniec"></div>
    </div>
    <br> <br>   
    </div>
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2022</p>
        </footer>
    
</body>

</html>