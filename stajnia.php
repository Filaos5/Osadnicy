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
    <script src="js/vue.js"></script>
    <script src="https://unpkg.com/vue@next"></script>
</head>
<body class="body" onload="odliczanie();">
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
    document.getElementById("lucznikkon_ilosc").submit();
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

 $sql = "SELECT * FROM budynki";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $ilu_userow = $rezultat->num_rows;
     $wiersz_ratusz = $rezultat2->fetch_assoc();
     $wiersz_gospoda = $rezultat2->fetch_assoc();
     $wiersz_tartak = $rezultat2->fetch_assoc();
     $wiersz_kuznia = $rezultat2->fetch_assoc();
     $wiersz_kamienilom = $rezultat2->fetch_assoc();
     $wiersz_dom = $rezultat2->fetch_assoc();
     $wiersz_blok = $rezultat2->fetch_assoc();
     $wiersz_kosciol = $rezultat2->fetch_assoc();
     $wiersz_koszary = $rezultat2->fetch_assoc();
     $wiersz_stajnia = $rezultat2->fetch_assoc();
     $wiersz_huta = $rezultat2->fetch_assoc();
     $wiersz_fabryka = $rezultat2->fetch_assoc();
     $wiersz_lotnisko = $rezultat2->fetch_assoc();
     $wiersz_uniwersytet = $rezultat2->fetch_assoc();
    
 }
 $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
 if($rezultat3 = @$polaczenie->query($sql))
 {
     $wioska_budynki = $rezultat3->fetch_assoc();
     $pobranyczas=$wioska_budynki['czas'];
    $czas=time();
    $zmiana=$czas-(int)$pobranyczas;  
    $predkosc_zywnosc=$wioska_budynki['predkosc_zywnosc'];
    $predkosc_drewno=$wioska_budynki['predkosc_drewno'];
    $predkosc_kamien=$wioska_budynki['predkosc_kamien'];
    $predkosc_metal=$wioska_budynki['predkosc_metal'];
    $predkosc_zl=$wioska_budynki['predkosc_zl'];
 }
 $sql = "SELECT * FROM wojsko WHERE nazwa='Kawalerzysta' OR nazwa='Lucznikkon'";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $wiersz_kawalerzysta = $rezultat2->fetch_assoc();
     $wiersz_lucznikkon = $rezultat2->fetch_assoc();
 }
$sql = "UPDATE wioska SET zywnosc=zywnosc+ $zmiana*$predkosc_zywnosc, drewno =drewno+ $zmiana*$predkosc_drewno,
kamien=kamien+ $zmiana*$predkosc_kamien, metal=metal+ $zmiana*$predkosc_metal, pieniadze=pieniadze+ $zmiana*$predkosc_zl,
czas=$czas WHERE id=$id_wioski";
@$polaczenie->query($sql);
 
 }
 ?>
<script>
        window.onload = surowce_odliczac;
        var zywnosc_liczba = <?php echo $wioska_budynki['zywnosc']; ?>;
        var drewno_liczba = <?php echo $wioska_budynki['drewno']; ?>;
        var kamien_liczba = <?php echo $wioska_budynki['kamien']; ?>;
        var metal_liczba = <?php echo $wioska_budynki['metal']; ?>;
        var zl_liczba = <?php echo $wioska_budynki['pieniadze']; ?>;
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
        <?php

        $sql_x = "SELECT * FROM szkolenia WHERE kiedy_koniec>$czas AND zrobione=0 AND wioska=$id_wioski ORDER BY kiedy_koniec";
   // $polaczenie->query($sql);
    if($rezultat_x = @$polaczenie->query($sql_x))
    {
        $ile_szkolen = $rezultat_x->num_rows;
        for($i=0;$i<$ile_szkolen;$i++){
            $wiersz_p = $rezultat_x->fetch_assoc();
            $ilosc=$wiersz_p['ilosc'];
            $jednostka=$wiersz_p['jednostka'];
            if($jednostka=='kawalerzysta' || $jednostka=='lucznikkon'){
            ?>
            <div class="budynek_budowa2">

        <?php
        if($jednostka="lucznikkon"){
            echo "Szkolenie: łucznik na koniu ilość: ",$ilosc;  
        }
        else{
    echo "Szkolenie: ", $jednostka," ilość: ",$ilosc; 
        }
    ?>
    </div>
    <?php
        }
    }
    }
    $polaczenie->close();
        ?>
        <div class="wojsko_ramka"> Kawalerzysta
        <div class="budynek_budowa">
        <ul class="koszty_w">
             <li>   Żywność <?php echo $wiersz_kawalerzysta['zywnosc']; ?></li>
             <li>   Drewno <?php echo $wiersz_kawalerzysta['drewno']; ?></li>
             <li>   Metal <?php echo $wiersz_kawalerzysta['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_kawalerzysta['pieniadze']; ?></li>
             <li>  <form id="kawalerzysta_ilosc" action="szkolenie/zapis_do_bazy_stajnia.php" method="POST"> Ilość            
            <input type="number" name="kawaler_ilosc" value="0" id='kawalerzysta' required /></li>
        </ul> 
        </div>
        </div>   
        <div class="wojsko_ramka"> Łucznik na koniu
        <div class="budynek_budowa">
        <ul class="koszty_w">
             <li>   Żywność <?php echo $wiersz_lucznikkon['zywnosc']; ?></li>
             <li>   Drewno <?php echo $wiersz_lucznikkon['drewno']; ?></li>
             <li>   Metal <?php echo $wiersz_lucznikkon['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_lucznikkon['pieniadze']; ?></li>     
             <li>   Ilość     
            <input type="number" name="lucznikkon_ilosc" value="0" id='lucznikkon' required /></li>
        </ul> 
     
         
           
        </div>       
        </div>
        <center><button class="button-2" type="submit" name="rejestracja" id="przycisk" >TRENUJ</button></center>
        </form>  
    <br><br>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Kawalerzysta</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_kawalerzysta['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_kawalerzysta['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_kawalerzysta['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_budynki['kawalerzysta']; ?></div>
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
<div class="jednostka_opis">Ilość: <?php echo $wioska_budynki['lucznikkon']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/lucznik_konny.jpg">
<div class="koniec"></div>
    </div>
    <br> <br> 
    
    </div>
        <footer class="footer">
        <p><div id="tekst">
            <div id='app' class='content' ><h3>{{title}} {{name}} {{year}}</h3></div>
    <script>var data = new Date();
    x=data.getFullYear()
    const TestApp = {  data(){  
      return {     title: 'Copyright: ',     year: x,    name: 'Filip Sawicki',    } }}
      Vue.createApp(TestApp).mount('#app')</script>
            </div></p>
        </footer>
    
</body>

</html>