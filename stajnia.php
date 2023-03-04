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
        if(isset($_SESSION['surowce_malo'])){
            if($_SESSION['surowce_malo']==1){
                ?>
                <script>
                alert("Za mało surowców!");
                </script>
                <?php
            }
            $_SESSION['surowce_malo']=0;
        }
        }
    ?>
    </h2>
        </div>
        <br><br><br>
        <h4>SUROWCE</h4>
        <div id="zegar"></div>
        <script>
 function ile_kawalerzystow(){
    document.getElementById("kawalerzysta_ilosc").submit();
}
function ile_lucznikowkonnych(){
    document.getElementById("lucznikkonny_ilosc").submit();
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
 $sql = "SELECT * FROM wojsko WHERE nazwa='Kawalerzysta' OR nazwa='Lucznikkon'";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $wiersz_kawalerzysta = $rezultat2->fetch_assoc();
     $wiersz_lucznikkon = $rezultat2->fetch_assoc();
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
        <div class="nazwa_budynku"> Stajnia </div>
        <div class="wojsko_ramka"> Kawalerzysta
        <div class="budynek_budowa">
        <ul class="koszty_w">
             <li>   Żywność <?php echo $wiersz_kawalerzysta['zywnosc']; ?></li>
             <li>   Drewno <?php echo $wiersz_kawalerzysta['drewno']; ?></li>
             <li>   Metal <?php echo $wiersz_kawalerzysta['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_kawalerzysta['pieniadze']; ?></li>
             <li>  <form id="kawalerzysta_ilosc" action="szkolenie/kawalerzysta.php" method="POST"> Ilość            
            <input type="number" name="kawaler_ilosc"  id='kawalerzysta' required /></form></li>
        </ul> 
        <div class="budowa" onclick="ile_kawalerzystow()">TRENUJ  </div> 
        </div>
        </div>   
        <div class="wojsko_ramka"> Łucznik na koniu
        <div class="budynek_budowa">
        <ul class="koszty_w">
             <li>   Żywność <?php echo $wiersz_lucznikkon['zywnosc']; ?></li>
             <li>   Drewno <?php echo $wiersz_lucznikkon['drewno']; ?></li>
             <li>   Metal <?php echo $wiersz_lucznikkon['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_lucznikkon['pieniadze']; ?></li>
             <li>  <form id="lucznikkonny_ilosc" action="szkolenie/lucznikkon.php" method="POST"> Ilość            
            <input type="number" name="lucznikkon_ilosc"  id='lucznikkon' required /></form></li>
        </ul> 
        <div class="budowa" onclick="ile_lucznikowkonnych()">TRENUJ  </div>    
        </div>       
        </div>

    <br><br>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Kawalerzysta</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_kawalerzysta['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_kawalerzysta['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_kawalerzysta['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_jednostki['kawalerzysta']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/kawalerzysta.png">
<div class="koniec"></div>
    </div>
    <br><br>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Łucznik na koniu</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_lucznikkon['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_lucznikkon['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_lucznikkon['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_jednostki['lucznikkon']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/lucznik_konny.jpg">
<div class="koniec"></div>
    </div>
    <br> <br> 
    
    </div>
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2022</p>
        </footer>
    
</body>

</html>